<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->timestamp('triggered_at');
            $table->timestamp('resolved_at')->nullable();
            $table->enum('alert_type', ['low_stock', 'out_of_stock', 'over_stock']);
            $table->json('notified_users')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_alerts');
    }
};