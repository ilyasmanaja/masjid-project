<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/kajian', [HomeController::class, 'kajian'])->name('kajian');
Route::get('/berita', [HomeController::class, 'posts'])->name('posts.index');
Route::get('/keuangan', [HomeController::class, 'keuangan'])->name('keuangan');
Route::get('/berita/{slug}', [HomeController::class, 'postDetail'])->name('posts.show');

Route::get('/uploads/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    $file = file_get_contents($fullPath);
    $type = mime_content_type($fullPath);

    return Response::make($file, 200)->header("Content-Type", $type);
})->where('path', '.*');