<?php

namespace App\Application\RegonCheck\Command;

use App\Domain\Models\DTO\ValidateCompanyDTO;

class CheckCompanyCommand
{
    public string $number;
    public string $type;

    public function __construct(ValidateCompanyDTO $dto)
    {
        if (!$dto->nip && !$dto->krs && !$dto->regon) {
            throw new \Exception('Cannot determine company type. No number provided.');
        }

        if ($dto->nip) {
            $this->number = $dto->nip;
            $this->type = 'nip';
        }

        if ($dto->krs) {
            $this->number = $dto->krs;
            $this->type = 'krs';
        }

        if ($dto->regon) {
            $this->number = $dto->regon;
            $this->type = 'regon';
        }
    }
}
