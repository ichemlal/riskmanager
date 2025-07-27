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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('category');
            $table->string('type')->default('text');
            $table->string('priority')->nullable();
            $table->json('options')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('structure_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // If you have a structures table:
            $table->foreign('structure_id')->references('id')->on('structures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
