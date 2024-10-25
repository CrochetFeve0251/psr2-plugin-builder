{{ properties }}
    /**
     * @var {{ main_class_type }}
     */
    protected ${{ main_class_name }};

    public function set_up() {
        parent::set_up();
{{ properties_initialisation }}
        {% if {{ is_trait }} || {{ is_abstract }} : %}
        $this->{{ main_class_name }} = Mockery::mock({{ main_class_type }}::class, [{{ init_params }}])->makePartial();
        {% else %}
        $this->{{ main_class_name }} = new {{ main_class_type }}({{ init_params }});
        {% endif %}
    }
