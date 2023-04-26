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
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("order_id")->nullable();           
            $table->unsignedBigInteger('shop_id')->index()->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('send_at')->nullable();

           
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('shop_id')->references('id')->on('shops')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
