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
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('min_price', 1);
            $table->float('max_price', 1);
            $table->string('currency', 3)->nullable();
            $table->string('city', 50);
            $table->integer('min_space');
            $table->integer('max_space');
            $table->string('category', 50);
            $table->string('type', 50);
            $table->unique([
                'user_id',
                'min_price', 'max_price',
                'min_space', 'max_space',
                'city', 'category', 'type'
            ], 'paths_composite_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paths');
    }
};
