<?php

namespace App\Domain\Models;

use App\Domain\Interface\TimestampInterface;
use App\Domain\Models\ValueObject\Company\CompanyAddress;
use App\Domain\Models\ValueObject\Company\CompanyFoundingDate;
use App\Domain\Models\ValueObject\Company\CompanyId;
use App\Domain\Models\ValueObject\Company\CompanyKrs;
use App\Domain\Models\ValueObject\Company\CompanyName;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;
use App\Domain\Models\ValueObject\Company\CompanyType;
use Symfony\Component\Serializer\Annotation\Groups;

class Company implements TimestampInterface
{
    #[Groups(['company'])]
    private ?CompanyId $id;
    #[Groups(['company'])]
    private CompanyName $name;
    #[Groups(['company'])]
    private CompanyRegon $regon;
    #[Groups(['company'])]
    private CompanyAddress $address;
    #[Groups(['company'])]
    private ?CompanyFoundingDate $foundingDate;
    #[Groups(['company'])]
    private CompanyNip $nip;

    private ?CompanyKrs $krs = null;
    #[Groups(['company'])]
    private CompanyType $type;
    #[Groups(['company'])]
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private ?\DateTimeInterface $deletedAt;

    public function __construct(
        CompanyName $name,
        CompanyRegon $regon,
        CompanyAddress $address,
        CompanyNip $nip,
        CompanyType $type,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $updatedAt,
        ?\DateTimeInterface $deletedAt,
        CompanyId $id = null,
        CompanyFoundingDate $foundingDate = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->regon = $regon;
        $this->address = $address;
        $this->foundingDate = $foundingDate;
        $this->nip = $nip;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): ?CompanyId
    {
        return $this->id;
    }

    public function getName(): CompanyName
    {
        return $this->name;
    }

    public function setName(CompanyName $name): void
    {
        $this->name = $name;
    }

    public function getRegon(): CompanyRegon
    {
        return $this->regon;
    }

    public function setRegon(CompanyRegon $regon): void
    {
        $this->regon = $regon;
    }

    public function getAddress(): CompanyAddress
    {
        return $this->address;
    }

    public function setAddress(CompanyAddress $address): void
    {
        $this->address = $address;
    }

    public function getFoundingDate(): ?CompanyFoundingDate
    {
        return $this->foundingDate;
    }

    public function setFoundingDate(?CompanyFoundingDate $foundingDate): void
    {
        $this->foundingDate = $foundingDate;
    }

    public function getNip(): CompanyNip
    {
        return $this->nip;
    }

    public function setNip(CompanyNip $nip): void
    {
        $this->nip = $nip;
    }

    public function getKrs(): ?CompanyKrs
    {
        return $this->krs;
    }

    public function setKrs(?CompanyKrs $krs): void
    {
        $this->krs = $krs;
    }

    public function getType(): CompanyType
    {
        return $this->type;
    }

    public function setType(CompanyType $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
