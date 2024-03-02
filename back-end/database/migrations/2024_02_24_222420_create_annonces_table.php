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
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('modele_id')->constrained('modeles')->onDelete('cascade');
            $table->foreignId('marque_id')->constrained('marques')->onDelete('cascade');
            $table->string('titre');
            $table->string('description');
            $table->string('ville');
            $table->enum('type_annonce', ['location', 'vente']);
            $table->enum('statut_annonce', ['onhold', 'approved', 'disabled'])->default('onhold');
            $table->enum('etat', ['neuf', 'occasion']);
            $table->enum('carburant', ['diesel', 'hybride', 'essence', 'electrique']);
            $table->unsignedInteger('kilometrage');
            $table->string('couleur');
            $table->year('annee_fabrication');
            $table->json('options')->nullable();
            $table->decimal('prix_vente', 12, 3)->nullable();
            $table->decimal('prix_location', 12, 3)->nullable();
            $table->enum('disponibilite_vente', ['vendu', 'disponible', 'indisponible'])->nullable();
            $table->enum('disponibilite_location', ['louer', 'disponible', 'indisponible'])->nullable();
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
