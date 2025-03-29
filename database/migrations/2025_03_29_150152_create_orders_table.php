<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 10, 2); // USD
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->json('shipping_address');
            $table->json('billing_address');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('customer_id');
            $table->index('order_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};