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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id(); 
            $table->decimal('nouveauPrix', 8, 2); 
            $table->decimal('ancienPrix', 8, 2);
            $table->dateTime('dateDebut');
            $table->dateTime('dateFin'); 
            $table->string('status', 50); 
            $table->unsignedBigInteger('id_produit');
            $table->foreign('id_produit')->references('id')->on('produits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
