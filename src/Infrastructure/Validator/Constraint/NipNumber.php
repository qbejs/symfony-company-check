<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class NipNumber extends Constraint
{
    public string $message = 'Provided NIP number number "{{ value }}" is not valid.';
}
