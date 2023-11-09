<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NipNumberValidator extends ConstraintValidator
{
    private const WEIGHTS = [6, 5, 7, 2, 3, 4, 5, 6, 7];

    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$this->isNipValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    private function isNipValid(string $nip): bool
    {
        $nip = preg_replace('/\D/', '', $nip);

        if (10 != strlen($nip)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; ++$i) {
            $sum += (int) $nip[$i] * self::WEIGHTS[$i];
        }

        $checksum = $sum % 11;

        // If the checksum is 10, the NIP is invalid
        if (10 == $checksum) {
            return false;
        }

        return $checksum == (int) $nip[9];
    }
}
