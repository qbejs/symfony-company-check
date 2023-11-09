<?php

namespace App\Domain\Models\DTO;

use App\Infrastructure\Validator\Constraint\KrsNumber;
use App\Infrastructure\Validator\Constraint\NipNumber;
use App\Infrastructure\Validator\Constraint\RegonNumber;
use Prugala\RequestDto\Dto\RequestDtoInterface;

class CreateCompanyDTO implements RequestDtoInterface
{
    public string $name;
    public string $street;
    public string $houseNumber = '';

    public string $city;
    public string $zipCode;
    public string $province;
    #[RegonNumber]
    public string $regon;
    #[NipNumber]
    public string $nip;
    #[KrsNumber]
    public ?string $krs = null;
    public string $type;

    public function __construct(
        string $name,
        string $street,
        string $city,
        string $zipCode,
        string $province,
        string $regon,
        string $nip,
        string $type,
        string $krs = null,
        string $foundingDate = null
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->province = $province;
        $this->regon = $regon;
        $this->nip = $nip;
        $this->krs = $krs;
        $this->type = $type;
        $this->foundingDate = $foundingDate;
    }
    public ?string $foundingDate = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getProvince(): string
    {
        return $this->province;
    }

    public function getRegon(): string
    {
        return $this->regon;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function getKrs(): string
    {
        return $this->krs;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFoundingDate(): ?string
    {
        return $this->foundingDate;
    }
}
