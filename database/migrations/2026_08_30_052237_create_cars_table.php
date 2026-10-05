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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('category');
            $table->unsignedSmallInteger('year');
            $table->decimal('price', 14, 2);
            $table->string('transmission');
            $table->string('fuel_type');
            $table->unsignedInteger('engine_cc')->nullable();
            $table->unsignedTinyInteger('seat_capacity')->nullable();
            $table->decimal('fuel_consumption_kmpl', 5, 1)->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rating', 2, 1)->nullable()->default(0);
            $table->text('review')->nullable();
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
