<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payable_id');
            $table->string('payable_type'); // App\Models\Sale o App\Models\Order
            $table->decimal('amount', 10, 2); // USD
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['completed', 'pending', 'failed', 'refunded']);
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['payable_id', 'payable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};