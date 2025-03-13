<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\promotion;

class PromotionController extends Controller
{
    /**
     * Affiche la liste des promotions.
     */
    public function index()
    {
        $promotions = DB::table('promotions')
            ->join('produits', 'promotions.id_produit', '=', 'produits.id')
            ->select('promotions.*', 'produits.nom as produit_nom')
            ->get();

        return response()->json($promotions);
    }

    /**
     * Affiche les détails d'une promotion spécifique.
     */
    public function show($id)
    {
        $promotion = DB::table('promotions')
            ->join('produits', 'promotions.id_produit', '=', 'produits.id')
            ->select('promotions.*', 'produits.nom as produit_nom')
            ->where('promotions.id', $id)
            ->first();

        if (!$promotion) {
            return response()->json(['message' => 'Promotion non trouvée'], 404);
        }

        return response()->json($promotion);
    }

    /**
     * Crée une nouvelle promotion.
     */

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nouveauPrix' => 'required|numeric|min:0',
            'ancienPrix' => 'required|numeric|min:0',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after:dateDebut',
            'status' => 'required|string|max:50',
            'id_produit' => 'required|exists:produits,id',

        ]);

        $promotion = DB::table('promotions')->insertGetId([
            'nouveauPrix' => $validatedData['nouveauPrix'],
            'ancienPrix' => $validatedData['ancienPrix'],
            'dateDebut' => $validatedData['dateDebut'],
            'dateFin' => $validatedData['dateFin'],
            'status' => $validatedData['status'],
            'id_produit' => $validatedData['id_produit'],


        ]);
        return response()->json(['id' => $promotion], 201);
    }

    /**
     * Met à jour une promotion existante.
     */

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nouveauPrix' => 'sometimes|numeric|min:0',
            'ancienPrix' => 'sometimes|numeric|min:0',
            'dateDebut' => 'sometimes|date',
            'dateFin' => 'sometimes|date|after:dateDebut',
            'status' => 'sometimes|string|max:50',
            'id_produit' => 'sometimes|exists:produits,id',
        ]);

           DB::table('promotions')
            ->where('id', $id)
            ->update([
                'nouveauPrix' => $validatedData['nouveauPrix'],
                'ancienPrix' => $validatedData['ancienPrix'],
                'dateDebut' => $validatedData['dateDebut'],
                'dateFin' => $validatedData['dateFin'],
                'status' => $validatedData['status'],
                'id_produit' => $validatedData['id_produit'],
            ]);

        $updatedPromotion = DB::table('promotions')->where('id', $id)->first();

        return response()->json($updatedPromotion);
    }

    /**
     * Supprime une promotion.
     */

    public function destroy($id)
    {

        DB::table('promotions')->where('id', $id)->delete();
        return response()->json(['message' => 'Promotion supprimée avec succès'], 204);
    }
}
