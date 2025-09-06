<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\FulfillmentResult;

interface OrderInterface
{
    public function createOrder(Order $order): Order;
    public function fulfillOrder(Order $order): FulfillmentResult;
    public function handleOrderFailure(Order $order, string $reason): void;
}
