<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function percepcaos()
    {
        return $this->belongsToMany(Percepcao::class);
    }
}
