<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->unique(); // Código de barras
            $table->decimal('price', 10, 2); // USD
            $table->decimal('cost_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock')->default(5);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->boolean('has_variants')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};