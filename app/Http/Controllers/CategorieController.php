<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Http\Requests\StorecategorieRequest;
use App\Http\Requests\UpdatecategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorie=categorie::all();
        return response()->json($categorie);
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
    public function store(StorecategorieRequest $request)
    {
        
        $validatedData = $request->validate([
            'nom' => 'required|max:100'
        ]);

        $rayon = categorie::create([
            'nom' => $validatedData['nom']  
        ]);
    
        return response()->json($rayon, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(categorie $categorie)
    {
        return response()->json($categorie);

    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit(categorie $categorie)
    {
        $validatedata= $categorie->validate([
            'nom'=>'nullable|max:100'

        ]);

        $categorie->save();
        return response()->json($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecategorieRequest $request, categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categorie $categorie)
    {
        $categorie->delete();
        return response()->json();
    }
}
