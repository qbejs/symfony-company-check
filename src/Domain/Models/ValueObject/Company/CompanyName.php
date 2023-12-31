<?php

namespace App\Domain\Models\ValueObject\Company;

class CompanyName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
