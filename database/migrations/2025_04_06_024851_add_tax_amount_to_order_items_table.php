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
        Schema::table('order_items', function (Blueprint $table) {
            //
            // Añadir la columna 'tax_amount' después de 'discount'
            $table->decimal('tax_amount', 10, 2)->default(0)->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
            // Eliminar la columna 'tax_amount' en caso de que se revierta la migración
            $table->dropColumn('tax_amount');
        });
    }
};
