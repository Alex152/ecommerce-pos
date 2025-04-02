<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agregar campos si no existen
            if (!Schema::hasColumn('users', 'pos_pin')) {
                $table->string('pos_pin', 6)->nullable()->comment('PIN de acceso rápido al POS');
            }
            
            if (!Schema::hasColumn('users', 'barcode')) {
                $table->string('barcode')->nullable()->unique()->comment('Código para identificación por escáner');
            }
            
            if (!Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'two_factor_recovery_codes')) {
                $table->text('two_factor_recovery_codes')->nullable();
            }
        });
    }

    public function down()
    {
        // No revertimos los cambios para evitar pérdida de datos
        // En producción, esto debería ser más controlado
    }
};