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
        // カテゴリーと共に紐づくクイズとその選択肢を取得
        $category = Category::with("quizzes.options")->findOrFail($categoryId);
        // クイズを配列にして取得
        $quizzes = $category->quizzes->toArray();
        // ランダムに表示するためシャッフル
        shuffle($quizzes);
        // シャッフルされた配列より一つのクイズを選択
        $quiz = $quizzes[0];

        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz' =>  $quiz
        ]);

    }
}













//  // カテゴリーに紐づくクイズと選択肢を全て取得する
//  $category = Category::with("quizzes.options")->findOrFail($categoryId);
//  // クイズをランダムに選ぶ
//  $quizzes = $category->quizzes->toArray();
//  shuffle($quizzes);
//  $quiz = $quizzes[0];

//  // dd($quiz);
//  return view('play.quizzes', [
//      'categoryId' => $categoryId,
//      'quiz' =>  $quiz
//  ]);
