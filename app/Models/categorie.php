<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produit;

class categorie extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieFactory> */
    use HasFactory;

    protected $fillable = ['nom' , 'id_produit'];

    public function produit(){

        $this->belongsTo(produit::class , 'id_produit');
    }
}


