<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_04_03_150000_update_order_items_table.php
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Añadir campos faltantes (sin renombrar)
            $table->decimal('unit_price', 10, 2)->after('quantity');
            $table->decimal('subtotal', 10, 2)->default(0)->after('unit_price');
            
            // Actualizar campos existentes
            $table->decimal('price', 10, 2)->change(); // Mantener 'price' como está
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('tax', 10, 2)->default(0)->change();
            $table->decimal('discount', 10, 2)->default(0)->change();
            $table->decimal('total', 10, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Revertir cambios si es necesario
            $table->renameColumn('unit_price', 'price');
            $table->dropColumn('subtotal');
        });
    }
};