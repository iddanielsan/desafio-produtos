<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_get_all_orders()
    {
        $orderModel =  Mockery::mock(\App\Models\Order::class)->makePartial();
        $orderModel->shouldReceive('query')->andReturnSelf();
        $orderModel->shouldReceive('when')->andReturnSelf();
        $orderModel->shouldReceive('get')->andReturn(new Collection([]));

        $orderService = new \App\Services\OrderService($orderModel);
        $result = $orderService->getAllOrders([]);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result);
    }

    public function test_get_all_orders_with_filters()
    {
        $orderModel =  Mockery::mock(\App\Models\Order::class);
        $orderModel->shouldReceive('query')->andReturnSelf();
        $orderModel->shouldReceive('when')->andReturnSelf();
        $orderModel->shouldReceive('get')->andReturn(new Collection([]));

        $orderService = new \App\Services\OrderService($orderModel);
        $result = $orderService->getAllOrders(['customer_id' => 1]);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result);
    }

    public function test_create_order_success()
    {
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $user = Mockery::mock(\App\Models\User::class);
        $user->shouldReceive('notify')->with(Mockery::type(\App\Notifications\OrderCreated::class));
        $orderModel->shouldReceive('create')->andReturn($orderModel);
        $orderModel->shouldReceive('refresh')->andReturn($orderModel);
        $productsRelation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $productsRelation->shouldReceive('sync')->andReturnSelf();
        $orderModel->shouldReceive('getAttribute')->with('products')->andReturn($productsRelation);
        $orderModel->shouldReceive('getAttribute')->with('user')->andReturn($user);
        $orderModel->shouldReceive('getAttribute')->with('customer')->andReturnSelf();
        $orderModel->shouldReceive('load')->with('customer.user')->andReturnSelf();
        $orderModel->shouldReceive('load')->with('customer')->andReturnSelf();
        $orderModel->shouldReceive('products')->andReturn($productsRelation);

        $orderService = new \App\Services\OrderService(
            $orderModel
        );

        $result = $orderService->createOrder([
            'customer_id' => 1,
            'products' => [
                ['product_id' => 1, 'quantity' => 100],
                ['product_id' => 2, 'quantity' => 200]
            ]
        ]);

        $this->assertInstanceOf(\App\Models\Order::class, $result);
    }

    public function test_create_order_fail_products_required()
    {
        $this->expectException(\InvalidArgumentException::class);
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $orderService = new \App\Services\OrderService($orderModel);
        $orderService->createOrder([
            'customer_id' => 1,
        ]);
    }

    public function test_create_order_fail_customer_id_required()
    {
        $this->expectException(\InvalidArgumentException::class);
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $orderService = new \App\Services\OrderService($orderModel);
        $orderService->createOrder([
            'products' => [
                ['name' => 'Product 1', 'quantity' => 100],
                ['name' => 'Product 2', 'quantity' => 200]
            ]
        ]);
    }

    public function test_update_order_success()
    {
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $orderModel->shouldReceive('products')->andReturnSelf();
        $orderModel->shouldReceive('delete')->andReturnSelf();
        $orderModel->shouldReceive('sync')->andReturnSelf();
        $orderModel->shouldReceive('refresh')->andReturnSelf();

        $orderService = new \App\Services\OrderService($orderModel);
        $result = $orderService->updateOrder($orderModel, [
            'products' => [
                ['name' => 'Product 1', 'quantity' => 100],
                ['name' => 'Product 2', 'quantity' => 200]
            ]
        ]);

        $this->assertInstanceOf(\App\Models\Order::class, $result);
    }

    public function test_update_order_fail_products_required()
    {
        $this->expectException(\InvalidArgumentException::class);
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $orderService = new \App\Services\OrderService($orderModel);
        $orderService->updateOrder($orderModel, []);
    }

    public function test_delete_order_success()
    {
        $orderModel = Mockery::mock(\App\Models\Order::class);
        $orderModel->shouldReceive('delete')->andReturn(true);

        $orderService = new \App\Services\OrderService($orderModel);
        $result = $orderService->deleteOrder($orderModel);

        $this->assertTrue($result);
    }
}
