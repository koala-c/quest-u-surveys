<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswerOption; // Include AnswerOption model for relationship

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'type'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function response()
    {
        return $this->hasMany(Response::class);
    }
}
