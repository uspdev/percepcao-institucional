<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['campo' => 'array'];

    /**
     * Relacionamento com os grupos
     */
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class)
            ->as('grupo')
            ->withTimestamps()
            ->withPivot('ordem')
            ->with('childGrupos')
            ->orderBy('ordem');
    }
}
