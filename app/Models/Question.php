<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswerOption; // Include AnswerOption model for relationship

class Question extends Model
{
    public $timestamps = false;

    protected $table = "pregunta";

    protected $primaryKey = 'codipregunta';

    protected $fillable = [
        'enunciat',
        'coditipus',
        'codienquesta',
        'esopcio'
    ];

    public function answerOptions()
    {
        return $this->belongsToMany(AnswerOption::class, 'pregunta_tipus_opcio', 'codipregunta', 'codiresposta')
                    ->withPivot('descripcio');
    }
}
