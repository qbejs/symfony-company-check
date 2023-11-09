<?php

namespace App\Domain\Models\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;

class CompanyDTO implements RequestDtoInterface
{
    public $name;
    public $regon;
    public $krs;
    public $nip;
    public $voivodeship;
    public $city;
    public $street;
    public $houseNumber;
    public $foundationDate;
    public $zipCode;
    public $type;

    public function __construct(
        string $name,
        string $regon,
        string $nip,
        string $voivodeship,
        string $city,
        string $street,
        string $houseNumber,
        string $zipCode,
        string $type,
        string $krs,
        string $foundationDate
    ) {
        $this->name = $name;
        $this->regon = $regon;
        $this->krs = null;
        $this->nip = $nip;
        $this->voivodeship = $voivodeship;
        $this->city = $city;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->foundationDate = null;
        $this->zipCode = $zipCode;
        $this->type = $type;
    }
}
