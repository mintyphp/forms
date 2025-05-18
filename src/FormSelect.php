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
    /** @var string[] $values */
    protected array $values = [];
    protected bool $multiple = false;

    public function __construct()
    {
        $this->tag('select');
    }

    public function multiple(): self
    {
        $this->multiple = true;
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

    /**
     * @param array<string,string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function value(string $value): self
    {
        $this->values = [$value];
        return $this;
    }

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        $values = $data[$this->name] ?? [];
        if (!is_array($values)) {
            $values = [$values];
        }
        $this->values = $values;
    }

    /**
     * @return array<string, string|string[]|null>
     */
    public function extract(): array
    {
        if (!$this->name) {
            return [];
        }
        if (!$this->values) {
            return [$this->name => null];
        }
        return [$this->name => $this->multiple ? $this->values : implode(',', $this->values)];
    }

    public function validate(Validator $validator): string
    {
        if (array_diff($this->values, array_keys($this->options))) {
            return 'Invalid option value';
        }
        return $validator->validate(implode(',', $this->values));
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $select = $this->renderElement($doc);
        $select->setAttribute('name', $this->name);
        if ($this->multiple) {
            $select->setAttribute('multiple', 'multiple');
        }
        foreach ($this->options as $key => $value) {
            $option = $doc->createElement('option');
            $option->setAttribute('value', $key);
            if (in_array($key, $this->values)) {
                $option->setAttribute('selected', 'selected');
            }
            $option->textContent = $value;
            $select->appendChild($option);
        }
        return $select;
    }
}
