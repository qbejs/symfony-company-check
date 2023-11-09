<?php

namespace App\Application\RegonCheck\QueryHandler;

use App\Application\RegonCheck\Query\GetVerifiedCompaniesQuery;
use App\Application\RegonCheck\Service\RegonCheckService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetVerifiedCompaniesQueryHandler
{
    public function __construct(private readonly RegonCheckService $checkService)
    {
    }

    public function __invoke(GetVerifiedCompaniesQuery $query): array
    {
        return $this->checkService->getVerifiedCompanies($query->page, $query->limit);
    }
}
