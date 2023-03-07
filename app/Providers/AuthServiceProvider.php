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
    }
}
