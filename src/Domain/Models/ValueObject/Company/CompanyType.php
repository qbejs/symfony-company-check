<?php

namespace App\Domain\Models\ValueObject\Company;

class CompanyType
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getValue(): string
    {
        return $this->type;
    }
}
