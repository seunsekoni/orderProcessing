<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\OrderRequest;
use App\Types\FulfillmentResult;
use App\Repositories\Contracts\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
    public function createOrder(OrderRequest $orderRequest): Order
    {
        $order = Order::create([
            'id' => uniqid('order_'),
            'user_id' => $orderRequest->user_id,
            'items' => $orderRequest->items,
            'total_amount' => $orderRequest->total_amount,
            'currency' => $orderRequest->currency,
            'status' => $orderRequest->status,
            'payment_transaction_id' => $orderRequest->payment_transaction_id,
            'fulfilled_at' => $orderRequest->fulfilled_at,
            'failed_at' => $orderRequest->failed_at,
            'failed_reason' => $orderRequest->failed_reason,
        ]);

        return $order;
    }

    public function fulfillOrder(Order $order): FulfillmentResult
    {
        if ($order->status !== 'paid') {
            return new FulfillmentResult(
                success: false,
                trackingId: $order->payment_transaction_id,
                failureReason: 'Order is not paid'
            );
        }
        $order->status = 'fulfilled';
        $order->fulfilled_at = now();
        $order->save();
        return new FulfillmentResult(
            success: true,
            trackingId: $order->payment_transaction_id,
            failureReason: null
        );
    }

    public function handleOrderFailure(Order $order, string $reason): void
    {
        $order->status = 'failed';
        $order->failed_at = now();
        $order->failed_reason = $reason;
        $order->save();
    }

    public function find(string $id): ?Order
    {
        return Order::find($id);
    }
}
