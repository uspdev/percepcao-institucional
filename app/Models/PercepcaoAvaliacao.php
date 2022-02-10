<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PercepcaoAvaliacao extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Relacionamento com a percepcao
     */
    public function percepcao()
    {
        return $this->belongsTo(Percepcao::class);
    }

    /**
     * Relacionamento com o usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
