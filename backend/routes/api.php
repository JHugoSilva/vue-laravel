<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;


Route::controller(UsuarioController::class)->group(function(){
    Route::get("user", "index");
    Route::get("user/{id}", "show");
    Route::post("user", "store");
    Route::put("user/{id}", "update");
    Route::delete("user/{id}", "destroy");
});

Route::get("user-export/{type}", [ArquivoController::class, "index"]);

