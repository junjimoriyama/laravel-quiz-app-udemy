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
    // クイズスタート画面
    public function categories(int $categoryId)
    {
        $category = Category::withCount('quizzes')->findOrFail($categoryId);

        // クイズスタート画面表示
        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count
        ]);
    }
    // クイズ出題画面
    public function quizzes(int $categoryId)
    {
        // カテゴリーに紐づくクイズと選択肢を全て取得する
        $category = Category::with("quizzes.options")->findOrFail($categoryId);
        // クイズをランダムに選ぶ
        $quizzes = $category->quizzes->toArray();
        shuffle($quizzes);
        $quiz = $quizzes[0];

        // dd($quiz);
        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz' =>  $quiz
        ]);
    }
}


















