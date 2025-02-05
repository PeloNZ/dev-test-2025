<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testGetAverageRating()
    {
    }

    public function testNonExistentProductPage()
    {
        $response = $this->getJson(route('products.show', ['id' => 0]));

        $response->assertStatus(404);
    }
}
