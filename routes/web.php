<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AchievementController;
use App\Models\Post;

Route::get('/', function () {
    $posts = Post::latest()->take(3)->get(); // Ambil 3 berita terbaru
    return view('welcome', compact('posts'));
});

// Route untuk halaman News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// Route untuk halaman Records
Route::get('/records', [App\Http\Controllers\RecordsController::class, 'index'])->name('records.index');
Route::get('/records/{id}', [App\Http\Controllers\RecordsController::class, 'show'])->name('records.show');

// Customer Routes
Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::get('/prestasi/{prestasi}', [PrestasiController::class, 'show'])->name('prestasi.show');
    Route::get('/prestasi/rekomendasi/create', [PrestasiController::class, 'createRekomendasi'])->name('prestasi.rekomendasi.create');
    Route::post('/prestasi/rekomendasi', [PrestasiController::class, 'storeRekomendasi'])->name('prestasi.rekomendasi.store');
    // todo: add more routes for prestasi management later (index, edit, update, destroy)
});



// Rute umum untuk semua yang login
Route::middleware(['auth'])->group(function () {
    
    // Khusus Admin (Bisa mengelola User lain)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/customers', CustomerController::class)->only(['index', 'show'])->names('admin.customers');
        Route::resource('/admin/achievements', AchievementController::class)->only(['index', 'show', 'edit', 'update'])->names('admin.achievements');
    });

    // Editor & Admin bisa mengelola Berita dan Halaman
    Route::resource('posts', PostController::class);
    Route::resource('pages', PageController::class)->except(['show']); // 'show' akan ditangani oleh rute publik
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === 'editor') {
        return view('dashboard');
    }
    if ($user->role === 'pelanggan') {
        return view('customer.dashboard');
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk detail berita (slug digunakan agar URL lebih SEO friendly)
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('posts.show.public');

// Rute untuk Halaman Statis (harus paling akhir sebelum auth)
Route::get('/p/{page:slug}', [PageController::class, 'show'])->name('pages.show');

require __DIR__.'/auth.php';
