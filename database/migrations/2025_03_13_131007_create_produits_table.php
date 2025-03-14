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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description');
            $table->float('prix');
            $table->integer('stock');
            $table->unsignedInteger('id_admin');
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_rayon');
            $table->foreign('id_rayon')->references('id')->on('rayons')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_categorie');
            $table->foreign('id_categorie')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
