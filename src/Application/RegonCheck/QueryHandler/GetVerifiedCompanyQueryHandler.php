<?php

namespace App\Application\RegonCheck\QueryHandler;

use App\Application\RegonCheck\Query\GetVerifiedCompanyQuery;
use App\Application\RegonCheck\Service\RegonCheckService;
use App\Domain\Models\Company;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetVerifiedCompanyQueryHandler
{
    public function __construct(private readonly RegonCheckService $checkService)
    {
    }

    public function __invoke(GetVerifiedCompanyQuery $query): Company
    {
        return $this->checkService->getVerifiedCompany($query->id);
    }
}
