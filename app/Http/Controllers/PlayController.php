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

    public function answer(Request $request, int $categoryId)
    {
        // 選んだの解答(id)
        $quizId = $request->quizId;
        // 配列を期待しているので
        $selectedOptions = $request->optionId === null ? [] : $request->optionId;
        // クイズの選択肢
        // カテゴリーから全てのクイズ取得
        $category = Category::with("quizzes.options")->findOrFail($categoryId);
        // カテゴリーに紐づく全てのクイズ
        $quizzes = $category->quizzes;
        // 選択肢たクイズはクイズの中にあるidがクイズのidと合致するもの
        $quiz = $quizzes->firstWhere('id', $quizId);
        // 合致するクイズのオプション
        $quizOptions = $quiz->options->toArray();
        // 関数の実行
        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

        return view('play.answer', [
            "isCorrectAnswer" => $isCorrectAnswer,
            "quiz" => $quiz->toArray(),
            "quizOptions" => $quizOptions,
            "selectedOptions" => $selectedOptions,
            "categoryId" => $categoryId,
        ]);
    }

    // プレイヤーの解答が正解か不正解か判定
    private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
    {
        // クイズの選択肢から正解の選択肢を抽出
        $correctOptions = array_filter($quizOptions, function($option) {
            return $option["is_correct"] == 1;
        });

        // idの数字だけ抽出
        $correctOptionIds = array_map(function($option) {
            return $option['id'];
        },  $correctOptions);

        // プレイヤーが選んだ選択肢の個数と正解の選択肢の個数が一致するか判定する
        if(count($selectedOptions) !== count($correctOptionIds)) {
            return false;
        }
        // プレイヤーが選んだ選択肢のid番号と正解のidが全て一致することを判定する
        foreach( $selectedOptions as $selectedOption) {
            if(!in_array((int)$selectedOption, $correctOptionIds)) {
                return false;
            }
        }
        // 正解であることを返す
        return true;
    }
}

