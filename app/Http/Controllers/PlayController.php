<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PlayController extends Controller
{

    // プレイ画面のトップページ
    public function top()
    {
        $categories = Category::all();
        return view('play.top', [
            'categories' => $categories
        ]);
    }

    public function categories(int $categoryId)
    {
        // 表示するカテゴリーの取得
        $category = Category::findOrFail($categoryId);
        return view('play.start', [
            'category' => $category
        ]);
    }

    // クイズスタート画面表示

}



































// public function categories(Request $request, int $categoryId)
// {
//     $category = Category::findOrFail($categoryId);
//     return view("play.start",[
//         'category' => $category
//     ] );
// }

// Route::get('categories/{categoryId}', [PlayController::class, 'categories'])->name('categories');
