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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('rate', 5, 2); // Ej: 19.00%
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Tabla pivote para productos
        Schema::create('product_tax', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('tax_id')->constrained();
            $table->primary(['product_id', 'tax_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminación de las tablas
        Schema::dropIfExists('product_tax');
        Schema::dropIfExists('taxes');
    }
};
