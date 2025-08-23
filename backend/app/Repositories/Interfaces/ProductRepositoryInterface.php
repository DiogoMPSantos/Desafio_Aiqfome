<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all(): array;
    public function find(string $id): array;
}
