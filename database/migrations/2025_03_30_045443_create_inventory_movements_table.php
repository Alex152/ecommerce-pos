<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->comment('Positive for entries, negative for withdrawals');
            $table->enum('type', ['in', 'out'])->comment('Entry or withdrawal');
            $table->timestamps();

            $table->index(['product_id', 'warehouse_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
};