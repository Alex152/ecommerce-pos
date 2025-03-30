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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        
        // Tabla pivote para productos
        Schema::create('discount_product', function (Blueprint $table) {
            $table->foreignId('discount_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->primary(['discount_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla pivote 'discount_product'
        Schema::dropIfExists('discount_product');
        
        // Eliminar la tabla 'discounts'
        Schema::dropIfExists('discounts');
    }
    
};
