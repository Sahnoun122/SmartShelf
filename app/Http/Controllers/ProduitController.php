<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreproduitRequest;
use App\Http\Requests\UpdateproduitRequest;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = DB::table('produits')
            ->join('rayons', 'produits.id_rayon', '=', 'rayons.id')
            ->join('users', 'produits.id_admin', '=', 'users.id')
            ->select(
                'produits.*',
                'rayons.nom as rayon_nom',
                'users.name as admin_nom'
            )
            ->get();

        return response()->json($produits);
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
    public function store(StoreproduitRequest $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:100',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_admin' => 'required|exists:users,id',
            'id_rayon' => 'required|exists:rayons,id'
        ]);

        $produitId = DB::table('produits')->insertGetId([
            'nom' => $validatedData['nom'],
            'description' => $validatedData['description'],
            'prix' => $validatedData['prix'],
            'stock' => $validatedData['stock'],
            'id_admin' => $validatedData['id_admin'],
            'id_rayon' => $validatedData['id_rayon'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $produit = DB::table('produits')->where('id', $produitId)->first();

        return response()->json($produit, 201);
    }


    public function show($id)
    {
        $produit = DB::table('produits')
            ->join('rayons', 'produits.id_rayon', '=', 'rayons.id')
            ->join('users', 'produits.id_admin', '=', 'users.id')
            ->select(
                'produits.*',
                'rayons.nom as rayon_nom',
                'users.name as admin_nom'
            )
            ->where('produits.id', $id)
            ->first();

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        return response()->json($produit);
    }


    public function edit($id)
    {
        //
    }

    public function update(UpdateproduitRequest $request, $id)
    {
        $validatedata = $request->validate([
            'nom' => 'nullable|max:100',
            'description' => 'nullable',
            'prix' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'id_admin' => 'nullable|exists:users,id',
            'id_rayon' => 'nullable|exists:rayons,id'
        ]);

        $produit = DB::table('produits')->where('id', $id)->first();

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $dataToUpdate = [];

        if (isset($validatedata['nom'])) {
            $dataToUpdate['nom'] = $validatedata['nom'];
        }

        if (isset($validatedata['description'])) {
            $dataToUpdate['description'] = $validatedata['description'];
        }

        if (isset($validatedata['prix'])) {
            $dataToUpdate['prix'] = $validatedata['prix'];
        }

        if (isset($validatedata['stock'])) {
            $dataToUpdate['stock'] = $validatedata['stock'];
        }

        if (isset($validatedata['id_admin'])) {
            $dataToUpdate['id_admin'] = $validatedata['id_admin'];
        }

        if (isset($validatedata['id_rayon'])) {
            $dataToUpdate['id_rayon'] = $validatedata['id_rayon'];
        }

        if (!empty($dataToUpdate)) {
            $dataToUpdate['updated_at'] = now();
            DB::table('produits')->where('id', $id)->update($dataToUpdate);
        }

        $updatedProduit = DB::table('produits')->where('id', $id)->first();

        return response()->json($updatedProduit);
    }

    public function destroy($id)
    {
        $produit = DB::table('produits')->where('id', $id)->first();

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        DB::table('produits')->where('id', $id)->delete();

        return response()->json(null, 204);
    }


    public function modifierStock(Request $request, $id)
    {
        $validatedata = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $produit = DB::table('produits')->where('id', $id)->first();

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        DB::table('produits')->where('id', $id)->update([
            'stock' => $validatedata['stock'],
            'updated_at' => now()
        ]);

        $updatedProduit = DB::table('produits')->where('id', $id)->first();

        return response()->json($updatedProduit);
    }


    public function recherche(Request $request)
    {
        $query = DB::table('produits')
            ->join('rayons', 'produits.id_rayon', '=', 'rayons.id');

        if ($request->has('nom')) {
            $query->where('produits.nom', 'like', '%' . $request->nom . '%');
        }

        if ($request->has('rayon')) {
            $query->where('rayons.id', $request->rayon);
        }

        if ($request->has('prix_min')) {
            $query->where('produits.prix', '>=', $request->prix_min);
        }

        if ($request->has('prix_max')) {
            $query->where('produits.prix', '<=', $request->prix_max);
        }

        if ($request->has('en_stock') && $request->en_stock) {
            $query->where('produits.stock', '>', 0);
        }

        $produits = $query->select(
            'produits.*',
            'rayons.nom as rayon_nom'
        )->get();

        return response()->json($produits);
    }

    public function StockFaible($seuil = 5)
    {
        $produits = DB::table('produits')
            ->join('rayons', 'produits.id_rayon', '=', 'rayons.id')
            ->select(
                'produits.*',
                'rayons.nom as rayon_nom'
            )
            ->where('produits.stock', '<=', $seuil)
            ->orderBy('produits.stock')
            ->get();

        return response()->json([
            'seuil' => $seuil,
            'nombre_produits' => count($produits),
            'produits' => $produits
        ]);
    }


    public function ProduitDemande()
    {
        $produits = DB::table('demandes')
            ->join('produits', 'demandes.id_produit', '=', 'produits.id')
            ->select(
                'produits.id',
                'produits.nom',
                'produits.prix',
                DB::raw('COUNT(demandes.id) as nombre_ventes'),
                DB::raw('SUM(demandes.total) as chiffre_affaires')
            )
            ->groupBy('produits.id', 'produits.nom', 'produits.prix')
            ->orderByDesc('nombre_ventes')
            ->limit(10)
            ->get();

        return response()->json($produits);
    }
}
