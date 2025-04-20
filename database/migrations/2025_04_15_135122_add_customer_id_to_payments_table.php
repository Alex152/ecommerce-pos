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
        Schema::table('payments', function (Blueprint $table) {
            // Añadir la columna `customer_id` y establecer la relación foránea con la tabla `customers`
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Eliminar la columna `customer_id` y la clave foránea
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
