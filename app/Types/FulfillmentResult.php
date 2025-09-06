<?php

namespace App\Types;

class FulfillmentResult
{
    public function __construct(
        public bool $success,
        public string $trackingId,
        public ?string $failureReason,
    ) {
        //
    }
}
