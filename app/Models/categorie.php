<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class categorie extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieFactory> */
    use HasFactory;

    protected $fillable = ['nom' , 'id_admin'];

    public function user(){

        $this->belongsTo(User::class , 'id_admin');
    }
}


