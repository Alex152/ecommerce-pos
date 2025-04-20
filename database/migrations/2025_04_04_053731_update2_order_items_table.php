<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Eliminar las columnas si existen  porque creamos de mas en la ultima update 
            if (Schema::hasColumn('order_items', 'price')) {
                $table->dropColumn('price');
            }
           /* //Aqui se elimino por error, luego se volvio a agregar
            if (Schema::hasColumn('order_items', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
                */

            if (Schema::hasColumn('order_items', 'total')) {
                $table->dropColumn('total');
            }
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Volver a agregar las columnas eliminadas si es necesario
            $table->decimal('price', 10, 2)->nullable();
           // $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
        });
    }
};
