<?php

namespace App\Http\Controllers;

use App\Models\demande;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DemandeController extends Controller
{




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = DB::table('demandes')
        ->join('produits', 'demandes.id_produit', '=', 'produits.id')
        ->join('users', 'demandes.id_client', '=', 'users.id')
        ->select('demandes.*', 'produits.nom as produit_nom', 'users.name as client_nom')
        ->get();

    return response()->json($demandes);

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
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'id_produit' => 'required|exists:produits,id', 
            'id_client' => 'required|exists:users,id', 
        ]);
        $demande = DB::table('demandes')->insertGetId([
            'nom' => $validatedData['nom'],
            'total' => $validatedData['total'],
            'id_produit' => $validatedData['id_produit'],
            'id_client' => $validatedData['id_client'],
        ]);

        return response()->json(['id' => $demande], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $demande = DB::table('demandes')
            ->join('produits', 'demandes.id_produit', '=', 'produits.id')
            ->join('users', 'demandes.id_client', '=', 'users.id')
            ->select('demandes.*', 'produits.nom as produit_nom', 'users.name as client_nom')
            ->where('demandes.id', $id)
            ->first();

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        return response()->json($demande);
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
    public function update(Request $request, $id)
    {
        // Vérifie si la demande existe
        $demande = DB::table('demandes')->where('id', $id)->first();

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'total' => 'sometimes|numeric|min:0',
            'id_produit' => 'sometimes|exists:produits,id', 
            'id_client' => 'sometimes|exists:users,id', 
        ]);

        DB::table('demandes')
            ->where('id', $id)
            ->update([
                'nom' => $validatedData['nom'],
                'total' => $validatedData['nom'],
                'id_produit' => $validatedData['nom'],
                'id_client' => $validatedData['nom'],
            ]);

        $demande = DB::table('demandes')->where('id', $id)->first();

        return response()->json($demande);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demande $demande)
    {
        DB::table('demandes')->where('id', $demande)->delete();
        return response()->json(null, 204);
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
