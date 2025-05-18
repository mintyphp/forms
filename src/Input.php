<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Input implements FormControl
{
    use HtmlElement;

    protected string $name = '';
    protected string $value = '';
    protected string $type = 'text';
    protected string $placeholder = '';

    public function __construct()
    {
        $this->tag('input');
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

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        if (!$this->name) {
            return;
        }
        $values = $data[$this->name] ?? [];
        if (!is_array($values)) {
            $values = [$values];
        }
        $this->value = trim($values[0] ?? '');
    }

    /**
     * @return array<string, string|string[]|null>
     */
    public function extract(): array
    {
        if (!$this->name) {
            return [];
        }
        $value = trim($this->value);
        return [$this->name => strlen($value) ? $value : null];
    }

    public function validate(Validator $validator): string
    {
        return $validator->validate($this->value);
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $input = $this->renderElement($doc);
        $input->setAttribute('type', $this->type);
        if ($this->name) {
            $input->setAttribute('name', $this->name);
        }
        $input->setAttribute('value', $this->value);
        if ($this->placeholder) {
            $input->setAttribute('placeholder', $this->placeholder);
        }
        return $input;
    }
}
