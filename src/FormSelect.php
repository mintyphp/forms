<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class FormSelect implements FormControl
{
    use HtmlElement;

    protected string $name = '';
    /** @var array<string,string> $options */
    protected array $options = [];
    /** @var array<string,bool> $checked */
    protected array $checked = [];

    public function __construct()
    {
        $this->tag('select');
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
        $select = $this->renderElement($doc);
        $select->setAttribute('name', $this->name);
        foreach ($this->options as $key => $value) {
            $option = $doc->createElement('option');
            $option->setAttribute('value', $key);
            if ($this->checked[$key]) {
                $option->setAttribute('selected', 'selected');
            }
            $option->textContent = $value;
            $select->appendChild($option);
        }
        return $select;
    }
}
