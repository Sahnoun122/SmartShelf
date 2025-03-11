<?php

namespace App\Http\Controllers;

use App\Models\rayon;
use App\Http\Requests\StorerayonRequest;
use App\Http\Requests\UpdaterayonRequest;

class RayonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rayon=rayon::all();
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

    // public function store(StorerayonRequest $request)
    // {
    //     $validatedata= $request->validate([
    //         'nom'=>'required|max:100'

    //     ]);

    //     $rayon = rayon::create([
    //         'nom'=>$request->nom
    //     ]);

    //     return response()->json($validatedata, 201);
    // }


    public function store(StorerayonRequest $request)
{
    $validatedData = $request->validate([
        'nom' => 'required|max:100'
    ]);

    $rayon = Rayon::create([
        'nom' => $validatedData['nom']  
    ]);

    return response()->json($rayon, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(rayon $rayon)
    {
             return response()->json($rayon);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rayon $rayon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdaterayonRequest $request, rayon $rayon)
    {
        $validatedata= $request->validate([
            'nom'=>'nullable|max:100'

        ]);

        $rayon->save();
        return response()->json($rayon);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rayon $rayon)
    {
      $rayon->delete();
      return response()->json();
    }
}
