<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class TextArea extends FormInput
{
    use HtmlElement;

    public function __construct()
    {
        $this->tag('textarea');
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

    public function rows(int $rows): self
    {
        $this->rows = $rows;
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
     * @param array<string, string|string[]> $data
     */
    public function fill(array $data): void
    {
        $values = $data[$this->name] ?? [];
        if (!is_array($values)) {
            $values = [$values];
        }
        $this->value = trim($values[0] ?? '');
    }

    public function validate(Validator $validator): string
    {
        return $validator->validate($this->value);
    }

    public function setError(string $message): void {}

    public function render(\DOMDocument $doc): \DOMElement
    {
        $textarea = $this->renderElement($doc);
        $textarea->setAttribute('type', $this->type);
        $textarea->setAttribute('name', $this->name);
        $textarea->textContent = $this->value;
        return $textarea;
    }
}
