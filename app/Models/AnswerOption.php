<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    public $timestamps = false;

    use HasFactory;

    protected $fillable = ['content'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
