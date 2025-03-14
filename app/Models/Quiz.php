<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\belongsTo;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;

    // クイズは一つのカテゴリーを持つ
    public function category() {
        return $this->belongsTo(Category::class);
    }
    // クイズは複数のオプションを持つ
    public function options() {
        return $this->hasMany(Option::class);
    }
}
