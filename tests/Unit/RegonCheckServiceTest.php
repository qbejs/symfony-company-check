<?php

namespace App\Tests\Unit;

use App\Application\RegonCheck\Command\CreateCompanyCommand;
use App\Application\RegonCheck\Service\RegonCheckService;
use App\Domain\Interface\CompanyRepositoryInterface;
use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Infrastructure\DataProviders\DataProviderManager;
use App\Infrastructure\Exception\LockedResponseException;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class RegonCheckServiceTest extends TestCase
{
    public function testCheckCompany()
    {
        $companyRepository = $this->createMock(CompanyRepositoryInterface::class);
        $paginator = $this->createMock(PaginatorInterface::class);
        $dataProviderManager = $this->createMock(DataProviderManager::class);
        $messageBus = $this->createMock(MessageBusInterface::class);
        $lockFactory = $this->createMock(LockFactory::class);
        $lock = $this->createMock(LockInterface::class);

        $service = new RegonCheckService($companyRepository, $paginator, $dataProviderManager, $messageBus, $lockFactory);

        // Create a CreateCompanyDTO object
        $dto = new CreateCompanyDTO(
            'Shine Clinic Jakub Skowron', // name
            'ul. Powstańców Warszawy', // street
            'Skarżysko-Kamienna', // city
            '26-110', // zipCode
            'ŚWIĘTOKRZYSKIE', // province
            '260780605', // regon
            '6631777942', // nip
            'OSOBA FIZYCZNA PROWADZĄCA DZIAŁALNOŚĆ GOSPODARCZĄ' // type
        );

        // Configure the stubs
        $companyRepository->method('findByTypeAndNumber')->willReturn(null);
        $lockFactory->method('createLock')->willReturn($lock);
        $lock->method('acquire')->willReturn(true);
        $dataProviderManager->method('checkCompany')->willReturn([$dto]);

        // Expect the dispatch method to be called with CreateCompanyCommand objects
        $messageBus->expects($this->exactly(1))
            ->method('dispatch')
            ->with($this->callback(function ($command) {
                return $command instanceof CreateCompanyCommand;
            }))
            ->willReturnCallback(function ($command) {
                return new \Symfony\Component\Messenger\Envelope($command);
            });

        // Assert that the service returns true when the company is checked
        $this->assertTrue($service->checkCompany('type', 'number'));
    }

    public function testGetResultFromMessage()
    {
        $companyRepository = $this->createMock(CompanyRepositoryInterface::class);
        $paginator = $this->createMock(PaginatorInterface::class);
        $dataProviderManager = $this->createMock(DataProviderManager::class);
        $messageBus = $this->createMock(MessageBusInterface::class);
        $lockFactory = $this->createMock(LockFactory::class);

        $service = new RegonCheckService($companyRepository, $paginator, $dataProviderManager, $messageBus, $lockFactory);

        $envelope = new Envelope(new \stdClass(), [new HandledStamp('result', 'handler')]);

        $this->assertEquals('result', $service->getResultFromMessage($envelope));
    }
}
