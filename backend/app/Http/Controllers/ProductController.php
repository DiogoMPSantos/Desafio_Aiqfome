<?php

namespace App\Http\Controllers;

use App\Services\ProductCatalogService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductCatalogService $service)
    {
    }

    public function index(): JsonResponse
    {
        $products = $this->service->listAll();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->service->getProductOrFail($id);

        return response()->json([
            'data' => $product,
        ]);
    }
}
