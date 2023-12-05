<?php

namespace App\Application\RegonCheck\EventHandler;

use App\Application\RegonCheck\Event\CreateCompanyEvent;
use App\Domain\Factory\CompanyFactory;
use App\Domain\Interface\CompanyRepositoryInterface;
use App\Domain\Models\DTO\CreateCompanyDTO;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'company.created', method: 'onCompanyCreated')]
class CreateCompanyEventHandler
{
    use LoggerAwareTrait;

    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function onCompanyCreated(CreateCompanyEvent $event): void
    {
        $factory = new CompanyFactory();
        $dto = new CreateCompanyDTO(
            name: $event->name,
            street: $event->street,
            city: $event->city,
            zipCode: $event->zipCode,
            province: $event->province,
            regon: $event->regon,
            nip: $event->nip,
            type: $event->type,
            krs: $event->krs
        );
        $company = $factory->createFromDTO($dto);

        $this->companyRepository->save($company);

        $this->logger->info("Company with ID {$company->getId()} was created.");
    }
}
