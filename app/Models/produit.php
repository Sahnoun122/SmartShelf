<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\rayon;
 use App\Models\User;
class produit extends Model
{
    /** @use HasFactory<\Database\Factories\ProduitFactory> */
    use HasFactory;
   protected $fillablel = ['nom' , 'description' , 'prix', 'id_admin' , 'id_rayon' ];

   public function  admin(){
    $this->belongsTo(User::class , 'id_admin');
   }
 
   public function  rayon(){
    $this->belongsTo(rayon::class , 'id_rayon');
   }
}




// protected $fillable= ['nom' , 'id_admin'];
    
// public function admin(){
//     $this->belongsTo(User::class, 'id_admin');
// }







