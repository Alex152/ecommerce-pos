<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/* Old
return new class extends Migration
{
    
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

    
    public function down(): void
    {
        // Eliminar la tabla pivote 'discount_product'
        Schema::dropIfExists('discount_product');
        
        // Eliminar la tabla 'discounts'
        Schema::dropIfExists('discounts');
    }
    
};  */



return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed_amount']);
            $table->decimal('value', 10, 2);
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('uses')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('apply_to_shipping')->default(false);
            $table->boolean('exclude_discounted_products')->default(false);
            $table->timestamps();
        });
        
        // Tabla pivote para productos
        Schema::create('discount_product', function (Blueprint $table) {
            $table->foreignId('discount_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->primary(['discount_id', 'product_id']);
        });
        
        // Tabla pivote para categorías
        Schema::create('discount_category', function (Blueprint $table) {
            $table->foreignId('discount_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->primary(['discount_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_category');
        Schema::dropIfExists('discount_product');
        Schema::dropIfExists('discounts');
    }
};

