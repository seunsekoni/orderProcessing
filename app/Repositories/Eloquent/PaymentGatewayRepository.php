<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\PaymentGatewayInterface;
use App\Types\PaymentResult;

class PaymentGatewayRepository implements PaymentGatewayInterface
{
    public function processPayment(Order $order): PaymentResult
    {
        return $this->charge($order);
    }

    public function refundPayment(Order $order): bool
    {
        return $this->refund($order);
    }

    public function charge(Order $order): PaymentResult
    {
        if ($order->total_amount <= 0) {
            return new PaymentResult(false, $order->payment_transaction_id, "Invalid amount");
        }

        if ($order->status === 'paid') {
            return new PaymentResult(true, $order->payment_transaction_id, null);
        }
        $transactionId = 'txn_' . uniqid();
        return new PaymentResult(true, $transactionId, null);
    }

    public function refund(Order $order): bool
    {
        return true;
    }
}
