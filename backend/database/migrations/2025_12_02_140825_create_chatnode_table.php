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
        Schema::create('chatnode', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message');
            $table->json('options')->nullable();
            $table->json('next_nodes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatnode');
    }
};
