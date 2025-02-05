<?php

namespace App\Dtos;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductDto
{
    public int $id;
    public string $name;
    public string $info;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->info = $data['info'];
    }

    public static function fromRequest(StoreProductRequest $request): self
    {
        return new self($request->validated());
    }

    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'name' => $product->name,
            'info' => $product->info,
        ]);
    }
}
