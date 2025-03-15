<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlayController;
use Illuminate\Support\Facades\Route;

// プレイヤー画面
Route::get('/', [PlayController::class, 'top'])->name('top');

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

// 管理画面
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 管理画面topページ,カテゴリー一覧表示
    Route::get('top', [CategoryController::class, 'top'])->name('top');

    // カテゴリー管理
    Route::prefix('categories')->name('categories.')->group(function () {
        // カテゴリー管理
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        // カテゴリー新規登録処理
        Route::Post('store', [CategoryController::class, 'store'])->name('store');
        // カテゴリー詳細画面　兼　クイズ一覧画面　表示
        Route::get('{categoryId}', [CategoryController::class, 'show'])->name('show');
        // カテゴリー編集画面
        Route::get('{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
        // カテゴリー更新
        Route::post('{categoryId}/update', [CategoryController::class, 'update'])->name('update');
        // カテゴリー削除
        Route::delete('{categoryId}/destroy', [CategoryController::class, 'destroy'])->name('destroy');

        // クイズ管理
        Route::prefix('{categoryId}/quizzes')->name('quizzes.')->group(function () {
            // クイズ新規登録画面
            Route::get('create', [QuizController::class, 'create'])->name('create');
            // クイズ新規登録処理
            Route::post('store', [QuizController::class, 'store'])->name('store');
            // クイズ編集画面表示
            Route::get('{quizId}/edit', [QuizController::class, 'edit'])->name('edit');
            // クイズ編集処理
            Route::post('{quizId}/update', [QuizController::class, 'update'])->name('update');
            // クイズ削除
            Route::delete('{quizId}/destroy', [QuizController::class, 'destroy'])->name('destroy');
        });
    });
});

// プレイヤー画面
// Route::prefix('play')->name('play.')->group(function () {
//     // カテゴリー取得
//     Route::get('/', [PlayController::class, 'top'])->name('top');
// });
