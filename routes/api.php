<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TugasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
//Berita Routes
Route::get('/berita', [BeritaController::class, 'index']);

Route::get('/berita/{id}', [BeritaController::class, 'show']);

Route::middleware(['auth:sanctum','role:admin,osis,guru'])->group(function () {
    Route::post('/berita', [BeritaController::class, 'store']);
    Route::put('/berita/{id}', [BeritaController::class, 'update']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
});

// Library Routes

Route::middleware(['auth:sanctum'])->group(function () {
    route::get('/library', [LibraryController::class, 'index']);
    route::get('/library/{id}', [LibraryController::class, 'show']);
});

Route::middleware(['auth:sanctum','role:admin,osis,guru'])->group(function () {
    route::post('/library', [LibraryController::class, 'store']);
    route::put('/library/{id}', [LibraryController::class, 'update']);
    route::delete('/library/{id}', [LibraryController::class, 'destroy']);
});

// tugas routes
Route::middleware(['auth:sanctum','role:siswa,osis'])->group(function () {
    route::get('/tugas', [TugasController::class, 'index']);
    route::get('/tugas/{id}', [TugasController::class, 'show']);
});

Route::middleware(['auth:sanctum','role:admin,guru'])->group(function () {
    route::post('/tugas', [TugasController::class, 'store']);
    route::put('/tugas/{id}', [TugasController::class, 'update']);
    route::delete('/tugas/{id}', [TugasController::class, 'destroy']);
});

//route user 

Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    route::post('/user', [UserController::class, 'store']);
    route::put('/user/{id}', [UserController::class, 'update']);
    route::delete('/user/{id}', [UserController::class, 'destroy']);
});

route::middleware(['auth:sanctum'])->group(function () {
    route::get('/user', [UserController::class, 'index']);
    route::get('/user/{id}', [UserController::class, 'show']);
    route::put('/user/{id}', [UserController::class, 'update']);
});


require __DIR__.'/auth.php';
