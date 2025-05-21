<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Select implements Control
{
    use HtmlElement;

    protected string $name = '';
    /** @var array<string|int,string> $options */
    protected array $options = [];
    /** @var string[] $values */
    protected array $values = [];
    protected string $placeholder = 'Select an option';

    protected bool $disabled = false;
    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $autofocus = false;
    protected string $autocomplete = '';

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

    public function disabled(): self
    {
        $this->disabled = true;
        return $this;
    }

    public function readonly(): self
    {
        $this->readonly = true;
        return $this;
    }

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function autofocus(): self
    {
        $this->autofocus = true;
        return $this;
    }

    public function autocomplete(string $value): self
    {
        $this->autocomplete = $value;
        return $this;
    }

    /**
     * @param array<string|int,string> $options
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
        $values = $data[$this->name] ?? [];
        if (!is_array($values)) {
            $values = [$values];
        }
        $this->values = $values;
    }

    /**
     * @return array<string, string|string[]|null> $data
     */
    public function extract(bool $withNulls = false): array
    {
        if (!$this->name) {
            return [];
        }
        if ($this->disabled) {
            return [];
        }
        if ($this->multiple) {
            return [$this->name => $this->values];
        }
        $value = trim($this->values[0] ?? '');
        if ($withNulls) {
            $value = strlen($value) ? $value : null;
        }
        return [$this->name => $value];
    }

    public function validate(Validator $validator): string
    {
        if (!$this->required && !$this->values) {
            return '';
        }
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
        $option = $doc->createElement('option');
        $option->setAttribute('value', '');
        $option->textContent = $this->placeholder;
        $select->appendChild($option);
        foreach ($this->options as $key => $value) {
            $option = $doc->createElement('option');
            $option->setAttribute('value', strval($key));
            if (in_array($key, $this->values)) {
                $option->setAttribute('selected', 'selected');
            }
            $option->textContent = $value;
            $select->appendChild($option);
        }
        return $select;
    }
}
