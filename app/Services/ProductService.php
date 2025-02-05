<?php

namespace App\Services;

use App\Dtos\ProductDto;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\Paginator;

class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function getAllProducts(): array
    {
        $products = $this->productRepository->getAllProducts();
        return array_map(fn(array $product) => new ProductDto($product), $products);
    }

    public function getProductsPaginated(): Paginator
    {
        return $this->productRepository->getProductsPaginated();
    }

    public function createProduct(ProductDto $dto): ProductDto
    {
        $product = $this->productRepository->createProduct([
            'name' => $dto->name,
            'info' => $dto->info,
        ]);
        return new ProductDto($product->toArray());
    }

    public function updateProduct(int $id, ProductDto $dto): ?ProductDto
    {
        if (!$this->productRepository->updateProduct($id, [
            'name' => $dto->name,
            'info' => $dto->info,
        ])) {
            return null;
        }
        return $this->getProductById($id);
    }

    public function getProductById(int $id): ?ProductDto
    {
        $product = $this->productRepository->getProductById($id);
        return $product ? new ProductDto($product->toArray()) : null;
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->deleteProduct($id);
    }
}
