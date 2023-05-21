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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique()->nullable(false);
            $table->string('description')->nullable(false);
            $table->integer('price');
            $table->timestamp('selled_at')->nullable();
            $table->boolean('isVisible')->default(true);
            $table->boolean('isDeleted')->default(false);
            $table->integer('order');

            $table->unsignedBigInteger('shop_id')->index();
            $table->foreign('shop_id')->references('id')->on('shops')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
