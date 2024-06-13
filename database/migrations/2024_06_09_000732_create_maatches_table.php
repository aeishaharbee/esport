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
        Schema::create('maatches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team1Id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('team2Id')->constrained('teams')->onDelete('cascade');
            $table->dateTime('time');
            $table->foreignId('levelId')->constrained('levels')->onDelete('cascade');
            $table->foreignId('tournId')->constrained('tournaments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maatches');
    }
};
