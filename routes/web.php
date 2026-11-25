<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogPublicController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

// ── Public routes ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blog (public)
Route::get('/blog',         [BlogPublicController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',  [BlogPublicController::class, 'show'])->name('blog.show');

// Sitemap XML
Route::get('/sitemap.xml', function () {
    $posts = \App\Models\BlogPost::published()->latest('published_at')->get();
    $content = view('sitemap', compact('posts'))->render();
    return response($content, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Robots.txt
Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nDisallow: /dashboard\nDisallow: /admin\nDisallow: /login\nDisallow: /register\n\nSitemap: " . url('/sitemap.xml'),
        200
    )->header('Content-Type', 'text/plain');
});

// ── Authentication ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->middleware('login.limiter');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->middleware('throttle:5,10');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin routes ───────────────────────────────────────────────
Route::middleware(['auth', 'admin', 'throttle:60,1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.blog.index'))->name('home');
        Route::resource('blog', AdminBlogController::class)->except(['show']);
    });

// ── Authenticated app routes ───────────────────────────────────
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/business/edit', [BusinessProfileController::class, 'edit'])->name('business.edit');
    Route::put('/business',      [BusinessProfileController::class, 'update'])->name('business.update');

    Route::resource('categories',  CategoryController::class)->except(['show']);
    Route::resource('products',    ProductController::class)->except(['show']);
    Route::resource('transactions',TransactionController::class)->except(['edit','update']);

    Route::get('/reports',         [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export',  [ReportController::class, 'export'])->name('reports.export');
});
