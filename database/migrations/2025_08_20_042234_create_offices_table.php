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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name')->unique();
            $table->string('registration_number')->unique();
            $table->string('admin_name')->unique();
            $table->string('phone_number')->unique();
            $table->string('landline_number')->unique()->nullable();
            $table->string('full_address');
            $table->string('location_lon');
            $table->string('location_lat');
            $table->string('work_cities');
            $table->integer('employees_number');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
