<?php

namespace {{ namespace }};

use {{ base_namespace }}Tests\Integration\TestCase;

/**
 * @covers {{ base_class }}::{{ base_method }}
 {% if {{ has_group }} : %}
 * @group {{ group }}
 {% endif %}
 {% if {{ has_external }} : %}
 * @group {{ external }}
 {% endif %}
 */
class Test_{{ class_name }} extends TestCase {

    /**
     * @dataProvider configTestData
     */
    {% if {{ has_return }} : %}
    public function testShouldReturnAsExpected( $config, $expected )
    {% else %}
    public function testShouldDoAsExpected( $config )
    {% endif %}
    {
{{ content }}
    }
}
