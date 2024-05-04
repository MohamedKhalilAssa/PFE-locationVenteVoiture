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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voiture_id')->constrained('annonces')->onDelete('cascade');
            $table->date('date_debut')->default(now());
            $table->date('date_fin');
            $table->enum('statut_location', ['en_cours', 'termine'])->default('en_cours');
            $table->decimal('prix_location', 12, 3);
            $table->decimal('prix_total', 12, 3);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
