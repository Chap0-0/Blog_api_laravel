<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// регистрация и авторизация
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// методы постов
Route::get("/posts", [PostController::class, 'index']);
Route::get("/posts/{post}", [PostController::class, 'show']);

Route::middleware("auth:sanctum")->group(function() {
    Route::post("/posts", [PostController::class,'store']);
    Route::patch("/posts/{post}/publish", [PostController::class, 'publish']);
    Route::post("/posts/{post}/like", [PostController::class, 'like']);
});