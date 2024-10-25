    '{{ scenario }}' => [
        'config' => [
{{ values }}
        ],
        {% if {{ has_expected }} : %}
        'expected' => [

        ]
        {% endif %}
    ],
