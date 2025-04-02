<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // 1. Eliminar restricciones y columnas obsoletas
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'reference', 'method']);
            
            // 2. Añadir nuevos campos para la relación polimórfica
            $table->unsignedBigInteger('payable_id')->after('id');
            $table->string('payable_type')->after('payable_id');
            
            // 3. Añadir demás campos nuevos
            $table->string('payment_method')->after('amount');
            $table->string('transaction_id')->nullable()->after('payment_method');
            $table->date('payment_date')->nullable()->after('transaction_id');
            
            // 4. Modificar campos existentes
            $table->string('status')->default('completed')->change();
            
            // 5. Índices para mejorar rendimiento
            $table->index(['payable_id', 'payable_type']);
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // 1. Eliminar índices nuevos
            $table->dropIndex(['payable_id', 'payable_type']);
            
            // 2. Eliminar campos nuevos
            $table->dropColumn([
                'payable_id', 
                'payable_type',
                'payment_method',
                'transaction_id',
                'payment_date'
            ]);
            
            // 3. Restaurar campos originales
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->nullable();
            $table->enum('method', [
                'cash', 
                'credit_card', 
                'debit_card', 
                'bank_transfer', 
                'check', 
                'other'
            ]);
            
            // 4. Restaurar tipo de status
            $table->enum('status', [
                'pending', 
                'completed', 
                'failed', 
                'refunded'
            ])->default('completed')->change();
        });
    }
};