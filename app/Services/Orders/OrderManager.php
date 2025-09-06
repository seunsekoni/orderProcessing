<?php

namespace App\Services\Orders;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\Contracts\OrderInterface;
use App\Repositories\Contracts\PaymentGatewayInterface;

class OrderManager
{
    protected $orderRepository;
    protected $paymentGatewayRepository;

    public function __construct(OrderInterface $orderRepository, PaymentGatewayInterface $paymentGatewayRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->paymentGatewayRepository = $paymentGatewayRepository;
    }

    public function createOrder(OrderRequest $orderRequest)
    {
        return $this->orderRepository->createOrder($orderRequest);
    }

    public function processPayment(Order $order)
    {
        // return $this->paymentGatewayRepository->processPayment($order);
        $paymentResult = $this->paymentGatewayRepository->charge($order);

        if ($paymentResult->success) {
            $order->status = 'paid';
            $order->payment_transaction_id = $paymentResult->transactionId;
            $order->save();
        } else {
            $order->status = 'failed';
            $this->handleOrderFailure($order, $paymentResult->failureReason ?? "Unknown error");
        }

        return $paymentResult;
    }

    public function fulfillOrder(Order $order)
    {
        return $this->orderRepository->fulfillOrder($order);
    }

    public function handleOrderFailure(Order $order, string $reason)
    {
        return $this->orderRepository->handleOrderFailure($order, $reason);
    }

    public function find(string $id): ?Order
    {
        return $this->orderRepository->find($id);
    }
}
