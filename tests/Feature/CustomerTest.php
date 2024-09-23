<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_customers()
    {
        Customer::factory()->count(5)->create();

        $response = $this->getJson('/api/customer');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'date_of_birth',
                'address',
                'complement',
                'city',
                'state',
                'zip',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ]);
    }

    public function test_get_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson("/api/customer/{$customer->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'date_of_birth',
            'address',
            'complement',
            'city',
            'state',
            'zip',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }

    public function test_create_customer()
    {
        $customer = Customer::factory()->make();

        $response = $this->postJson('/api/customer', [
            'user' => [ "password" => "test", ...User::factory()->make()->toArray()],
            ...$customer->toArray(),
        ]);

        $response->assertStatus(201);
    }

    public function test_update_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->putJson("/api/customer/{$customer->id}", [
            'user' => [ "password" => "test", ...User::factory()->make()->toArray()],
            ...Customer::factory()->make()->toArray(),
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customer/{$customer->id}");

        $response->assertStatus(204);
    }
}
