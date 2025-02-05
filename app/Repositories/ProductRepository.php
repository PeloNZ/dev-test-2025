<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository
{
    public function getAllProducts(): array
    {
        return Product::all()->toArray();
    }

    public function getProductsPaginated(): Paginator
    {
        return Product::query()->simplePaginate(10);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->getProductById($id);
        if (!$product) {
            return false;
        }
        return $product->update($data);
    }

    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->getProductById($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }
}
