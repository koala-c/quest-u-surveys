<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipus_pregunta';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'coditipus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nomtipus'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the question associated with the answer option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'codipregunta');
    }
}
