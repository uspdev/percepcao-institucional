<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GrupoSeeder::class,
            QuestaoSeeder::class,
            PercepcaoSeeder::class,
            DisciplinaSeeder::class,
            RespostaSeeder::class,
        ]);
    }
}
