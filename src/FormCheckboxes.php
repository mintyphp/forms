<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class FormCheckboxes implements FormControl
{
    use HtmlElement;

    protected string $name = '';
    /** @var array<string,string> $options */
    protected array $options = [];
    /** @var array<string,bool> $checked */
    protected array $checked = [];

    public function __construct()
    {
        $this->tag('input');
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

    /**
     * @param array<string,string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
        foreach ($options as $key => $value) {
            $this->checked[$key] = false;
        }
        return $this;
    }

    public function value(string $value): self
    {
        $values = explode(',', $value);
        foreach (array_keys($this->options) as $key) {
            $this->checked[$key] = in_array($key, $values);
        }
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
        foreach (array_keys($this->options) as $key) {
            $this->checked[$key] = in_array($key, $values);
        }
    }

    public function validate(Validator $validator): string
    {
        return $validator->validate(implode(',', array_keys(array_filter($this->checked))));
    }

    public function setError(string $message): void {}

    public function render(\DOMDocument $doc): \DOMElement
    {
        $wrapper = $doc->createElement('div');
        foreach ($this->options as $key => $value) {
            $checkbox = $this->renderElement($doc);
            $checkbox->setAttribute('name', $this->name);
            $checkbox->setAttribute('value', $key);
            if ($this->checked[$key]) {
                $checkbox->setAttribute('checked', 'checked');
            }
            $wrapper->appendChild($checkbox);
            $label = $doc->createElement('label');
            $label->textContent = $value;
            $wrapper->appendChild($label);
        }
        return $wrapper;
    }
}
