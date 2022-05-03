<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'parent_id');
    }

    public function childGrupos()
    {
        return $this->hasMany(Grupo::class, 'parent_id')->with('grupos');
    }

    public function percepcaos()
    {
        return $this->belongsToMany(Percepcao::class);
    }

    public function questaos()
    {
        return $this->belongsToMany(Questao::class)
            ->as('questao')
            ->withTimestamps()
            ->withPivot('ordem')
            ->orderBy('ordem');
    }
}
