<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RegonNumber extends Constraint
{
    public string $message = 'Provided REGON number "{{ number }}" is not a valid.';
}
