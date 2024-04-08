<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Survey extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enquesta';

    protected $fillable = [
        'description',
        'start_date',
        'end_date'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
