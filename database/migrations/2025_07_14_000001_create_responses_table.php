<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campagne_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('salarie_id');
            $table->integer('gravity')->comment('1-5 scale for gravity');
            $table->integer('frequency')->comment('1-5 scale for frequency');
            $table->integer('criticality')->comment('gravity * frequency');
            $table->timestamps();

            $table->foreign('campagne_id')->references('id')->on('campagnes')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('salarie_id')->references('id')->on('salaries')->onDelete('cascade');
            
            // Ensure one response per salarie per question per campaign
            $table->unique(['campagne_id', 'question_id', 'salarie_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
