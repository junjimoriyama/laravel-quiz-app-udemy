<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, int $categoryId)
    {
        //クイズ新規登録画面
        return view('admin.quizzes.create', [
            'categoryId' => $categoryId
        ]);
    }

    /**
     * クイズ新規登録処理
     */
    public function store(StoreQuizRequest $request, int $categoryId)
    {
        // クイズについて
        $quiz = new Quiz();
        // $categoryIdはパラメーターの{categoryId}
        $quiz->category_id = $categoryId;
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        // オプションについて

        for ($i = 1; $i <= 4; $i++) {
            $option = new Option();
            $option->quiz_id = $quiz->id;
            $option->content = $request->input("content{$i}");
            $option->is_correct = $request->input("isCorrect{$i}");
            $option->save();
        }

        // 第二引数のキーがルートのパラメーターに対応している
        return to_route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * クイズ編集
     */
    public function edit(Request $request, int $categoryId, int $quizId)
    {

        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
        // クイズ編集ページへ遷移
        return view('admin.quizzes.edit', [
            'categoryId' => $categoryId,
            'quiz' => $quiz,
            'options' => $quiz->options
        ]);
    }

    /**
     * クイズ更新
     */
    public function update(UpdateQuizRequest $request, int $categoryId, int $quizId)
    {
        // dd($request->method());
        // クイズ更新
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        for ($i = 1; $i <= 4; $i++) {
            $optionId = $request->input("optionId{$i}");
            $option = Option::findOrFail($optionId);
            $option->content = $request->input("content{$i}");
            $option->is_correct = $request->input("isCorrect{$i}");
            $option->save();
        }
        return to_route('admin.categories.show', [
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}

        // // オプションの登録
        // $options = [
        //     [ 'quiz_id' => $quiz->id, 'content' => $request->content1, 'isCorrect' => $request->is_correct1],
        //     [ 'quiz_id' => $quiz->id, 'content' => $request->content2, 'isCorrect' => $request->is_correct2],
        //     [ 'quiz_id' => $quiz->id, 'content' => $request->content3, 'isCorrect' => $request->is_correct3],
        //     [ 'quiz_id' => $quiz->id, 'content' => $request->content4, 'isCorrect' => $request->is_correct4],
        // ];

        // foreach($options as $option) {
        //     $newOption = new Option();
        //     $newOption->quiz_id = $option['quiz_id'];
        //     $newOption->content = $option['content'];
        //     $newOption->is_correct = $option['isCorrect'];
        //     $newOption->save();
        // }

    // 1️⃣ Blade の `route()` で `categoryId` を URL に埋め込む
    //    ⬇
    // 2️⃣ `web.php` のルート `{categoryId}/quizzes/store` に `categoryId` を渡す
    //    ⬇
    // 3️⃣ `store()` メソッドの `$categoryId` に値が渡り、`quiz->category_id` に保存される


// 📌 実際のデータベース構造
// 1️⃣ quizzes テーブル
// id	category_id	question	explanation
// 1	2	問題1	解説1
// 2️⃣ options テーブル（quiz_id が quizzes.id を参照）
// id	quiz_id	content	is_correct
// 1	1	選択肢A	0
// 2	1	選択肢B	1


//  //categoryやoptionsはモデルで定義されたリレーションメソッドの名前
//  $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
//  return view('admin.quizzes.edit', [
//      'categoryId' => $categoryId,
//      'quiz' => $quiz,
     // 'options' => $quiz->options,
//  ]);
