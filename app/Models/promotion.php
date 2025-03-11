<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\produit;
class promotion extends Model
{
    /** @use HasFactory<\Database\Factories\PromotionFactory> */
    use HasFactory;

    protected $fillable = ['nouveauPrix' , 'ancienPrix' , 'dateDebut' , 'dateFin' , 'status' , 'id_produit'];

    public function produits(){
        $this->belongsTo(produit::class ,'id_produit');
    }
}


