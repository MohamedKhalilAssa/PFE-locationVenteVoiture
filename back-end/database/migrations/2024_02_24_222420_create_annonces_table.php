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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('modele_id')->constrained('modeles')->cascadeOnDelete();
            $table->foreignId('marque_id')->constrained('marques')->cascadeOnDelete();
            $table->string('titre');
            $table->string('description');
            $table->enum('type_annonce', ['location', 'vente']);
            $table->enum('carburant', ['diesel', 'hybride', 'essence', 'electrique']);
            $table->string('couleur');
            $table->decimal('prix_vente', 12, 3);
            $table->decimal('prix_location', 12, 3);
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
