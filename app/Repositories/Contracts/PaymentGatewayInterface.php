<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\PaymentResult;

interface PaymentGatewayInterface
{
    public function processPayment(Order $order): PaymentResult;
    public function refundPayment(Order $order): bool;
}
