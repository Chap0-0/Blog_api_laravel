<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// регистрация и авторизация
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// методы постов
Route::get("/posts", [PostController::class, 'index']);
Route::get("/post/{post_id}", [PostController::class, 'show']);

Route::middleware("auth:sanctum")->group(function() {
    Route::post("/post-store", [PostController::class,'store']);
    Route::patch("/post-publish/{post_id}", [PostController::class, 'publish']);
    Route::post("/post-like/{post_id}", [PostController::class, 'like']);
});