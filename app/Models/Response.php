<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'answer_date',
        'question_id'
    ];

    // public function survey()
    // {
    //     return $this->belongsTo(Survey::class);
    // }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // public function answerOption()
    // {
    //     return $this->belongsTo(AnswerOption::class);
    // }
}
