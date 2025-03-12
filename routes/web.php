<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 現在の階層にあるファイル呼び出し
require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 管理画面topページ,カテゴリー一覧表示
    Route::get('top', [CategoryController::class, 'top'])->name('top');

    Route::prefix('categories')->name('categories.')->group(function () {
        // カテゴリー管理
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        // カテゴリー新規登録処理
        Route::Post('store', [CategoryController::class, 'store'])->name('store');
        // カテゴリー詳細画面
        Route::get('{categoryId}', [CategoryController::class, 'show'])->name('show');
        // カテゴリー編集画面
        // Route::get('{categoryId}', [CategoryController::class, 'edit'])->name('edit');
    });
});
