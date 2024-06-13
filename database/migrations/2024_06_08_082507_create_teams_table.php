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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->integer('tournEntered')->default(0);
            $table->integer('win')->default(0);
            $table->integer('lost')->default(0);
            $table->foreignId('registeredId')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoryId')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
