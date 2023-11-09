<?php

namespace App\Application\RegonCheck\Command;

use App\Domain\Models\DTO\CreateCompanyDTO;

class CreateCompanyCommand
{
    public string $name;
    public string $type;
    public string $street;
    public ?string $houseNumber = null;
    public string $city;
    public string $zipCode;
    public string $province;
    public string $regon;
    public string $nip;
    public ?string $krs = null;

    public function __construct(CreateCompanyDTO $dto)
    {
        $this->name = $dto->name;
        $this->type = $dto->type;
        $this->street = $dto->street;
        $this->houseNumber = null;
        $this->city = $dto->city;
        $this->zipCode = $dto->zipCode;
        $this->province = $dto->province;
        $this->regon = $dto->regon;
        $this->nip = $dto->nip;
        $this->krs = $dto->krs;
    }
}
