<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Kategori as AdminKategori;
use App\Livewire\Admin\Barang;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Ketegori;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Models\Kategori as ModelsKategori;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard untuk SEMUA user yang login
    Route::get('', UserDashboard::class)->name('dashboard');

    // Route ADMIN ONLY dengan middleware role
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/user', User::class)->name('admin.user');

        // Kategori Livewire (lebih konsisten)
        // Route::get('/kategori', ModelsKategori::class)->name('admin.kategori');

        // Barang Livewire
        Route::get('/barang', Barang::class)->name('admin.barang');
        Route::get('/kategori', Ketegori::class)->name('admin.kategori');
    });
});
