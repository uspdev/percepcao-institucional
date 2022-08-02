<?php

namespace App\Replicado;

use Uspdev\Replicado\DB;
use Uspdev\Replicado\Pessoa;

Class PessoaReplicado extends Pessoa
{
    /*
     * Método para listar os coordenadores de curso atuais
     *
     * @param int $codcur
     * @param int $codhab
     * @return array
     * @author Gustavo Medeiros (EEL), em 18/05/2022
     */
    public static function listarCoordenadoresDeCurso(int $codcur = null, int $codhab = null)
    {
        $queryFilter = '';
        $params = [];

        if (!is_null($codcur)) {
            $queryFilter = ' AND C.codcur = convert(int, :codcur)';
            $params['codcur'] = $codcur;
        }

        if (!is_null($codhab)) {
            $queryFilter .= ' AND C.codhab = convert(int, :codhab)';
            $params['codhab'] = $codhab;
        }

        $query = "SELECT
                P.codpes, P.nompes, CGR.nomcur, CGR.codcur, C.dtafimcdn, C.codhab
            FROM
                PESSOA P
                inner join CURSOGRCOORDENADOR C on P.codpes = C.codpesdct
                inner join CURSOGR CGR on C.codcur = CGR.codcur
            WHERE
                C.dtafimcdn >= GETDATE() $queryFilter
            ORDER BY
                C.codcur";
        return DB::fetchAll($query, $params);
    }
}