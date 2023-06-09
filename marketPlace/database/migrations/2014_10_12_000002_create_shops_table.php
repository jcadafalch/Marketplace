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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ownerName')->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->string('nif')->unique()->nullable(false);
            $table->string('description')->nullable();


        
            $table->unsignedBigInteger('logo_id')->index()->nullable();
            $table->unsignedBigInteger('banner_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('logo_id')->references('id')->on('images');
            $table->foreign('banner_id')->references('id')->on('images');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
