<?php

return [
    'vfs_dir' => '/',
    'structure' => [
        'inc' => [
            'Plugin.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            'Engine' => [
                'Test' => [
                    'ServiceProvider.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/provider.php'),
                ]
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
        'subscriberWithProviderShouldBeAddedToProvider' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => '',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberWithoutProviderShouldCreateAndBeAddedToProvider' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => false,
                'parameters' => '',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/plugin.php'),
            ]
        ],
        'subscriberCommonShouldBeAddedAsCommon' => [
           'config' => [
               'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
               'plugin_path' => '/inc/Plugin.php',
               'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
               'provider_exists' => true,
               'parameters' => ' --type common',
           ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberResolverShouldBeAdded' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'composer_path' => 'composer.json',
                'composer_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer_autoresolver.json'),
                'provider_exists' => false,
                'parameters' => ' --provider autoresolver',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/autoresolver.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/plugin.php'),
            ]
        ],
        'subscriberShortResolverShouldBeAdded' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'composer_path' => 'composer.json',
                'composer_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer_autoresolver.json'),
                'provider_exists' => false,
                'parameters' => ' -p a',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/autoresolver.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/plugin.php'),
            ]
        ],
        'subscriberCommonShortParamShouldBeAddedAsCommon' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' -t c',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberFrontShouldBeAddedAsFront' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' --type front',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/front_provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberFrontShortParamShouldBeAddedAsFront' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' -t f',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/front_provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberAdminShouldBeAddedAsAdmin' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' --type admin',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/admin_provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberAdminShortParamShouldBeAddedAsAdmin' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' -t a',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/admin_provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
        'subscriberNoNamespaceShouldHaveDefaultOne' => [
            'config' => [
                'class' => 'MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => '',
            ],
            'expected' => [
                'path' => '/inc/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/root_subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/root_provider.php'),
                'plugin_content' => file_get_contents(__DIR__ . '/files/root_plugin.php'),
            ]
        ],
        'subscriberCommonWithWeirdProviderShouldBeAddedAsCommonByNotBinded' => [
            'config' => [
                'class' => 'PSR2Plugin/Engine/Test/MySubscriber',
                'plugin_path' => '/inc/Plugin.php',
                'provider_path' => '/inc/Engine/Test/ServiceProvider.php',
                'provider_exists' => true,
                'parameters' => ' --type common',
            ],
            'expected' => [
                'path' => '/inc/Engine/Test/MySubscriber.php',
                'content' => file_get_contents(__DIR__ . '/files/subscriber.php'),
                'provider_content' => file_get_contents(__DIR__ . '/files/provider.php'),
                'plugin_content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            ]
        ],
    ]
];
