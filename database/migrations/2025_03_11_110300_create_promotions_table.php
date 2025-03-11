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
            $table->float('nouveauPrix');
            $table->float('ancienPrix');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->enum('status',['active','desactive']);
            $table->unsignedInteger('id_produit');
            $table->foreign('id_produit')->references('id')->on('produits');


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
