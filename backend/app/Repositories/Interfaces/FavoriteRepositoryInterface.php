<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\FavoriteProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FavoriteRepositoryInterface
{
    public function listByClient(Client $client, int $perPage = 15): LengthAwarePaginator;
    public function add(Client $client, array $payload): FavoriteProduct;
    public function remove(Client $client, string $productId): void;
    public function findByClientAndProduct(Client $client, string $productId): ?FavoriteProduct;
}
