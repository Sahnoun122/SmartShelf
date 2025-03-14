<?php

use App\Http\Controllers\RayonController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\DemandeController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('demande' ,DemandeController::class);


Route::apiResource('rayon', RayonController::class);

Route::apiResource('categorie', CategorieController::class);

Route::apiResource('promotion', PromotionController::class);

Route::apiResource('produit', ProduitController::class);

// Route::post('modifierStock' , [ProduitController::class , 'modifierStock']);

Route::get('recherche' , [ProduitController::class , 'recherche']); 

// Route::get('Stockaible' , [ProduitController::class , 'StockFaible']);

// Route::get('stock-faible' , [ProduitController::class , 'StockFaible']);  

Route::get('produit-demande' , [ProduitController::class , 'ProduitDemande']); 


Route::get('consulter-produit' , [DemandeController::class , 'consulterProduit']); 


Route::get('recherche-produit' , [DemandeController::class , 'rechercheProduit']);

Route::get('produits-populaire' , [DemandeController::class , 'rechercheProduit']); 

