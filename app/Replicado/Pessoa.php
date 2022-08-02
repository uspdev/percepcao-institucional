<?php

namespace App\Replicado;

use Uspdev\Replicado\DB;
use Uspdev\Replicado\Pessoa as PessoaReplicado;

class Pessoa extends PessoaReplicado
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

    /**
     * Recebe um codpes e retorna o nome completo (nome social)
     * Sobrescrevendo do replicado para correções. Depois de corrigir lá, pode remover daqui!!!!!!!
     * 
     * ou recebe um array de codpes e retorna uma lista chaveada dos nomes (codpes->nome)
     * 
     * @param Int|Array $codpes
     * @return String|Array
     * @author Masakik - 2/8/2022 - Corrigindo o retorno: se passado array vazio; e se não encontrado codpes
     */
    public static function obterNome($codpes)
    {
        if (is_array($codpes)) {
            $codpes = implode(',', $codpes);
            $queryWhere = "codpes IN ({$codpes})";
            $params = [];
        } else {
            $codpes = (int) $codpes; //se não for array, garante que seja int pois não pode ser usado o CONVERT()
            $queryWhere = "codpes = :codpes";
            $params['codpes'] = $codpes;
        }
        $query = "SELECT codpes, nompesttd 
            FROM PESSOA
            WHERE $queryWhere
            ORDER BY nompes";

        $result = DB::fetchAll($query, $params);

        if (!is_int($codpes)) { // se for array de codpes
            $nomes = [];
            if (!empty($result)) {
                foreach ($result as $pessoa) {
                    $nomes[$pessoa['codpes']] = $pessoa['nompesttd'];
                }
            }
        } else {
            $nomes = '';
            if (!empty($result)) { // se for apenas um codpes, retornará o nome direto em string
                $nomes = $result[0]['nompesttd'];
            }
        }
        return $nomes;
    }
}
