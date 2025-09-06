<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Types\PaymentResult;

interface PaymentGatewayInterface
{
    public function processPayment(Order $order): PaymentResult;
    public function charge(Order $order): PaymentResult;
    public function refundPayment(Order $order): bool;
}
