<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DB::table('categories')->get();
        return response()->json($categories);
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
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = DB::table('categories')->where('id', $id)->first();
        return response()->json($categorie);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => 'nullable|max:100',
            'id_admin' => 'nullable|max:100'

        ]);

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'nom' => $validatedData['nom'],
                'id_admin' => $validatedData['id_admin']

            ]);

        $categorie = DB::table('categories')->where('id', $id)->first();
        return response()->json($categorie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return response()->json(null, 204);
    }
}