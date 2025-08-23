<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductRepositoryInterface $products) {}

    public function index(Request $request): JsonResponse
    {
        $items = $this->products->all();

        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        $paginator = new LengthAwarePaginator(
            array_slice($items, ($page - 1) * $perPage, $perPage),
            count($items),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->products->find($id);

        return response()->json([
            'data' => $product,
        ]);
    }
}
