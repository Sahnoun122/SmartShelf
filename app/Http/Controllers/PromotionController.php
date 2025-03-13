<?php

namespace App\Http\Controllers;

use App\Models\promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $promotion= DB::table('promotions')
      ->join('produits' , 'promotions.id_produit' , '=' , 'produits.id')
      ->select('produits.*' , 'produits.nom as produit_nom')
      ->get();
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

        $validatedData = $request->validate([
            'nom' => 'required|max:100',
            'id_admin' => 'required|max:100'

        ]);

        $categorie = DB::table('categories')->insertGetId([
            'nom' => $validatedData['nom'],
            'id_admin' => $validatedData['id_admin']

        ]);

        return response()->json(['id' => $categorie], 201);


        // Validation des données
        $validateData = $request->validate( [
            'nom' => 'required|string|max:255',
            'total' => 'nullable|string',
            'id_client' => 'required|exists:users,id', 
            'id_produit' => 'required|exists:produits,id', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Création de la promotion
        $id = DB::table('promotions')->insertGetId([
            'nom' => $validatedData['nom'],
            'description' => $validatedData['description'],

            'description' => $request->description,
            'reduction' => $request->reduction,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'id_produit' => $request->id_produit,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $promotion = DB::table('promotions')->where('id', $id)->first();

        return response()->json($promotion, 201);
    }

    /**
     * Met à jour une promotion existante.
     */



    /**
     * Display the specified resource.
     */
    public function show(promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Vérifie si la promotion existe
        $promotion = DB::table('promotions')->where('id', $id)->first();

        if (!$promotion) {
            return response()->json(['message' => 'Promotion non trouvée'], 404);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'reduction' => 'sometimes|numeric|min:0|max:100',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after:date_debut',
            'id_produit' => 'sometimes|exists:produits,id', // Vérifie que le produit existe
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::table('promotions')
            ->where('id', $id)
            ->update([
                'nom' => $request->nom ?? $promotion->nom,
                'description' => $request->description ?? $promotion->description,
                'reduction' => $request->reduction ?? $promotion->reduction,
                'date_debut' => $request->date_debut ?? $promotion->date_debut,
                'date_fin' => $request->date_fin ?? $promotion->date_fin,
                'id_produit' => $request->id_produit ?? $promotion->id_produit,
                'updated_at' => now(),
            ]);

        $updatedPromotion = DB::table('promotions')->where('id', $id)->first();

        return response()->json($updatedPromotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(promotion $promotion)
    {
        //
    }
}
