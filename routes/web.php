<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicLegacyController;
use App\Http\Controllers\PublicRecommendationController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LegacyController as AdminLegacyController;
use App\Http\Controllers\Admin\RecommendationController as AdminRecommendationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\NotificationController;
use App\Models\Post;

Route::get('/', function () {
    $posts = Post::latest()->take(3)->get(); // Ambil 3 berita terbaru
    return view('welcome', compact('posts'));
});

// Route untuk halaman News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// Route untuk halaman Records (Public Legacies)
Route::get('/records', [PublicLegacyController::class, 'index'])->name('records.index');
Route::get('/records/{legacy}', [PublicLegacyController::class, 'show'])->name('records.show');

// Route untuk halaman Public Recommendations
Route::get('/recommendations', [PublicRecommendationController::class, 'index'])->name('recommendations.index');
Route::get('/recommendations/{recommendation}', [PublicRecommendationController::class, 'show'])->name('recommendations.show');

// Customer Routes
Route::middleware(['auth', 'verified', 'role:pelanggan'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    
    // Legacy Routes
    Route::resource('legacies', LegacyController::class);
    Route::get('legacies/{legacy}/payment', [TransactionController::class, 'create'])->name('legacies.payment.create');
    Route::post('legacies/{legacy}/payment', [TransactionController::class, 'store'])->name('legacies.payment.store');

    // Recommendation Routes
    Route::resource('recommendations', RecommendationController::class);
    Route::get('recommendations/{recommendation}/payment', [TransactionController::class, 'create'])->name('recommendations.payment.create');
    Route::post('recommendations/{recommendation}/payment', [TransactionController::class, 'store'])->name('recommendations.payment.store');
});



// Rute umum untuk semua yang login
Route::middleware(['auth'])->group(function () {
    
    // Khusus Admin (Bisa mengelola User lain)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/customers', CustomerController::class)->only(['index', 'show'])->names('admin.customers');
        Route::resource('/admin/legacies', AdminLegacyController::class)->names('admin.legacies');
        Route::resource('/admin/recommendations', AdminRecommendationController::class)->names('admin.recommendations');
        
        // Settings Routes
        Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [AdminSettingController::class, 'store'])->name('admin.settings.store');
        
        // Transaction Management
        Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::patch('/admin/transactions/{transaction}', [AdminTransactionController::class, 'confirm'])->name('admin.transactions.confirm');
    });

    // Editor & Admin bisa mengelola Berita dan Halaman
    Route::resource('posts', PostController::class);
    Route::resource('pages', PageController::class)->except(['show']); // 'show' akan ditangani oleh rute publik
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification Route
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
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
        $notifications = $user->unreadNotifications;
        return view('customer.dashboard', compact('notifications'));
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk detail berita (slug digunakan agar URL lebih SEO friendly)
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('posts.show.public');

// Rute untuk Halaman Statis (harus paling akhir sebelum auth)
Route::get('/p/{page:slug}', [PageController::class, 'show'])->name('pages.show');

require __DIR__.'/auth.php';
