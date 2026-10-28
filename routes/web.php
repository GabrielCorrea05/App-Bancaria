<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BizumController;
use App\Http\Controllers\ClientCompteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/comptes/crear', [ClientCompteController::class, 'create'])->name('client.comptes.create');
    Route::post('/comptes', [ClientCompteController::class, 'store'])->name('client.comptes.store');
    Route::get('/comptes/{compte}', [ClientCompteController::class, 'show'])->name('client.comptes.show');
    Route::get('/bizums', [BizumController::class, 'create'])->name('bizums.create');
    Route::post('/bizums', [BizumController::class, 'store'])->name('bizums.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/{section}/{id}', [AdminController::class, 'show'])->name('show');
    Route::get('/{section}/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{section}/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{section}/{id}', [AdminController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
