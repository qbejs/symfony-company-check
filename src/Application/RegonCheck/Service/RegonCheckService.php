<?php

namespace App\Application\RegonCheck\Service;

use App\Application\RegonCheck\Command\CreateCompanyCommand;
use App\Domain\Interface\CompanyRepositoryInterface;
use App\Domain\Interface\ServiceInterface;
use App\Domain\Models\Company;
use App\Infrastructure\DataProviders\DataProviderManager;
use App\Infrastructure\Exception\LockedResponseException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class RegonCheckService implements ServiceInterface
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly PaginatorInterface $paginator,
        private readonly DataProviderManager $dataProviderManager,
        private readonly MessageBusInterface $messageBus,
        private readonly LockFactory $lockFactory,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function checkCompany($type, $number): bool
    {
        $stepOne = $this->companyRepository->findByTypeAndNumber($type, $number);

        if (null !== $stepOne) {
            return true;
        }

        $lock = $this->lockFactory->createLock($number);
        $attempts = 3;

        while (!$lock->acquire(true, 10)) {
            sleep(0.5);
            --$attempts;
        }

        if (0 == $attempts) {
            throw new LockedResponseException();
        }

        $result = $this->dataProviderManager->checkCompany($type, $number);

        if (empty($result)) {
            return false;
        }

        foreach ($result as $company) {
            $this->messageBus->dispatch(new CreateCompanyCommand($company));
        }

        return true;
    }

    public function getVerifiedCompany($id): Company
    {
        return $this->companyRepository->find($id);
    }

    public function getVerifiedCompanies($page, $limit): array
    {
        $data = $this->companyRepository->getVerifiedCompanies($page, $limit);

        $result = $this->paginator->paginate(
            $data,
            $page,
            $limit
        );

        // dd($result->getItems());

        return $result->getItems();
    }

    public function getResultFromMessage(Envelope $message): mixed
    {
        return $message->last(HandledStamp::class)->getResult();
    }
}
