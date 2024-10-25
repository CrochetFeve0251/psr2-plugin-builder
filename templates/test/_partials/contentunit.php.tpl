    {% if {{ has_return }} : %}
        $this->assertSame($expected, $this->{{ class }}->{{ method }}({{ parameters }}));
    {% else %}
        $this->{{ class }}->{{ method }}({{ parameters }});
    {% endif %}