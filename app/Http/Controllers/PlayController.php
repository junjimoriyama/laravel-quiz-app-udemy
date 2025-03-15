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
        $category = Category::withCount('quizzes')->findOrFail($categoryId);

        // クイズスタート画面表示
        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count
        ]);
    }
}


















