<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function quizzes()
    {
        // 固有のcategoryに紐づくクイズを取得
        return  $this->hasMany(Quiz::class);
    }
}
