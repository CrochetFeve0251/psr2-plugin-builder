{% if {{ is_action }} && {{ has_return }} : %}
        $this->assertSame($expected, do_action('{{ event }}'{{ parameters }}));
{% endif %}
{% if {{ is_action }} && ! {{ has_return }} : %}
        do_action('{{ event }}'{{ parameters }});
{% endif %}
{% if ! {{ is_action }} && {{ has_return }} : %}
        $this->assertSame($expected, apply_filters('{{ event }}'{{ parameters }}));
{% endif %}
{% if ! {{ is_action }} && ! {{ has_return }} : %}
        apply_filters('{{ event }}'{{ parameters }});
{% endif %}
