<?php

namespace App\Http\Controllers;

use App\Dtos\ProductDto;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Here I have aimed to demonstrate a robust pattern with reduced interdependencies between components.
 * Laravel makes it easy to quickly write things that work just fine but can become fragile,
 * eg the tight coupling between routes & models often shown in documentation.
 *
 * The way I've done it:
 * - Add a service class for orchestrating business logic
 * - Add a repository class for dealing with Models and database interaction
 * - Add a DTO (generally immutable) class to ensure data transfer is consistent,
 *  rather than passing arrays around which can be modified easily
 * - Use Resource classes to ensure clean client side responses, ie whitelisting the fields that can be returned
 *
 * I did get a bit carried away, realising how I've missed working in Laravel * php8!
 * */
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
        // I've used pagination here as a performance / load consideration,
        // don't really want to dump a million products directly over the API!
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

        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductResource|JsonResponse
    {
        $product = $this->productService->getProductById($id);

        if (empty($product)) {
            return response()->json([], 404);
        }

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id): ProductResource
    {
        $dto = ProductDto::fromRequest($request);
        $product = $this->productService->updateProduct($id, $dto);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $product = $this->productService->deleteProduct($id);

        return response()->json([], 204);
    }
}
