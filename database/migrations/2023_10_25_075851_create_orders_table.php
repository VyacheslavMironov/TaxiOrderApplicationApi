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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable(false);
            $table->integer('driver_id')->nullable();
            $table->text('addres')->nullable(false);
            $table->text('message')->nullable();
            $table->integer('count_user')->default(1);
            $table->enum('order_type', ['Грузовой', 'Детский', 'Стандарт']);
            $table->integer('price')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
