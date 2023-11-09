<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class KrsNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$this->isKrsValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    private function isKrsValid(string $krs): bool
    {
        $krs = preg_replace('/\D/', '', $krs);

        if (10 !== strlen($krs)) {
            return false;
        }

        if (!str_starts_with($krs, '0000')) {
            return false;
        }

        if (0 === intval(substr($krs, 4))) {
            return false;
        }

        return true;
    }
}
