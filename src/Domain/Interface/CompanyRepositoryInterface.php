<?php

namespace App\Domain\Interface;

use App\Domain\Models\Company;

interface CompanyRepositoryInterface
{
    public function find(int $id): ?Company;

    public function findAll(): array;

    public function save(Company $company): void;

    public function delete(Company $company): void;

    public function findByTypeAndNumber(string $type, string $number): ?Company;
}
