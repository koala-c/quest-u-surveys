<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'resposta';
    protected $primaryKey = 'codiresposta';

    protected $fillable = [
        'resposta',
        'dataresposta',
        'codipregunta'
    ];

    // Define la relación entre la respuesta y la pregunta
    public function question()
    {
        return $this->belongsTo(Question::class, 'codipregunta', 'codipregunta');
    }
}
