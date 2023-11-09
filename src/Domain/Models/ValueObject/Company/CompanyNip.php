<?php

namespace App\Domain\Models\ValueObject\Company;

use App\Infrastructure\Validator\Constraint\NipNumber;
use Symfony\Component\Validator\Validation;

class CompanyNip
{
    private string $nip;

    public function __construct(string $nip)
    {
        $this->validateNip($nip);
        $this->nip = $nip;
    }

    public function getValue(): string
    {
        return $this->nip;
    }

    private function validateNip(string $nip): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($nip, [
            new NipNumber(),
        ]);

        if (0 !== count($violations)) {
            throw new \InvalidArgumentException((string) $violations);
        }
    }
}
