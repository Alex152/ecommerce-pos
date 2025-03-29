<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('dni')->nullable()->unique();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('US');
            $table->string('postal_code');
            $table->integer('loyalty_points')->default(0);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};