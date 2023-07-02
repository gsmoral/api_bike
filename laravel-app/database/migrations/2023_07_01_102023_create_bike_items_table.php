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
        Schema::create('bike_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("bike_id")->nullable(false);
            $table->unsignedBigInteger("item_id")->nullable(false);
            $table->timestamps();

            $table->foreign('bike_id')->references('id')->on('bikes')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_items');
    }
};
