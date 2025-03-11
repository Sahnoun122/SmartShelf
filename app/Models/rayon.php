<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use APP\Models\User;
class rayon extends Model
{
    /** @use HasFactory<\Database\Factories\RayonFactory> */
    use HasFactory;

    protected $fillable= ['nom' , 'id_admin'];
    
    public function admin(){
        $this->belongsTo(User::class, 'id_admin');
    }
}
