<?php

use App\Http\Controllers\RayonController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\TestController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('test',[TestController::class,'store']);




Route::apiResource('rayon', RayonController::class);


// Route::post('rayon', [RayonController::class], 'store');

Route::apiResource('categorie', CategorieController::class);

Route::apiResource('produit', ProduitController::class);

Route::post('modifierStock' , [ProduitController::class , 'modifierStock']);

Route::get('recherche' , [ProduitController::class , 'recherche']); 


Route::get('StockFaible' , [ProduitController::class , 'StockFaible']);

Route::get('StockFaible' , [ProduitController::class , 'StockFaible']);  

Route::get('ProduitDemande' , [ProduitController::class , 'ProduitDemande']); 