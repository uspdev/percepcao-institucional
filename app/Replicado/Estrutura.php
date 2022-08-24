<?php

namespace App\Replicado;

use Uspdev\Replicado\DB;
use Uspdev\Replicado\Estrutura as EstruturaReplicado;

class Estrutura extends EstruturaReplicado
{
    /**
     * Método que recebe o Código da Unidade e retorna todos os setores ativos da mesma.
     * Caso não seja passado a unidade, pega o REPLICADO_CODUNDCLG do .env
     * Copiado do replicado pois precisava de ajustes
     *
     * @param String $codundclg - código da Unidade ou lista separada por vírgula
     * @return array
     * @author Fernando G. Moura <fgm@sc.sp.br>
     */
    public static function listarSetores($codundclg = null)
    {
        if ($codundclg === null) {
            $codundclg = getenv('REPLICADO_CODUNDCLG');
        }
        $query = "SELECT codset, tipset, nomabvset, nomset, codsetspe  
            FROM SETOR
            WHERE codund IN ($codundclg) 
                AND dtadtvset IS NULL 
                AND nomset NOT LIKE 'Inativo'
            ORDER BY codset ASC";

        return DB::fetchAll($query);
    }
}
