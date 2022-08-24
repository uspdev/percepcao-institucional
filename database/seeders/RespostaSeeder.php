<?php

namespace Database\Seeders;

use App\Models\Coordenador;
use App\Models\Disciplina;
use App\Models\Percepcao;
use App\Models\Resposta;
use App\Models\User;
use App\Replicado\Pessoa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RespostaSeeder extends Seeder
{

    protected $qtdRespostas = 10;

    # Porcentagem de disciplinas que terão respostas
    protected $porcentagemDisciplinas = 30;

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

        foreach ($percepcaos as $percepcao) {
            $this->command->comment('for na percepção');
            if ($percepcao->questaos()->has('grupos')) {
                foreach ($percepcao->questaos()->get('grupos') as $idGrupo => $grupo) {
                    if (isset($grupo['repeticao']) && $grupo['repeticao']) {
                        switch ($grupo['modelo_repeticao']) {
                            case 'disciplinas':
                                $disciplinas = Disciplina::get();
                                foreach ($disciplinas as $disciplina) {
                                    // vamos sortear algumas disciplinas para ter respostas
                                    if (rand(0, 100) < $this->porcentagemDisciplinas) {
                                        $this->command->comment('Criando respostas para a disciplina -> ' . $disciplina->nomdis);
                                        if (isset($grupo['questoes']) && !empty($grupo['questoes'])) {
                                            foreach ($grupo['questoes'] as $idQuestao => $questao) {
                                                $this->criarRespostaQuestaoDisciplina($questao, $idQuestao, $percepcao->id, $idGrupo, $disciplina->id, $user);
                                            }
                                        }

                                        if (isset($grupo['grupos']) && !empty($grupo['grupos'])) {
                                            foreach ($grupo['grupos'] as $idSubGrupo => $subGrupo) {
                                                if (isset($subGrupo['questoes']) && !empty($subGrupo['questoes'])) {
                                                    foreach ($subGrupo['questoes'] as $idQuestao => $questao) {
                                                        $this->criarRespostaQuestaoDisciplina($questao, $idQuestao, $percepcao->id, $idGrupo, $disciplina->id, $user);
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
                                            $this->criarRespostaQuestaoCoordenador($questao, $idQuestao, $percepcao->id, $idGrupo, $coordenador->id, $user);
                                        }
                                    }

                                    if (isset($grupo['grupos']) && !empty($grupo['grupos'])) {
                                        foreach ($grupo['grupos'] as $idSubGrupo => $subGrupo) {
                                            if (isset($subGrupo['questoes']) && !empty($subGrupo['questoes'])) {
                                                foreach ($subGrupo['questoes'] as $idQuestao => $questao) {
                                                    $this->criarRespostaQuestaoCoordenador($questao, $idQuestao, $percepcao->id, $idGrupo, $coordenador->id, $user);
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

    public function criarRespostaQuestaoDisciplina($questao, $idQuestao, $idPercepcao, $idGrupo, $idDisciplina, $user)
    {
        for ($a = 0; $a < $this->qtdRespostas; $a++) {
            $resposta = $questao['campo']['type'] === 'radio'
            ? Arr::random(array_column($questao['campo']['options'], 'key'))
            : Str::random(50);
            $createdResposta = Resposta::create([
                'percepcao_id' => $idPercepcao,
                'grupo_id' => $idGrupo,
                'questao_id' => $idQuestao,
                'disciplina_id' => $idDisciplina,
                'user_id' => $user->id,
                'codpes' => $user->codpes,
                'resposta' => $resposta,
            ]);
        }
    }

    public function criarRespostaQuestaoCoordenador($questao, $idQuestao, $idPercepcao, $idGrupo, $idCoordenador, $user)
    {
        for ($a = 0; $a < $this->qtdRespostas; $a++) {
            $resposta = $questao['campo']['type'] === 'radio'
            ? Arr::random(array_column($questao['campo']['options'], 'key'))
            : Str::random(50);
            $createdResposta = Resposta::create([
                'percepcao_id' => $idPercepcao,
                'grupo_id' => $idGrupo,
                'questao_id' => $idQuestao,
                'coordenador_id' => $idCoordenador,
                'user_id' => $user->id,
                'codpes' => $user->codpes,
                'resposta' => $resposta,
            ]);
        }
    }

}
