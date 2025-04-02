<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('loyalty_points')->default(0)->after('balance');
            $table->date('birthdate')->nullable()->after('type');
            $table->enum('preferred_payment_method', ['cash', 'card', 'transfer'])->nullable()->after('tax_id');
            
            // Si el campo is_active no existe
            if (!Schema::hasColumn('customers', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('country');
            }
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'loyalty_points',
                'birthdate',
                'preferred_payment_method'
            ]);
            
            // No eliminamos is_active para no perder datos
        });
    }
};