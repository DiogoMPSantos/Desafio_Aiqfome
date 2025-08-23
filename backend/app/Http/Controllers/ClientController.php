<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(private ClientRepositoryInterface $clients) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->clients->paginate()
        ]);
    }

    public function show(int $client): JsonResponse
    {
        $model = $this->clients->find($client);

        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($model);
    }

    public function store(ClientStoreRequest $request): JsonResponse
    {
        $created = $this->clients->create($request->validated());
        return response()->json([
            'message' => 'Client created successfully',
            'data' => $created
        ], 201);
    }

    public function update(ClientUpdateRequest $request, int $client): JsonResponse
    {
        $model = $this->clients->find($client);
        
        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $updated = $this->clients->update($model, $request->validated());
        return response()->json([
            'message' => 'Client updated successfully',
            'data' => $updated
        ]);
    }

    public function destroy(int $client): JsonResponse
    {
        $model = $this->clients->find($client);
        
        if (!$model) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $this->clients->delete($model);
        return response()->json([
            'message' => 'Client deleted successfully'
        ], 204);
    }
}
