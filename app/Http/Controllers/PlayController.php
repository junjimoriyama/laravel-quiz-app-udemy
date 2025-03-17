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
        // セッションの削除
        session()->forget('resultArray');

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

        // dd(session('resultArray'));
        // カテゴリーと共に紐づくクイズとその選択肢を取得
        $category = Category::with("quizzes.options")->findOrFail($categoryId);
        // セッションに保存されているクイズIDの配列を取得
        $resultArray = session('resultArray', []);
        // 初回アクセス時はセッションがない
        if (empty($resultArray)) {
            // クイズのidを全て取得
            $quizIds = $category->quizzes->pluck('id')->toArray();
            // それをランダムにする
            shuffle($quizIds);
            // 結果の配列に'quizId'と'result'を連想配列で入れる
            $resultArray = array_map(fn($quizId) => [
                'quizId' => $quizId,
                'result' => null
            ], $quizIds);
            // セッションの保存
            session(['resultArray' => $resultArray]);
        }

        // $resultArrayのresultがnullのものだけ選ぶ
        $noAnswerResult = collect($resultArray)->filter(fn($item) => $item['result'] === null)->first();


        // クイズの解答がなければresult画面は
        if (!$noAnswerResult) {
            // dd($noAnswerResult);
            return to_route('categories.quizzes.result', [
                'categoryId' => $categoryId
            ]);
        }
        // quizzes の中から id が $noAnswerResult['quizId'] に一致する最初の要素を取得
        $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();
        // もしresultがnullのものがなければ

        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz' => $quiz
        ]);
    }

    public function answer(Request $request, int $categoryId)
    {
        // 選んだのクイズのid
        $quizId = $request->quizId;
        // 選んだクイズの選択肢（配列を期待）
        $selectedOptions = $request->optionId === null ? [] : $request->optionId;
        // クイズの選択肢
        // カテゴリー取得
        $category = Category::with("quizzes.options")->findOrFail($categoryId);
        // カテゴリーから全てのクイズ取得
        $quizzes = $category->quizzes;
        // 選択したクイズはクイズの中にあるidがクイズのidと合致するもの
        $quiz = $quizzes->firstWhere('id', $quizId);
        // 合致するクイズのオプション
        $quizOptions = $quiz->options->toArray();
        // 関数の実行
        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

        // セッションからクイズIDと回答情報取得
        $resultArray = session('resultArray');
        // 📌 この処理の目的は、セッション (session('resultArray')) に保存されたクイズIDと回答結果 (result) を更新する
        // 📌 ユーザーがクイズに回答したら、その結果を result フィールドに保存する.
        // セッションからクイズIDと回答情報取得
        $resultArray = session('resultArray', []); //もし `null` だった場合、デフォルト値として `[]`（空配列）を設定
        // 回答結果をセッションに保存
        foreach ($resultArray as $index => $result) {
            //結果の中の `quizId` と選択された `quizId` を比較して、合うものを更新
            if ($result['quizId'] === (int)$quizId) {
                //`result` に正解か不正解の真偽値を代入
                $resultArray[$index]['result'] = $isCorrectAnswer;
            }
        }
        //更新後の `resultArray` をセッションに保存(上書き)
        session(['resultArray' => $resultArray]);

        // dd($isCorrectAnswer);

        return view('play.answer', [
            // 正解か不正解か判定
            "isCorrectAnswer" => $isCorrectAnswer,
            // クイズ
            "quiz" => $quiz,
            // 選ばれた選択肢
            "selectedOptions" => $selectedOptions,
            // カテゴリーID
            "categoryId" => $categoryId,
        ]);
    }

    // プレイヤーの解答が正解か不正解か判定
    private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
    {
        // クイズの選択肢から正解の選択肢を抽出
        $correctOptions = array_filter($quizOptions, fn($option) => $option['is_correct'] === 1);

        // idの数字だけ抽出
        $correctOptionIds = array_map(fn($option) => $option['id'], $correctOptions);

        // プレイヤーが選んだ選択肢の個数と正解の選択肢の個数が一致するか判定する
        if (count($selectedOptions) !== count($correctOptionIds)) {
            return false;
        }

        // プレイヤーが選んだ選択肢のid番号と正解のidが全て一致することを判定する
        foreach ($selectedOptions as $selectedOption) {
            // もし選択肢したidが正解のidに含まれていなければ
            if (!in_array((int)$selectedOption, $correctOptionIds)) {
                return false;
            }
        }

        // 正解であることを返す
        return true;
    }

    // result画面表示
    public function result(int $categoryId)
    {
        // セッションより結果取得
        $resultArray = session('resultArray');
        // クイズの数
        $questionCount = count($resultArray);
        // 正解の数
        $correctCount = collect($resultArray)->filter(fn($item) => $item['result'] === true)->count();

        return view('play.result', [
            'questionCount' => $questionCount,
            'correctCount' => $correctCount,
            'categoryId' => $categoryId,
        ]);
    }
}

// public function quizzes(int $categoryId)
// {
//     // カテゴリーと共に紐づくクイズとその選択肢を取得
//     $category = Category::with("quizzes.options")->findOrFail($categoryId);
//     // セッションに保存されているクイズIDの配列を取得
//     $resultArray = session('resultArray');
//     // 初回アクセス時はセッションがない
//     if(is_null($resultArray)) {
//         $quizIds = $category->quizzes->pluck('id')->toArray();
//         shuffle($quizIds);

//         $resultArray = array_map(fn($quizId) => [
//             'quizId' => $quizId,
//             'result' => null,
//         ],  $quizIds);

//         session(['resultArray' => $resultArray]);
//     }

//     // $resultArrayのresultがnullのものだけ選ぶ
//     $noAnswerResult = collect($resultArray)->filter(fn($item) => $item['result'] === null)->first();

//     if(!$noAnswerResult) {

//     }

//     $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();

//     return view('play.quizzes', [
//         'categoryId' => $categoryId,
//         'quiz' => $quiz
//     ]);
// }
