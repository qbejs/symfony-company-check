<?php

namespace App\Domain\Models\ValueObject\Company;

use App\Infrastructure\Validator\Constraint\RegonNumber;
use Symfony\Component\Validator\Validation;

class CompanyRegon
{
    private string $regon;

    public function __construct(string $regon)
    {
        $this->validateRegon($regon);
        $this->regon = $regon;
    }

    public function getValue(): string
    {
        return $this->regon;
    }

    private function validateRegon(string $regon): bool
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($regon, [
            new RegonNumber(),
        ]);

        if (0 !== count($violations)) {
            throw new \InvalidArgumentException((string) $violations);
        }

        return true;
    }
}
