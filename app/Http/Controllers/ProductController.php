<?php

namespace App\Http\Controllers;

use App\Dtos\ProductDto;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $products = $this->productService->getProductsPaginated();

        return ProductResource::collection(resource: $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $dto = ProductDto::fromRequest($request);
        $product = $this->productService->createProduct($dto);

        return response()->setStatusCode(201)->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $dto = ProductDto::fromRequest($request);
        $product = $this->productService->updateProduct($id, $dto);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $product = $this->productService->deleteProduct($id);

        return response()->setStatusCode(204)->json();
    }
}
