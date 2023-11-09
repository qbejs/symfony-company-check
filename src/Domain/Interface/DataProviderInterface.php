<?php

namespace App\Domain\Interface;

use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Domain\Models\ValueObject\Company\CompanyKrs;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;

interface DataProviderInterface
{
    /** @return CreateCompanyDTO[] */
    public function checkCompany(CompanyRegon|CompanyKrs|CompanyNip $number): array;

    public function isSupported(string $type): bool;
}
