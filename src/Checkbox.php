<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Checkbox extends Input
{
    use HtmlElement;

    protected bool $checked = false;

    public function __construct()
    {
        $this->tag('input');
        $this->type('checkbox');
    }

    public function type(string $type): self
    {
        $this->type = strtolower($type);
        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        if (key_exists($this->name, $data)) {
            if (is_array($data[$this->name])) {
                $selected = $data[$this->name];
            } else {
                $selected = array_filter([$data[$this->name]]);
            }
        } else {
            $selected = [];
        }
        $this->checked = in_array($this->value, $selected);
    }

    public function validate(Validator $validator): string
    {
        return $validator->validate($this->checked ? $this->value : '');
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $input = $this->renderElement($doc);
        $input->setAttribute('type', $this->type);
        $input->setAttribute('name', $this->name);
        $input->setAttribute('value', $this->value);
        if ($this->checked) {
            $input->setAttribute('checked', 'checked');
        }
        if ($this->required) {
            $input->setAttribute('required', 'required');
        }
        return $input;
    }
}
