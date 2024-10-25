    {% if {{ has_type }} && ! in_array('{{ type }}', ['string', 'int', 'float', 'bool'] ): %}
        $this->{{ name }} = Mockery::mock({{ type }}::class);
    {% endif %}
    {% if ! {{ has_type }}: %}
        $this->{{ name }} = null;
    {% endif %}
    {% if {{ has_type }} && '{{ type }}' === 'string': %}
        $this->{{ name }} = '';
    {% endif %}
    {% if {{ has_type }} && in_array('{{ type }}', ['int', 'float',] ): %}
        $this->{{ name }} = 0;
    {% endif %}
    {% if {{ has_type }} && '{{ type }}' === 'bool': %}
        $this->{{ name }} = false;
    {% endif %}