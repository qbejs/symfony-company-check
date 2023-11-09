<?php

namespace App\Domain\Models\ValueObject\Company;

use App\Infrastructure\Validator\Constraint\KrsNumber;
use Symfony\Component\Validator\Validation;

class CompanyKrs
{
    private string $krs;

    public function __construct(string $krs)
    {
        $this->krs = $krs;
    }

    public function getValue(): string
    {
        return $this->krs;
    }

    private function validateKrs(string $krs): bool
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($krs, [
            new KrsNumber(),
        ]);

        if (0 !== count($violations)) {
            throw new \InvalidArgumentException((string) $violations);
        }

        return true;
    }
}
