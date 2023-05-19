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
        Schema::create('product_oder_lines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('price');

            $table->unsignedBigInteger('orderLine_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('orderLine_id')->references('id')->on('order_lines')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_oder_lines');
    }
};
