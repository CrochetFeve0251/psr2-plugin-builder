<?php

return [
    'vfs_dir' => '/',
    'structure' => [
        'inc' => [
            'Engine' => [

            ]
        ],
        'composer.json' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer.php'),
        'tests' => [
            'Fixtures' => [
                'classes' => [

                ]
            ],
            'Integration' => [

            ],
            'Unit' => [
                'inc' => [

                ],
                'bootstrap.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/unit/bootstrap.php'),
            ]
        ]
    ],
    'test_data' => [
        'fixtureShouldCreateTheFileAndAddItToBootstrap' => [
            'config' => [
                'class' => 'MyFixture',
                'bootstrap_path' => '/tests/Unit/bootstrap.php'
            ],
            'expected' => [
                'path' => '/tests/Fixtures/classes/MyFixture.php',
                'content' => file_get_contents(__DIR__ . '/files/fixture.php'),
                'boostrap_content' => file_get_contents(__DIR__ . '/files/bootstrap.php'),
            ]
        ]
    ]
];
