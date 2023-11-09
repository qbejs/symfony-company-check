<?php

namespace App\Domain\Factory;

use App\Domain\Factory\Interface\CompanyFactoryInterface;
use App\Domain\Models\Company;
use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Domain\Models\ValueObject\Company\CompanyAddress;
use App\Domain\Models\ValueObject\Company\CompanyName;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;
use App\Domain\Models\ValueObject\Company\CompanyType;

class CompanyFactory implements CompanyFactoryInterface
{
    /**
     * @throws \Exception
     */
    public function createFromDTO(CreateCompanyDTO $dto): Company
    {
        return new Company(
            name: new CompanyName($dto->getName()),
            regon: new CompanyRegon($dto->getRegon()),
            address: new CompanyAddress($dto->getStreet(), $dto->getHouseNumber(), $dto->getZipCode(), $dto->getProvince(), $dto->getCity()),
            nip: new CompanyNip($dto->getNip()),
            type: new CompanyType($dto->getType()),
            createdAt: new \DateTime(),
            updatedAt: new \DateTime(),
            deletedAt: null,
            foundingDate: null === $dto->getFoundingDate() ? null : new \DateTime($dto->getFoundingDate()),
        );
    }
}
