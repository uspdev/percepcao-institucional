<?php

$admin = [
    [
        'text' => 'Percepções',
        'url' => 'gestao-sistema/percepcao',
        'can' => 'gerente',
    ],
    [
        'text' => 'Grupos',
        'url' => 'gestao-sistema/percepcao/create-grupo',
        'can' => 'gerente',
    ],
    [
        'text' => 'Questões',
        'url' => 'gestao-sistema/percepcao/create-questao',
        'can' => 'gerente',
    ],
];

$submenu2 = [
    [
        'text' => 'Avaliar',
        'url' => 'avaliar',
    ],
];

$consultas = [
    [
        'text' => 'Disciplinas',
        'url' => 'gestao-sistema/percepcao/consulta/disciplinas',
        'can' => 'gerente',
    ],
    [
        'text' => 'Coordenadores',
        'url' => 'gestao-sistema/percepcao/consulta/coordenadores',
        'can' => 'gerente',
    ],
];

$menu = [
    // [
    //     'text' => '<i class="fas fa-home"></i> Home',
    //     'url' => '/',
    // ],
    [
        # este item de menu será substituido no momento da renderização
        'key' => 'menu_dinamico',
    ],
    [
        'text' => 'Percepção Institucional',
        'submenu' => $submenu2,
        'can' => '',
    ],
    [
        'text' => 'Consultas',
        'submenu' => $consultas,
        'can' => 'gerente',
    ],
    [
        'text' => 'Gestão do sistema',
        'submenu' => $admin,
        'can' => 'gerente',
    ],
];

$right_menu = [
    [
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
];


return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title' => config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação
    'skin' => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key' => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url' => config('app.url'),

    # login e logout
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',

    # menus
    'menu' => $menu,
    'right_menu' => $right_menu,
];
