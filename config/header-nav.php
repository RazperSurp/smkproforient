<?php
return [
    'header-nav' => [
        'schools' => [
            'title' => 'Администрирование',
            'children' => [
                'index' => [
                    'title'=> 'Образовательные учреждения'
                ]
            ]
        ], 'manager' => [
            'title' => 'Планировщик',
            'children' => [
                'index' => [
                    'show' => false,
                    'redirect' => '/manager/events'
                ], 'events' => [
                    'title'=> 'События'
                ], 'mission' => [
                    'title'=> 'Командировки'
                ], 'crm' => [
                    'title'=> 'Задачи'
                ]
            ]
        ], 'reports' => [
            'title' => 'Отчёты',
            'children' => [
                'index' => [
                    'title'=> 'Конструктор'
                ]
            ]
        ]
    ]
];
?>