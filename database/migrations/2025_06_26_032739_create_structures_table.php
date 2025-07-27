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
          Schema::create('structures', function (Blueprint $table) {
        $table->id();
        $table->string('nom_structure');
        $table->string('siret', 14);
        $table->string('adresse');
        $table->string('code_postal', 5);
        $table->string('ville');
        $table->string('email_contact');
        $table->string('secteur_activite')->nullable();
        $table->string('nombre_employes')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structures');
    }
};
