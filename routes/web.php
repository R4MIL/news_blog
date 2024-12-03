<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Blog\ArticleController;
use App\Http\Controllers\Blog\CommentController;
use App\Http\Controllers\Blog\CountryFlagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Blog\WeatherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PHPUnit\Framework\Constraint\Count;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/get/{id}', [ArticleController::class, 'get'])->name('articles.get');
    Route::post('/articles/comment/{article}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
    Route::get('/weather/get', [WeatherController::class, 'get'])->name('weather.get');

    Route::get('/country-flags', [CountryFlagController::class, 'index'])->name('country.flag.index');
    Route::get('/country-flags/get', [CountryFlagController::class, 'get'])->name('country.flag.get');
});


Route::middleware('admin')->group(function () {
    Route::get('/administration', [AdminController::class, 'index'])->name('administration.index');
    Route::get('/articles/add', [ArticleController::class, 'add'])->name('articles.add');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/edit/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/update/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('articles.delete');
});


require __DIR__.'/auth.php';
