<?php

namespace Feadmin\Items;

class PreferenceItem
{
    private string $key;

    private string $type;

    private ?string $label = null;

    private ?string $hint = null;

    private ?string $default = null;

    private array $rules = [];

    private array $options = [];

    public static function text(string $key): static
    {
        return (new static($key))->type('text');
    }

    public static function tel(string $key): static
    {
        return (new static($key))->type('tel');
    }

    public static function number(string $key): static
    {
        return (new static($key))->type('number');
    }

    public static function textarea(string $key): static
    {
        return (new static($key))->type('textarea');
    }

    public static function image(string $key): static
    {
        return (new static($key))->type('image');
    }

    public static function richtext(string $key): static
    {
        return (new static($key))->type('richtext');
    }

    public static function select(string $key): static
    {
        return (new static($key))->type('select');
    }

    public static function checkbox(string $key): static
    {
        return (new static($key))->type('checkbox');
    }

    public static function radio(string $key): static
    {
        return (new static($key))->type('radio');
    }

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function hint(string $hint): self
    {
        $this->hint = $hint;

        return $this;
    }

    public function default(?string $default): self
    {
        $this->default = $default;

        return $this;
    }

    public function rules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function get(): array
    {
        return [
            'key' => $this->key,
            'type' => $this->type,
            'label' => $this->label,
            'hint' => $this->hint,
            'default' => $this->default,
            'rules' => $this->rules,
            'options' => $this->options,
        ];
    }
}
