<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'inc' => [
            'Plugin.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/plugin.php'),
            'Test' => [
                'MyClass.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/my_class.php'),
            ]
        ],
        'composer.json' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer.php'),
        'tests' => [
            'Fixtures' => [
                'classes' => [

                ]
            ],
            'Integration' => [
                'bootstrap.php' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/integration/bootstrap.php'),
            ],
            'Unit' => [
                'inc' => [

                ],
            ]
        ]
    ],
    'test_data' => [
        'onMethodShouldCreateTestOnlyForThatMethod' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass::my_method',
                'parameters' => '',
                'methods' => [
                        'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                            'exists' => false,
                            'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                        ],
                        'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                            'exists' => false,
                            'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                        ],
                        'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                            'exists' => false,
                            'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                        ]
                ]
            ],
            'expected' => [
                'methods' => [
                        'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                            'exists' => true,
                            'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                        ],
                        'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                            'exists' => true,
                            'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                        ],
                        'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                            'exists' => true,
                            'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                        ],
                    'composer.json' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer.php'),
                    ]
                ]
            ]
        ],
        'onClassShouldCreateForAllPublicMethods' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => '',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithBothParamShouldCreateBothTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --type both',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithBothShortParamShouldCreateBothTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -t b',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithUnitParamShouldCreateUnitTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --type unit',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ]
        ],
        'onClassWithUnitShortParamShouldCreateUnitTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -t u',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ]
        ],
        'onClassWithIntegrationParamShouldCreateIntegrationTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --type integration',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithIntegrationShortParamShouldCreateIntegrationTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -t i',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithGroupParamShouldAddGroup' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --group MyGroup',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_group.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_group.php')
                    ],
                ]
            ]
        ],
        'onClassWithGroupShortParamShouldAddGroup' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -g MyGroup',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_group.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_group.php')
                    ],
                ]
            ]
        ],
        'onClassWithExpectedPresentParamShouldAddExpected' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --expected present',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method_expected.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_expected.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_expected.php')
                    ],
                ]
            ]
        ],
        'onClassWithExpectedPresentShortParamShouldAddExpected' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -e p',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method_expected.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_expected.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_expected.php')
                    ],
                ]
            ]
        ],
        'onClassWithExpectedAbsentParamShouldNotAddExpected' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --expected absent',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default_absent.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_absent.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_absent.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithExpectedAbsentShortParamShouldNotAddExpected' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -e a',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default_absent.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_absent.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_absent.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithAddScenariosShortParamShouldAddScenarios' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --scenarios Scenario1,Scenario2,Scenario3',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default_scenarios.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method_scenarios.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithAddScenariosParamShouldAddScenarios' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -s Scenario1,Scenario2,Scenario3',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default_scenarios.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method_scenarios.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onClassWithExternalRunParamShouldCreateExternalRun' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' --external MyGroup',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/bootstrap.php' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/integration/bootstrap.php')
                    ],
                    'composer.json' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_BUILDER_TESTS_FIXTURES_DIR . '/files/composer.php')
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_group.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_group.php')
                    ],
                    'tests/Integration/bootstrap.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/bootstrap.php')
                    ],
                    'composer.json' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/composer.json')
                    ],
                ]
            ]
        ],
        'onClassWithExternalRunShortParamShouldCreateExternalRun' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => ' -x MyGroup',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default_group.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_group.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method_group.php')
                    ],
                    'tests/Integration/bootstrap.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/bootstrap.php')
                    ],
                    'composer.json' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/composer.json')
                    ],
                ]
            ]
        ],
        'onAbstractClassShouldGenerateTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => '',
                'my_class_content' => file_get_contents(__DIR__ . '/files/my_abstract_class.php'),
                'my_class_path' => 'inc/Test/MyClass.php',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_mock.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_mock.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onTraitShouldGenerateTests' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => '',
                'my_class_content' => file_get_contents(__DIR__ . '/files/my_abstract_class.php'),
                'my_class_path' => 'inc/Test/MyClass.php',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_mock.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_mock.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
        'onNoNeedToMockDontImportMockery' => [
            'config' => [
                'class' => 'PSR2Plugin/Test/MyClass',
                'parameters' => '',
                'my_class_content' => file_get_contents(__DIR__ . '/files/my_class_without_params.php'),
                'my_class_path' => 'inc/Test/MyClass.php',
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'methods' => [
                    'tests/Fixtures/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/default.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/default_without_mockery.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/myMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/default.php')
                    ],
                    'tests/Fixtures/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Unit/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Integration/inc/Test/MyClass/myProtectedMethod.php' => [
                        'exists' => false,
                    ],
                    'tests/Fixtures/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/fixtures/second_method.php')
                    ],
                    'tests/Unit/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/unit/second_method_without_mockery.php')
                    ],
                    'tests/Integration/inc/Test/MyClass/mySecondMethod.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/integration/second_method.php')
                    ],
                ]
            ]
        ],
    ]
];
