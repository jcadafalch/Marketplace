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
        Schema::create('categoria_producte', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('producte_id')->index();
            $table->foreign('producte_id')->references("id")->on("producte")->cascadeOnDelete();
        
            $table->unsignedBigInteger('categoria_id')->index();
            $table->foreign('categoria_id')->references("id")->on("categoria")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_producte');
    }
};
