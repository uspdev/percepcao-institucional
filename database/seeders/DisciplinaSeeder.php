<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disciplina;
use App\Models\Percepcao;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $percepcaos = Percepcao::get();

        foreach ($percepcaos as $percepcao) {
            Disciplina::importarDoReplicado($percepcao);
        }
    }
}
