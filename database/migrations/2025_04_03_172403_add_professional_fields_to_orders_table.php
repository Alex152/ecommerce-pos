<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // add_professional_fields_to_orders_table.php
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Campos de estado y seguimiento
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                ->default('pending')
                ->after('payment_method');
            $table->string('tracking_number')->nullable()->after('shipping_method');
            
            // Campos para facturación electrónica (opcional)
            $table->string('invoice_number')->unique()->nullable()->after('tracking_number');
            $table->date('invoice_date')->nullable()->after('invoice_number');
            
            // Relación con descuentos (si aplica)
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->after('discount');
        });
    }
};
