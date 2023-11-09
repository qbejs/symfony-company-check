<?php

namespace App\Domain\Models\DTO;

use App\Infrastructure\Validator\Constraint\KrsNumber;
use App\Infrastructure\Validator\Constraint\NipNumber;
use App\Infrastructure\Validator\Constraint\RegonNumber;
use Prugala\RequestDto\Dto\RequestDtoInterface;

class ValidateCompanyDTO implements RequestDtoInterface
{
    #[RegonNumber]
    public ?string $regon = null;
    #[KrsNumber]
    public ?string $krs = null;
    #[NipNumber]
    public ?string $nip = null;
}
