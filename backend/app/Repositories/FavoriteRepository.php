<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\FavoriteProduct;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function listByClient(Client $client, int $perPage = 15): LengthAwarePaginator
    {
        return $client->favorites()->orderByDesc('id')->paginate($perPage);
    }

    public function add(Client $client, array $payload): FavoriteProduct
    {
        return $client->favorites()->create($payload);
    }

    public function remove(Client $client, string $productId): void
    {
        $fav = $this->findByClientAndProduct($client, $productId);
        if ($fav) {
            $fav->delete();
        }
    }

    public function findByClientAndProduct(Client $client, string $productId): ?FavoriteProduct
    {
        return $client->favorites()->where('product_id', $productId)->first();
    }
}
