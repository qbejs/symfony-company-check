<?php

namespace App\Infrastructure\Validator\Constraint;

#[\Attribute]
class KrsNumber
{
    public $message = 'The KRS number "{{ string }}" is not a valid.';
}
