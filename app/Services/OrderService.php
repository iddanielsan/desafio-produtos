<?php

namespace App\Services;

use App\Contracts\OrderServiceContract;
use App\Models\Product;
use App\Notifications\OrderCreated;
use Illuminate\Database\Eloquent\Model;

class OrderService implements OrderServiceContract {
    public function __construct(
        private Model $orderModel
    ) {}

    public function getAllOrders(array $filters): \Illuminate\Database\Eloquent\Collection {
        return $this->orderModel->query()
            ->when(isset($filters['customer_id']), fn($query) => $query->where('customer_id', $filters['customer_id']))
            ->get();
    }

    public function createOrder(array $params): Model {
        if (!isset($params['products']) || empty($params['products'])) {
            throw new \InvalidArgumentException('Products are required');
        }

        if (!isset($params['customer_id'])) {
            throw new \InvalidArgumentException('Customer ID is required');
        }

        $order = $this->orderModel->create([
            'customer_id' => $params['customer_id'],
        ]);

        $order->products()->sync($params['products']);

        $order->refresh();
        $order->load('customer.user');
        $order->customer->user->notify(new OrderCreated($order));

        return $order;
    }

    public function updateOrder(Model $order, array $params): Model {
        if (!isset($params['products']) || empty($params['products'])) {
            throw new \InvalidArgumentException('Products are required');
        }

        $order->products()->sync($params['products']);
        $order->refresh();

        return $order;
    }

    public function deleteOrder(Model $order): bool {
        return $order->delete();
    }
}
