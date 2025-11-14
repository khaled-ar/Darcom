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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('for', ['office', 'user']);
            $table->integer('validity')->default(30);
            $table->integer('posts_number');
            $table->float('price', 1);
            $table->integer('images_number');
            $table->integer('videos_number');
            $table->integer('posts_notifications_number')->nullable();
            $table->integer('featured_posts_number')->nullable();
            $table->string('support')->nullable();
            $table->integer('posts_requests_number')->nullable();
            $table->unique(['name', 'for']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
