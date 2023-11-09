<?php

namespace App\Application\RegonCheck\Query;

class GetVerifiedCompaniesQuery
{
    public int $page;
    public int $limit;

    public function __construct(int $page = 1, int $limit = 20)
    {
        $this->page = $page;
        $this->limit = $limit;
    }
}
