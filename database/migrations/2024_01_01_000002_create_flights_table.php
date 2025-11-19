<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->json('weather_data')->nullable();
            $table->enum('season_type', ['high', 'low'])->default('low');
            $table->enum('traffic_level', ['high', 'medium', 'low'])->default('medium');
            $table->text('render_3d_url')->nullable();
            $table->timestamps();

            $table->index('departure_time');
            $table->index('arrival_time');
            $table->index(['departure_airport_id', 'arrival_airport_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
