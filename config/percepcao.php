<?php

return [
    'disciplinas_fake' => [
        0 => [
            'codpes' => 'Nelson Aoki',
            'coddis' => 'DPT0001',
            'nomdis' => 'Interação Solo-Estrutura',
            'verdis' => '1',
            'codtur' => date('Y') . '1A1',
            'tiptur' => 'Teórica',
        ],
        1 => [
            'codpes' => 'Docente Fulano de Tal 2',
            'coddis' => 'DPT0002',
            'nomdis' => 'Disciplina Tal 2',
            'verdis' => '2',
            'codtur' => date('Y') . '1A2',
            'tiptur' => 'Teórica',
        ]
    ],

    'coordenadores_fake' => [
        0 => [
            'codpes' => 'Coordenador Fulano de Tal 1',
            'nompes' => 'Coordenador Fulano de Tal 1',
            'codcur' => env('REPLICADO_CODUNDCLG') . '001',
            'nomcur' => 'ENGENHARIA DA EEL',
            'codhab' => '1',
        ],
        1 => [
            'codpes' => '000000',
            'nompes' => 'Armando Toshio Natsumi',
            'codcur' => env('REPLICADO_CODUNDCLG') . '002',
            'nomcur' => 'ENGENHARIA DA EESC',
            'codhab' => '2',
        ]
    ],
];
