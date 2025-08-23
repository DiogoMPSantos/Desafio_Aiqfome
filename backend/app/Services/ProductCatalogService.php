<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ProductCatalogService
{
    private string $baseUrl;
    private int $timeout;
    
    public function __construct() {
        $this->baseUrl = config('services.products.base', env('PRODUCTS_API_BASE', ''));
        $this->timeout = (int) env('PRODUCTS_API_TIMEOUT', 5);
    }


    public function listAll(): array
    {
        try {
            $resp = Http::timeout($this->timeout)
                ->acceptJson()
                ->get(rtrim($this->baseUrl, '/') . '/products');
        } catch (ConnectionException $e) {
            throw ValidationException::withMessages([
                'products' => ['Unable to reach products API.']
            ]);
        }

        if ($resp->failed()) {
            throw ValidationException::withMessages([
                'products' => ['Products API returned an error.']
            ]);
        }

        return $resp->json();
    }

    /**
     * Fetch product by ID in the external API and normalize fields.
     *
     * @throws ValidationException if product is not found or invalid.
     */
    public function getProductOrFail(string $productId): array
    {
        if (!$this->baseUrl) {
            throw ValidationException::withMessages([
                'product_id' => ['Products API base URL not configured.']
            ]);
        }

        try {
            $resp = Http::timeout($this->timeout)
                ->acceptJson()
                ->get(rtrim($this->baseUrl, '/').'/products/'.$productId);
        } catch (ConnectionException $e) {
            throw ValidationException::withMessages([
                'product_id' => ['Unable to reach products API.']
            ]);
        }

        if ($resp->failed()) {
            throw ValidationException::withMessages([
                'product_id' => ['Product not found in external catalog.']
            ]);
        }

        $data = $resp->json();
        
        if (empty($data['id'])) {
            throw ValidationException::withMessages([
                'product_id' => ['Product not found in external catalog.']
            ]);
        }

        return [
            'product_id' => (string)($data['id'] ?? $productId),
            'title'      => (string)($data['title'] ?? $data['name'] ?? 'Unknown'),
            'image' => $data['image'] ?? $data['thumbnail'] ?? null,
            'price' => $data['price'] ?? null,
            'review'     => $data['rating'] ?? $data['review'] ?? null,
        ];
    }
}
