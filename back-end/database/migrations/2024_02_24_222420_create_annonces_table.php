<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('modele_id')->constrained('modeles')->cascadeOnDelete();
            $table->foreignId('marque_id')->constrained('marques')->cascadeOnDelete();
            $table->string('titre');
            $table->string('description');
            $table->string('ville');
            $table->enum('type_annonce', ['location', 'vente']);
            $table->enum('statut_annonce', ['onhold', 'approved', 'disabled']);
            $table->enum('etat', ['neuf', 'occasion']);
            $table->enum('carburant', ['diesel', 'hybride', 'essence', 'electrique']);
            $table->unsignedInteger('kilometrage');
            $table->string('couleur');
            $table->year('annee_fabrication');
            $table->json('options')->nullable();
            $table->decimal('prix_vente', 12, 3)->nullable();
            $table->decimal('prix_location', 12, 3)->nullable();
            $table->enum('disponibilite_vente', ['vendu', 'disponible', 'autres'])->nullable();
            $table->enum('disponibilite_location', ['louer', 'disponible', 'autres'])->nullable();
            $table->json('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
