<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Coordenador;
use App\Models\Disciplina;
use App\Models\Percepcao;
use App\Models\Resposta;
use App\Models\User;
use App\Replicado\Pessoa;
use Spatie\Permission\Models\Permission;

class RespostaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userEnv = explode(',', env('SENHAUNICA_ADMINS'));

        if (!empty($userEnv[0])) {
            $nomeUsuario = Pessoa::obterNome($userEnv[0]);

            if (!empty($nomeUsuario)) {
                Permission::findOrCreate('admin');

                $emailUsuario = Pessoa::email($userEnv[0]);

                $user = User::firstOrCreate([
                    'name' => $nomeUsuario,
                    'email' => $emailUsuario,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'codpes' => $userEnv[0],
                ]);

                $user->givePermissionTo('admin');
            } else {
                $this->command->comment('Nenhuma pessoa encontrada com esse número USP. Não é possível seguir com o seeder Resposta.');
                return '';
            }
        } else {
            $this->command->comment('Nenhum usuário admin encontrado nas configurações. Não é possível seguir com o seeder Resposta.');
            return '';
        }

        $percepcaos = Percepcao::get();

        $qtdRespostas = 10;

        foreach ($percepcaos as $percepcao) {
            $this->command->comment('for na percepção');
            if ($percepcao->questaos()->has('grupos')) {
                foreach ($percepcao->questaos()->get('grupos') as $idGrupo => $grupo) {
                    if (isset($grupo['repeticao']) && $grupo['repeticao']) {
                        switch ($grupo['modelo_repeticao']) {
                            case 'disciplinas':
                                $disciplinas = Disciplina::get();
                                foreach ($disciplinas as $disciplina) {
                                    $this->command->comment('Criando respostas para a disciplina -> ' . $disciplina->nomdis);
                                    if (isset($grupo['questoes']) && !empty($grupo['questoes'])) {
                                        foreach ($grupo['questoes'] as $idQuestao => $questao) {
                                            for ($a = 0; $a < $qtdRespostas; $a++) {
                                                $resposta = $questao['campo']['type'] === 'radio'
                                                    ? Arr::random(array_column($questao['campo']['options'], 'key'))
                                                    : Str::random(50);
                                                $createdResposta = Resposta::create([
                                                    'percepcao_id' => $percepcao->id,
                                                    'grupo_id' => $idGrupo,
                                                    'questao_id' => $idQuestao,
                                                    'disciplina_id' => $disciplina->id,
                                                    'user_id' => $user->id,
                                                    'codpes' => $user->codpes,
                                                    'resposta' => $resposta,
                                                ]);
                                            }
                                        }
                                    }

                                    if (isset($grupo['grupos']) && !empty($grupo['grupos'])) {
                                        foreach ($grupo['grupos'] as $idSubGrupo => $subGrupo) {
                                            if (isset($subGrupo['questoes']) && !empty($subGrupo['questoes'])) {
                                                foreach ($subGrupo['questoes'] as $idQuestao => $questao) {
                                                    for ($a = 0; $a < $qtdRespostas; $a++) {
                                                        $resposta = $questao['campo']['type'] === 'radio'
                                                            ? Arr::random(array_column($questao['campo']['options'], 'key'))
                                                            : Str::random(50);

                                                        $createdResposta = Resposta::create([
                                                            'percepcao_id' => $percepcao->id,
                                                            'grupo_id' => $idSubGrupo,
                                                            'questao_id' => $idQuestao,
                                                            'disciplina_id' => $disciplina->id,
                                                            'user_id' => $user->id,
                                                            'codpes' => $user->codpes,
                                                            'resposta' => $resposta,
                                                        ]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                                case 'coordenadores':
                                    $coordenadores = Coordenador::get();
                                    foreach ($coordenadores as $coordenador) {
                                        $this->command->comment('Criando respostas para o coordenador -> ' . $coordenador->nompes);
                                        if (isset($grupo['questoes']) && !empty($grupo['questoes'])) {
                                            foreach ($grupo['questoes'] as $idQuestao => $questao) {
                                                for ($a = 0; $a < $qtdRespostas; $a++) {
                                                    $resposta = $questao['campo']['type'] === 'radio'
                                                        ? Arr::random(array_column($questao['campo']['options'], 'key'))
                                                        : Str::random(50);
                                                    $createdResposta = Resposta::create([
                                                        'percepcao_id' => $percepcao->id,
                                                        'grupo_id' => $idGrupo,
                                                        'questao_id' => $idQuestao,
                                                        'coordenador_id' => $coordenador->id,
                                                        'user_id' => $user->id,
                                                        'codpes' => $user->codpes,
                                                        'resposta' => $resposta,
                                                    ]);
                                                }
                                            }
                                        }

                                        if (isset($grupo['grupos']) && !empty($grupo['grupos'])) {
                                            foreach ($grupo['grupos'] as $idSubGrupo => $subGrupo) {
                                                if (isset($subGrupo['questoes']) && !empty($subGrupo['questoes'])) {
                                                    foreach ($subGrupo['questoes'] as $idQuestao => $questao) {
                                                        for ($a = 0; $a < $qtdRespostas; $a++) {
                                                            $resposta = $questao['campo']['type'] === 'radio'
                                                                ? Arr::random(array_column($questao['campo']['options'], 'key'))
                                                                : Str::random(50);

                                                            $createdResposta = Resposta::create([
                                                                'percepcao_id' => $percepcao->id,
                                                                'grupo_id' => $idSubGrupo,
                                                                'questao_id' => $idQuestao,
                                                                'coordenador_id' => $coordenador->id,
                                                                'user_id' => $user->id,
                                                                'codpes' => $user->codpes,
                                                                'resposta' => $resposta,
                                                            ]);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    break;
                        }
                    }
                }
            }
        }
    }
}
