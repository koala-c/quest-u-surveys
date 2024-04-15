<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Survey extends Model
{
    public $timestamps = false;

    protected $table = "enquesta";

    protected $primaryKey = 'codienquesta';

    protected $fillable = [
        'descenquesta',
        'datavalidesaenq',
        'datacreacioenq',
        'codienquestador',
    ];

    /**
     * Get the questions associated with the survey.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'codienquesta');
    }
}


