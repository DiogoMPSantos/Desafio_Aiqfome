<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\ProductCatalogService;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly ProductCatalogService $service) {}

    public function all(): array
    {
        return $this->service->listAll();
    }

    public function find(string $id): array
    {
        return $this->service->getProductOrFail($id);
    }
}
