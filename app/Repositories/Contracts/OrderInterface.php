<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Types\FulfillmentResult;

interface OrderInterface
{
    public function createOrder(OrderRequest $orderRequest): Order;
    public function fulfillOrder(Order $order): FulfillmentResult;
    public function handleOrderFailure(Order $order, string $reason): void;
    public function find(string $id): ?Order;
}
