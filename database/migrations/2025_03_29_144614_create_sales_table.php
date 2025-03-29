<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 10, 2); // USD
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'mixed']);
            $table->enum('payment_status', ['paid', 'pending', 'cancelled']);
            $table->enum('status', ['completed', 'refunded', 'partially_refunded']);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};