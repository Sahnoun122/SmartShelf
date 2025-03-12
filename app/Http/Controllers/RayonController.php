<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorerayonRequest;
use App\Http\Requests\UpdaterayonRequest;

class RayonController extends Controller
{
    public function index()
    {
        $rayons = DB::table('rayons')->get();
        return response()->json($rayons);
    }


    public function create()
    {
        //
    }

  
    public function store(StorerayonRequest $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:100',
            'id_admin' => 'required|exists:users,id'
        ]);

        $rayonId = DB::table('rayons')->insertGetId([
            'nom' => $validatedData['nom'],
            'id_admin' => $validatedData['id_admin'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $rayon = DB::table('rayons')->where('id', $rayonId)->first();
        
        return response()->json($rayon, 201);
    }

    public function show($id)
    {
        $rayon = DB::table('rayons')->where('id', $id)->first();
        
        if (!$rayon) {
            return response()->json(['message' => 'Rayon non trouvé'], 404);
        }
        
        return response()->json($rayon);
    }

    public function edit($id)
    {
        //
    }

  
    public function update(UpdaterayonRequest $request, $id)
    {
        $validatedata = $request->validate([
            'nom' => 'nullable|max:100',
            'id_admin' => 'nullable|exists:users,id'
        ]);

        $rayon = DB::table('rayons')->where('id', $id)->first();
        
        if (!$rayon) {
            return response()->json(['message' => 'Rayon non trouvé'], 404);
        }

        $dataToUpdate = [];
        
        if (isset($validatedata['nom'])) {
            $dataToUpdate['nom'] = $validatedata['nom'];
        }
        
        if (isset($validatedata['id_admin'])) {
            $dataToUpdate['id_admin'] = $validatedata['id_admin'];
        }
        
        if (!empty($dataToUpdate)) {
            $dataToUpdate['updated_at'] = now();
            DB::table('rayons')->where('id', $id)->update($dataToUpdate);
        }
        
        $updatedRayon = DB::table('rayons')->where('id', $id)->first();
        
        return response()->json($updatedRayon);
    }

  
    public function destroy($id)
    {
        $rayon = DB::table('rayons')->where('id', $id)->first();
        
        if (!$rayon) {
            return response()->json(['message' => 'Rayon non trouvé'], 404);
        }
        
        DB::table('rayons')->where('id', $id)->delete();
        
        return response()->json(null, 204);
    }
    
  
    public function Produits($id)
    {
        $rayon = DB::table('rayons')->where('id', $id)->first();
        
        if (!$rayon) {
            return response()->json(['message' => 'Rayon non trouvé'], 404);
        }
        
        $produits = DB::table('produits')
            ->where('id_rayon', $id)
            ->get();
        
        return response()->json([
            'rayon' => $rayon,
            'produits' => $produits
        ]);
    }

    public function Statistiques($id)
    {
        $rayon = DB::table('rayons')->where('id', $id)->first();
        
        if (!$rayon) {
            return response()->json(['message' => 'Rayon non trouvé'], 404);
        }
        
        $totalProduits = DB::table('produits')
            ->where('id_rayon', $id)
            ->count();
            
        $valeurStock = DB::table('produits')
            ->where('id_rayon', $id)
            ->sum(DB::raw('prix * stock'));
            
        $stockMoyen = DB::table('produits')
            ->where('id_rayon', $id)
            ->avg('stock');
        
        return response()->json([
            'rayon' => $rayon->nom,
            'total_produits' => $totalProduits,
            'valeur_stock' => $valeurStock,
            'stock_moyen' => $stockMoyen
        ]);
    }
}