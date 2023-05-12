<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Percepcao;
use App\Replicado\Pessoa;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('relatorios', function (User $user) {
            return $user;
        });

        Gate::define('membrosEspeciais', function(User $user, Percepcao $percepcao) {
            return $percepcao->liberaConsultaMembrosEspeciais;
        });

        Gate::define('chefes', function(User $user, Percepcao $percepcao) {
            return $percepcao->liberaConsultaChefes;
        });

        Gate::define('docentes', function(User $user, Percepcao $percepcao) {
            return $percepcao->liberaConsultaDocente;
        });

        Gate::define('alunos', function(User $user, Percepcao $percepcao) {
            return $percepcao->liberaConsultaAluno;
        });

        Gate::define('verifica-docente', function(User $user) {
            $pessoa = Pessoa::vinculos($user->codpes);
            $verificaDocente = preg_grep('/^Docente\s.*/', $pessoa);

            if (!empty($verificaDocente)) {
                return true;
            }

            return false;
        });

        Gate::define('verifica-aluno', function(User $user) {
            $pessoa = Pessoa::vinculos($user->codpes);
            $verificaAluno = preg_grep('/^Aluno de Graduação\s.*/', $pessoa);

            if (!empty($verificaAluno)) {
                return true;
            }

            return false;
        });

        Gate::define('verifica-membro-especial', function(User $user) {
            $pessoa = collect(Pessoa::listarDesignados(2))->whereIn('codpes', [$user->codpes])->whereIn('nomfnc', ['Diretor Uni Ensino', 'Vice Dir Un Ens', 'Ch Depart Ensino', 'Pres Comiss Grad', 'Pres Comiss Ceu', 'Pres Comiss Pesq', 'Pres Comiss In Per', 'Coord Cursos Grad']);

            if ($pessoa->isNotEmpty()) {
                return true;
            }

            return false;
        });
    }
}
