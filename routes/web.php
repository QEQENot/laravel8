<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/news', [WebController::class, 'news'])->name('news');
Route::get('/news/{id}', [WebController::class, 'newsDetail'])->name('news.detail');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/slider', [AdminController::class, 'slider'])->name('slider');
        Route::post('/slider/update/{id}', [AdminController::class, 'updateSlider'])->name('slider.update');

        Route::get('/news', [AdminController::class, 'newsList'])->name('news');
        Route::get('/news/create', [AdminController::class, 'createNews'])->name('news.create');
        Route::post('/news/store', [AdminController::class, 'storeNews'])->name('news.store');
        Route::get('/news/edit/{id}', [AdminController::class, 'editNews'])->name('news.edit');
        Route::post('/news/update/{id}', [AdminController::class, 'updateNews'])->name('news.update');
        Route::get('/news/delete/{id}', [AdminController::class, 'deleteNews'])->name('news.delete');

        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::post('/categories/update/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::get('/categories/delete/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::any('/home', function() {
    return redirect('/');
});

Route::post('/news/{id}/comment', [WebController::class, 'addComment'])->name('news.comment');
Route::post('/comment/{id}/delete', [WebController::class, 'deleteComment'])->middleware(['auth', 'admin'])->name('comment.delete');
