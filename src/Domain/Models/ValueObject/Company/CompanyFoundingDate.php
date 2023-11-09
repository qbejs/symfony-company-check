<?php

namespace App\Domain\Models\ValueObject\Company;

class CompanyFoundingDate
{
    private \DateTimeInterface $foundingDate;

    public function __construct(\DateTimeInterface $foundingDate)
    {
        $this->foundingDate = $foundingDate;
    }

    public function getValue(): \DateTimeInterface
    {
        return $this->foundingDate;
    }
}
