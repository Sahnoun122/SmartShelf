<?php

namespace App\Http\Controllers;

use App\Models\demande;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatedemandeRequest;
// use GuzzleHttp\Psr7\Request;

class DemandeController extends Controller
{




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demande $demande)
    {
        //
    }
   
    public function consulterProduit($id_rayon){
        $produits= DB::table('produits')
              ->join('rayons', 'produits.id_rayon' , '=' , 'rayons.id')
              ->where('rayons.id' , $id_rayon)
              ->select('produits.*')
              ->get();

              return response()->json($produits);
    }


    public function rechercheProduit(Request $request){

        $recherche= $request->input('recherche');

        $produits =DB::table('produits')
        ->join('categories' , 'produits.id_categorie' , '=' , 'categories.id')
        ->where('produits.nom' , 'LIKE',"%{$recherche}%")
        ->orWhere('categories.nom' , "LIKE" , "%{$recherche}%")
        ->select('produits.*')
        ->get();
 
        return response()->json($produits);
    }

   public function produitsPopulaire($id_rayon){

    //populaires
    $populaire= DB::table('produits')
    ->join('rayons' , 'produits.id_rayon' , '=' , 'rayons.id')
    ->where('rayons.id' , $id_rayon)
    ->orderBy('produits.nom' , 'DESC')
    ->limi(10)
    ->select('produits.*')
    ->get();

   }
}
