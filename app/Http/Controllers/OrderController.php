<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\Orders\OrderManager;

class OrderController extends Controller
{
    public function __construct(
        private OrderManager $orderManager
    ) {
        //
    }

    /**
     * Create an order
     */
    public function create(OrderRequest $request)
    {
        $order = $this->orderManager->createOrder($request);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'status' => $order->status,
        ]);
    }

    /**
     * Process payment for an order
     */
    public function pay(string $orderId)
    {
        $order = $this->orderManager->find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $result = $this->orderManager->processPayment($order);

        return response()->json([
            'success' => $result->success,
            'transaction_id' => $result->transactionId,
            'failure_reason' => $result->failureReason,
            'status' => $order->status,
        ]);
    }

    /**
     * Fulfill an order (after payment)
     */
    public function fulfill(string $orderId)
    {
        $order = $this->orderManager->find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $result = $this->orderManager->fulfillOrder($order);

        return response()->json([
            'success' => $result->success,
            'tracking_id' => $result->trackingId,
            'failure_reason' => $result->failureReason,
            'status' => $order->status,
        ]);
    }

    /**
     * Cancel an order
     */
    public function cancel(string $orderId)
    {
        $order = $this->orderManager->find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $this->orderManager->handleOrderFailure($order, "Cancelled by user");

        return response()->json([
            'success' => true,
            'status' => $order->status,
        ]);
    }
}
