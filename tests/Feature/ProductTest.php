<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        $response = $this->postJson('/api/product', Product::factory()->make()->toArray());
        $response->assertStatus(201);
    }

    public function test_get_all_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/product');
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_get_all_products_with_filter()
    {
        Product::factory()->count(5)->create();
        Product::factory()->create(['name' => 'Product 1']);

        $response = $this->getJson('/api/product?name=Product 1');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_get_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/product/{$product->id}");
        $response->assertStatus(200);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/product/{$product->id}", Product::factory()->make()->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/product/{$product->id}");
        $response->assertStatus(204);
    }
}
