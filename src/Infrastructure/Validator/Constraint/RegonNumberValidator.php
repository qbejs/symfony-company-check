<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RegonNumberValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$this->isRegonValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ number }}', $value)
                ->addViolation();
        }
    }

    private function isRegonValid(string $regon): bool
    {
        $regon = preg_replace('/\D/', '', $regon);

        $length = strlen($regon);
        $weights = [];

        switch ($length) {
            case 7:
                $weights = [2, 3, 4, 5, 6, 7];
                break;
            case 9:
                $weights = [8, 9, 2, 3, 4, 5, 6, 7];
                break;
            case 14:
                $weights = [2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8];
                break;
            default:
                return false;
        }

        $sum = 0;
        for ($i = 0; $i < $length - 1; ++$i) {
            $sum += (int) $regon[$i] * $weights[$i];
        }

        $checksum = $sum % 11;
        $checksum = 10 === $checksum ? 0 : $checksum;

        return $checksum === (int) $regon[$length - 1];
    }
}
