<?php

return [
    'vfs_dir' => '/',
    'structure' => [
        'configs' => [
            'providers.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/configs/providers.php'),
        ],
        'inc' => [
            'Plugin.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
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
            ]
        ]
    ],
    'test_data' => [
        'providerShouldCreateTheFileAndAddItToPlugin' => [
            'config' => [
                'parameters' => '',
                'class' => 'PSR2Plugin/Engine/Test/MyProvider',
                'plugin_path' => '/inc/Plugin.php'
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MyProvider.php',
                'content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/plugin.php'),
            ]
        ],
        'providerShouldCreateTheFileAndAddItToConfigs' => [
            'config' => [
                'parameters' => '',
                'class' => 'PSR2Plugin/Engine/Test/MyProvider',
                'plugin_path' => '/configs/providers.php'
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MyProvider.php',
                'content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/configs/providers.php'),
            ]
        ],
        'providerWithParamShouldCreateTheFileAndAddItToConfigs' => [
            'config' => [
                'custom_composer' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer_autoresolver.json'),
                'parameters' => ' --type autoresolver',
                'class' => 'PSR2Plugin/Engine/Test/MyProvider',
                'plugin_path' => '/configs/providers.php'
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MyProvider.php',
                'content' => file_get_contents(__DIR__ . '/files/autoresolver_provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/configs/providers.php'),
            ]
        ],
        'providerWithShortParamShouldCreateTheFileAndAddItToConfigs' => [
            'config' => [
                'custom_composer' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer_autoresolver.json'),
                'parameters' => ' -t a',
                'class' => 'PSR2Plugin/Engine/Test/MyProvider',
                'plugin_path' => '/configs/providers.php'
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MyProvider.php',
                'content' => file_get_contents(__DIR__ . '/files/autoresolver_provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/configs/providers.php'),
            ]
        ],
        'StaussComposerAndProviderWithShortParamShouldCreateTheFileAndAddItToConfigs' => [
            'config' => [
                'custom_composer' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/strauss_composer_autoresolver.json'),
                'parameters' => ' -t a',
                'class' => 'PSR2Plugin/Engine/Test/MyProvider',
                'plugin_path' => '/configs/providers.php'
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MyProvider.php',
                'content' => file_get_contents(__DIR__ . '/files/autoresolver_provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/configs/providers.php'),
            ]
        ]
    ]
];
