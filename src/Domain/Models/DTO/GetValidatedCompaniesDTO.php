<?php

namespace App\Domain\Models\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;

class GetValidatedCompaniesDTO implements RequestDtoInterface
{
    public int $page = 1;
    public int $limit = 10;
}
