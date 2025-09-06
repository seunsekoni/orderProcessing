<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->json('items');
            $table->decimal('total_amount', 10, 2);
            $table->string('currency');
            $table->string('status');
            $table->string('payment_transaction_id');
            $table->timestamp('fulfilled_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('failed_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
