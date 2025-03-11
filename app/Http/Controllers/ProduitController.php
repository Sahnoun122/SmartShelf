<?php

namespace App\Http\Controllers;

use App\Models\produit;
use App\Http\Requests\StoreproduitRequest;
use App\Http\Requests\UpdateproduitRequest;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rayon=produit::all();
        return response()->json($rayon);
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
            'nouveauPrix' => 'required|max:100',
            'ancienPrix' => 'required|max:100',
            'dateDebut' => 'required|max:100',
            'dateFin' => 'required|max:100',
            'status' => 'required|max:100',    
            'id_produit' => 'required|max:100',

        ]);
    
        $produit = produit::create([
            'nouveauPrix' => $validatedData['nouveauPrix'],
            'ancienPrix' => $validatedData['nancienPrixom'],
            'dateDebut' => $validatedData['dateDebut'],
            'dateFin' => $validatedData['dateFin'],
            'status' => $validatedData['status'],
            'id_produit' => $validatedData['id_produit'],

        ]);
    
        return response()->json($produit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproduitRequest $request, produit $produit)
    {
        $validatedata= $request->validate([
            'nouveauPrix'=>'nullable|max:100',
            'ancienPrix'=>'nullable|max:100',
            'dateDebut'=>'nullable|max:100',
            'dateFin'=>'nullable|max:100',
            'status'=>'nullable|max:100',
            'id_produit'=>'nullable|max:100',

        ]);

        $produit->save();
        return response()->json($produit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produit $produit)
    {
        $produit->delete();
        return response()->json();
    }
}
