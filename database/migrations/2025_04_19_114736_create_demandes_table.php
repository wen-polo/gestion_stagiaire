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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id(); // ID unique pour chaque demande
            $table->string('nom'); // Nom du stagiaire
            $table->string('prenom'); // Prénom du stagiaire
            $table->string('filiere'); // Filière ou spécialité
            $table->string('niveau'); // Niveau d'étude
            $table->string('diplome'); // Diplôme préparé
            $table->enum('type_stage', ['academique', 'professionnel']); // Type de stage
            $table->enum('statut_stage', ['initial', 'renouvellement']); // Statut du stage
            $table->date('date_debut'); // Date de début du stage
            $table->date('date_fin'); // Date de fin du stage
            $table->string('contacts'); // Contacts du stagiaire
            $table->string('pdf_path')->nullable(); // Chemin du fichier PDF de la demande
            $table->enum('statut', ['en_attente', 'transferee_sg', 'transferee_dpaf'])->default('en_attente'); // Statut de la demande
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
