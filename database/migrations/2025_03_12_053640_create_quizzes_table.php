<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            // 外部キー
            $table->foreignId('category_id')
                    ->constrained() // categoryテーブルのidと紐付け
                    ->onUpdate('cascade') //親テーブルと同時更新
                    ->onDelete('cascade') //親テーブルと同時削除
                    ->comment('カテゴリーID');
            $table->text('question')->comment('問題文');
            $table->text('explanation')->comment('解説');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
