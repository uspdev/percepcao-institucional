<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relacionamento com a questão
     */
    public function questaos()
    {
        return $this->belongsTo(Questao::class);
    }

    /**
     * Relacionamento com os usuários
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
