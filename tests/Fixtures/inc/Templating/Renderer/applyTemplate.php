<?php

$content = <<<CONTENT
class Test {
    {% if {{ test }} && {{ variable }} === 10: %}
    protected \$a = {{ variable }};
    {% endif %}
    {% if {{ test }} && {{ variable }} === 10: %}
    protected \$a = {{ variable }};
    {% else %}
    protected \$b = {{ variable }};
    {% endif %}
}
CONTENT;

$content_changed = <<<CONTENT
class Test {
    protected \$a = 10;
    protected \$a = 10;
}
CONTENT;


return [
    'templateDoesNotExistShouldThrowException' => [
        'config' => [
            'template_exists' => false,
            'variables' => [
                'test' => true,
                'variable' => 10
            ],
            'template' => 'template.php.tpl',
            'content' => $content,
        ],
        'expected' => [
            'template_path' => 'template_foldertemplate.php.tpl',
            'content' => $content
        ]
    ],
    'templateWithVariableAndConditionsShouldApplyOperations' => [
        'config' => [
            'template_exists' => true,
            'variables' => [
                'test' => true,
                'variable' => 10
            ],
            'template' => 'template.php.tpl',
            'content' => $content,
        ],
        'expected' => [
            'template_path' => 'template_foldertemplate.php.tpl',
            'content' => $content_changed
        ]
    ]
];
