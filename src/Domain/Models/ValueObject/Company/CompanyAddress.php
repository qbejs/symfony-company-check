<?php

namespace App\Domain\Models\ValueObject\Company;

class CompanyAddress
{
    private string $street;
    private ?string $buildingNumber;
    private string $zipCode;
    private string $province;
    private string $city;

    public function __construct(string $street, ?string $buildingNumber, string $zipCode, string $province, string $city)
    {
        $this->street = $street;
        $this->buildingNumber = $buildingNumber;
        $this->zipCode = $zipCode;
        $this->province = $province;
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getProvince(): string
    {
        return $this->province;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getValue(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s, %s %s, %s',
            $this->street,
            null === $this->buildingNumber ? '' : $this->buildingNumber,
            $this->zipCode,
            $this->city,
            $this->province
        );
    }

    public function equals(CompanyAddress $other): bool
    {
        return $this->street === $other->getStreet()
            && $this->buildingNumber === $other->getBuildingNumber()
            && $this->zipCode === $other->getZipCode()
            && $this->province === $other->getProvince()
            && $this->city === $other->getCity();
    }
}
