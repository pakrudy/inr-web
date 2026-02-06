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
use App\Http\Controllers\Admin\RecommendationCategoryController as AdminRecommendationCategoryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\NotificationController;
use App\Models\Post;
use App\Models\Legacy;
use App\Models\Recommendation;

Route::get('/', function () {
    $posts = Post::latest()->take(3)->get();
    $legacies = Legacy::with('user')->where('status', 'active')->latest()->take(3)->get();
    $recommendations = Recommendation::where('status', 'active')->latest()->take(4)->get();
    return view('welcome', compact('posts', 'legacies', 'recommendations'));
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

    // Legacy Upgrade Application Routes
    Route::get('legacies/{legacy}/upgrade', [\App\Http\Controllers\Customer\LegacyUpgradeApplicationController::class, 'selectPackage'])->name('legacies.upgrade.select');
    Route::get('legacies/{legacy}/upgrade/{package_slug}/apply', [\App\Http\Controllers\Customer\LegacyUpgradeApplicationController::class, 'showApplicationForm'])->name('legacies.upgrade.apply');
    Route::post('legacies/{legacy}/upgrade/{package_slug}/apply', [\App\Http\Controllers\Customer\LegacyUpgradeApplicationController::class, 'storeApplication']);

    // Recommendation Routes
    Route::resource('recommendations', RecommendationController::class);
    Route::get('recommendations/{recommendation}/payment', [TransactionController::class, 'create'])->name('recommendations.payment.create');
    Route::post('recommendations/{recommendation}/payment', [TransactionController::class, 'store'])->name('recommendations.payment.store');

    // Recommendation Upgrade Application Routes
    Route::get('recommendations/{recommendation}/upgrade', [\App\Http\Controllers\Customer\RecommendationUpgradeApplicationController::class, 'selectPackage'])->name('recommendations.upgrade.select');
    Route::get('recommendations/{recommendation}/upgrade/{package_slug}/apply', [\App\Http\Controllers\Customer\RecommendationUpgradeApplicationController::class, 'showApplicationForm'])->name('recommendations.upgrade.apply');
    Route::post('recommendations/{recommendation}/upgrade/{package_slug}/apply', [\App\Http\Controllers\Customer\RecommendationUpgradeApplicationController::class, 'storeApplication']);
});



// Rute umum untuk semua yang login
Route::middleware(['auth'])->group(function () {
    
    // Khusus Admin (Bisa mengelola User lain)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/customers', CustomerController::class)->only(['index', 'show', 'edit', 'update'])->names('admin.customers');
        Route::resource('/admin/legacies', AdminLegacyController::class)->names('admin.legacies');
        Route::resource('/admin/recommendations', AdminRecommendationController::class)->names('admin.recommendations');
        Route::resource('/admin/recommendation-categories', AdminRecommendationCategoryController::class)->names('admin.recommendation-categories');
        Route::resource('/admin/recommendation-upgrade-packages', \App\Http\Controllers\Admin\RecommendationUpgradePackageController::class)->names('admin.recommendation-upgrade-packages');
        
        
        // Settings Routes
        Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [AdminSettingController::class, 'store'])->name('admin.settings.store');
        
        // Transaction Management
        Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::patch('/admin/transactions/{transaction}', [AdminTransactionController::class, 'confirm'])->name('admin.transactions.confirm');
        Route::resource('/admin/upgrade-packages', \App\Http\Controllers\Admin\UpgradePackageController::class)->names('admin.upgrade-packages');
        Route::resource('/admin/categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
        
        // Legacy Upgrade Applications
        Route::get('/admin/legacy-upgrades', [\App\Http\Controllers\Admin\LegacyUpgradeApplicationController::class, 'index'])->name('admin.legacy-upgrades.index');
        Route::get('/admin/legacy-upgrades/{application}', [\App\Http\Controllers\Admin\LegacyUpgradeApplicationController::class, 'show'])->name('admin.legacy-upgrades.show');
        Route::post('/admin/legacy-upgrades/{application}/approve', [\App\Http\Controllers\Admin\LegacyUpgradeApplicationController::class, 'approve'])->name('admin.legacy-upgrades.approve');
        Route::post('/admin/legacy-upgrades/{application}/reject', [\App\Http\Controllers\Admin\LegacyUpgradeApplicationController::class, 'reject'])->name('admin.legacy-upgrades.reject');

        // Recommendation Upgrade Applications
        Route::get('/admin/recommendation-upgrades', [\App\Http\Controllers\Admin\RecommendationUpgradeApplicationController::class, 'index'])->name('admin.recommendation-upgrades.index');
        Route::get('/admin/recommendation-upgrades/{application}', [\App\Http\Controllers\Admin\RecommendationUpgradeApplicationController::class, 'show'])->name('admin.recommendation-upgrades.show');
        Route::post('/admin/recommendation-upgrades/{application}/approve', [\App\Http\Controllers\Admin\RecommendationUpgradeApplicationController::class, 'approve'])->name('admin.recommendation-upgrades.approve');
        Route::post('/admin/recommendation-upgrades/{application}/reject', [\App\Http\Controllers\Admin\RecommendationUpgradeApplicationController::class, 'reject'])->name('admin.recommendation-upgrades.reject');
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
