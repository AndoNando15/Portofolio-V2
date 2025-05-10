<?php

use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\GambarProyekController;
use App\Http\Controllers\JudulController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\TentangKamiGambarController;
use App\Http\Controllers\KontakController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('judul', JudulController::class);
Route::resource('tentang-kami', TentangKamiController::class);
Route::resource('tentang-kami-gambar', TentangKamiGambarController::class);
Route::resource('skill', SkillController::class);
Route::resource('proyek', ProyekController::class);
Route::resource('pesan', PesanController::class);
Route::resource('footer', FooterController::class);
Route::resource('subProyek', GambarProyekController::class);
Route::resource('tech', TechController::class);

Route::resource('error', ErrorController::class);
Route::resource('kontak', KontakController::class);