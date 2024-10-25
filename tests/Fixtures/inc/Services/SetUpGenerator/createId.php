<?php
return [
    'simpleClassNameShouldReturnId' => [
        'config' => 'ClassTest',
        'expected' => 'classtest'
    ],
    'classNameWithNamespaceShouldReturnId' => [
        'config' => '\\Namespace\\ClassTest',
        'expected' => 'namespace.classtest'
    ]
];