<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestionsForDuerpSystem extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Remove old fields that are no longer needed
            $table->dropColumn(['type', 'options', 'correct_answer', 'priority']);
            
            // Add new DUERP-specific fields
            $table->string('risk_category')->after('category'); // Physical, RPS, etc.
            $table->string('color_code')->nullable()->after('risk_category'); // Hex color for category
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Restore old fields
            $table->string('type')->default('duerp');
            $table->json('options')->nullable();
            $table->string('correct_answer')->nullable();
            $table->string('priority')->nullable();
            
            // Remove DUERP fields
            $table->dropColumn(['risk_category', 'color_code']);
        });
    }
}
