<?php

namespace App\Contracts;
use Illuminate\Database\Eloquent\Model;

interface OrderServiceContract {
    /**
     * Get all orders
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrders(array $filters): \Illuminate\Database\Eloquent\Collection;

    /**
     * Create a new order and notify the customer
     *
     * @param array $params
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function createOrder(array $params): Model;

    /**
     * Update an existing order
     *
     * @param int $orderId
     * @param array $params
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function updateOrder(Model $order, array $params): Model;

    /**
     * Delete an existing order
     *
     * @param Model $order
     * @return bool
     */
    public function deleteOrder(Model $order): bool;
}
