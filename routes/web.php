<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RayonController;


Route::get('/', function () {
    return view('welcome');
});


// Route::apiResource("rayon",RayonController::class);
