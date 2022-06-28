<?php

namespace App\Replicado;

use Uspdev\Replicado\DB;
use Uspdev\Replicado\Graduacao as GraduacaoReplicado;

class Graduacao extends GraduacaoReplicado
{

    /**
     * A ideia aqui é primeiro listar as disciplinas do histórico dos alunos
     * e depois agrupar as disciplinas por aluno
     * 
     * @param $anoSemestre - ex. 20221, 20222
     */
    public static function listarAlunos($anoSemestre)
    {
        $codundclg = getenv('REPLICADO_CODUNDCLG');
        $query = "SELECT DISTINCT --M.codpes as ministrante, -- dados professor
            H.codpes, P.nompes, C.nomcur, V.dtainivin, U.sglund, --dados aluno
            H.coddis, H.codtur, D.nomdis --, O.diasmnocp -- dados disciplina
            FROM HISTESCOLARGR H
                INNER JOIN VINCULOPESSOAUSP V -- pega o ano de ingresso (desnecessário talvez)
                    ON (H.codpes = V.codpes) --AND V.codclg IN ($codundclg)
                INNER JOIN UNIDADE U on U.codund = V.codfusclgund -- pega a sigla da unidade
                INNER JOIN CURSOGR C -- pega nome do curso
                    ON (V.codcurgrd = C.codcur) 
                INNER JOIN PESSOA P on P.codpes = H.codpes
                INNER JOIN DISCIPLINAGR D on D.coddis = H.coddis and D.verdis = H.verdis
                INNER JOIN TURMAGR T 
                    ON T.coddis = H.coddis AND H.verdis = T.verdis AND H.codtur = T.codtur
                INNER JOIN OCUPTURMA O -- pega somente as turmas que ocupam espaço físico. Remover para pegar tcc e estagio nao ocupam espaço na EESC
                    ON H.coddis = O.coddis AND T.verdis = O.verdis AND H.codtur = O.codtur
                -- INNER JOIN MINISTRANTE M ON M.coddis = H.coddis AND M.codtur = H.codtur AND M.verdis = H.verdis
            WHERE H.codtur LIKE :anoSemestre AND
                H.stamtr ='M'
            ORDER BY H.codpes ASC, D.nomdis ASC ";

        $params = ['anoSemestre' => $anoSemestre . '%'];

        $disciplinas = DB::fetchAll($query, $params);

        // var_dump(array_slice($disciplinas,0,10));exit;

        $alunos = [];
        for ($i = 0; $i < count($disciplinas); $i++) {
            $aluno = [
                'codpes' => $disciplinas[$i]['codpes'],
                'nompes' => $disciplinas[$i]['nompes'],
                'nomcur' => $disciplinas[$i]['nomcur'],
                'dtainivin' => $disciplinas[$i]['dtainivin'],
                'sglund' => $disciplinas[$i]['sglund'],
            ];

            // agrupando as disciplinas de cada aluno
            do {
                $aluno['disciplinas'][] = [
                    'coddis' => $disciplinas[$i]['coddis'],
                    'codtur' => $disciplinas[$i]['codtur'],
                    'nomdis' => $disciplinas[$i]['nomdis'],
                ];
                if (isset($disciplinas[$i + 1]) && ($disciplinas[$i]['codpes'] == $disciplinas[$i + 1]['codpes'])) {
                    $i++;
                    $proximaDisciplina = true;
                } else {
                    $proximaDisciplina = false;
                }
            } while ($proximaDisciplina);

            $alunos[] = $aluno;
        }

        // ordenando por ano desc e depois por nome asc
        usort($alunos, function ($a, $b) {
            $cmpA = \Carbon\Carbon::Create($a['dtainivin'])->format('Y');
            $cmpB = \Carbon\Carbon::Create($b['dtainivin'])->format('Y');
            $order = -1; //desc
            if ($cmpA > $cmpB) {
                return $order;
            } elseif ($cmpA < $cmpB) {
                return -$order;
            }

            $cmpA = $a['nompes'];
            $cmpB = $b['nompes'];
            $order = 1; //-1: desc, 1: asc
            if ($cmpA > $cmpB) {
                return $order;
            } elseif ($cmpA < $cmpB) {
                return -$order;
            }

            return 1;
            
        });
        return $alunos;
    }

    /**
     * Retorna as disciplinas da Unidade
     * Query usada na EEL no sistema antigo
     * 
     * @param $anoSemestre - ex 20221, 20222, etc
     */
    public static function listarDisciplinasUnidade($anoSemestre)
    {
        $query = "SELECT D.coddis, D.nomdis, T.codtur, D.verdis, T.tiptur, P.nompes, P.codpes
            FROM ALUNOGR A
                INNER JOIN PROGRAMAGR PR ON A.codpes=PR.codpes
                INNER JOIN HISTESCOLARGR H ON PR.codpes=H.codpes AND PR.codpgm=H.codpgm
                INNER JOIN TURMAGR T ON H.coddis=T.coddis AND H.verdis=T.verdis AND H.codtur=T.codtur
                INNER JOIN DISCIPLINAGR D ON T.coddis=D.coddis AND T.verdis=D.verdis
                INNER JOIN MINISTRANTE M ON D.coddis=M.coddis AND D.verdis=M.verdis AND T.codtur=M.codtur
                LEFT JOIN PESSOA P ON M.codpes = P.codpes
            WHERE H.stamtr = 'M' AND T.codtur like :anoSemestre
            GROUP BY D.coddis, D.nomdis, T.codtur, D.verdis, T.tiptur, P.nompes, P.codpes
            ORDER BY D.coddis, P.nompes;";

        $params = [
            'anoSemestre' => $anoSemestre . '%',
        ];

        return DB::fetchAll($query, $params);
    }
}
