<?php

namespace App\Application\RegonCheck\Query;

class GetVerifiedCompanyQuery
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
