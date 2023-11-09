<?php

namespace App\Domain\Factory\Interface;

use App\Domain\Models\Company;
use App\Domain\Models\DTO\CreateCompanyDTO;

interface CompanyFactoryInterface
{
    public function createFromDTO(CreateCompanyDTO $dto): Company;
}
