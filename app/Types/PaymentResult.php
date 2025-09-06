<?php

namespace App\Types;

class PaymentResult
{
    public function __construct(
        public bool $success,
        public string $transactionId,
        public ?string $failureReason,
    ) {
        //
    }
}
