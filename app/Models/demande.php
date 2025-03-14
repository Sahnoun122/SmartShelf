<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\produit;

class demande extends Model
{
    /** @use HasFactory<\Database\Factories\DemandeFactory> */
    use HasFactory;

    protected $fillable = ['nom' , 'total' , 'id_produit' , 'id_client'];

    public function produit(){
        $this->belongsTo(produit::class , 'id_produit');
    }

    public function client(){
        $this->belongsTo(User::class , 'id_client');
    }
}


