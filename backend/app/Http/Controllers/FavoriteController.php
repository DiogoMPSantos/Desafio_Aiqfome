<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteAddRequest;
use App\Models\Client;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use App\Services\ProductCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FavoriteController extends Controller
{
    public function __construct(
        private FavoriteRepositoryInterface $favorites,
        private ProductCatalogService $catalog
    ) {}

    public function index(int $client): JsonResponse
    {
        $model = Client::find($client);
        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json($this->favorites->listByClient($model));
    }

    public function store(FavoriteAddRequest $request, int $client): JsonResponse
    {
        $model = Client::find($client);
        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $productId = (string) $request->validated()['product_id'];

        if ($this->favorites->findByClientAndProduct($model, $productId)) {
            throw ValidationException::withMessages([
                'product_id' => ['This product is already in client favorites.']
            ]);
        }

        $external = $this->catalog->getProductOrFail($productId);

        $payload = [
            'product_id' => $external['product_id'],
            'title'      => $external['title'],
            'image'      => $external['image'],
            'price'      => $external['price'],
            'review'     => $external['review'],
        ];

        $favorite = $this->favorites->add($model, $payload);

        return response()->json($favorite, 201);
    }

    public function destroy(int $client, string $productId): JsonResponse
    {
        $model = Client::find($client);
        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $fav = $model->favorites()->where('product_id', $productId)->first();

        if (!$fav) {
            return response()->json(
                ['message' => 'Product not found in favorites'], 404);
        }

        $this->favorites->remove($model, $productId);

        return response()->json([], 204);
    }
}
