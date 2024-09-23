<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_orders()
    {
        $products = Product::factory()->count(3)->create();

        Order::factory()->count(3)->create()->each(function ($order) use ($products) {
            $order->products()->sync(
                [
                    $products[0]->id => ['quantity' => 1],
                    $products[1]->id => ['quantity' => 2],
                    $products[2]->id => ['quantity' => 3],
                ]
            );
        });

        $response = $this->get('/api/order');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_get_order_by_id()
    {
        $product = Product::factory()->create();

        $order = Order::factory()->create();
        $order->products()->sync([ $product->id => ['quantity' => 1] ]);

        $response = $this->get("/api/order/{$order->id}");

        $response->assertStatus(200);
    }

    public function test_create_order()
    {
        $products = Product::factory()->count(3)->create();
        $customer = Customer::factory()->create();

        $response = $this->post('/api/order', [
            'customer_id' => $customer->id,
            'products' => $products->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'quantity' => 1,
                ];
            })->toArray(),
        ]);

        $response->assertStatus(201);
    }
}
