<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Checkboxes implements Control
{
    use HtmlElement;

    protected string $name = '';
    /** @var array<string,string> $options */
    protected array $options = [];
    /** @var string[] $values */
    protected array $values = [];

    protected bool $disabled = false;
    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $autofocus = false;
    protected string $autocomplete = '';

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
        return [$this->name => $this->values];
    }

    public function validate(Validator $validator): string
    {
        if (!$this->required && !$this->values) {
            return '';
        }
        if (array_diff($this->values, array_keys($this->options))) {
            return 'Invalid checkbox value';
        }
        return $validator->validate(implode(',', $this->values));
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $wrapper = $doc->createElement('fieldset');
        $wrapperId = $this->getId();
        $wrapper->setAttribute('id', $wrapperId);
        foreach ($this->options as $key => $value) {
            $checkbox = $this->renderElement($doc);
            $checkbox->setAttribute('id', $this->name . '_' . $key);
            $checkbox->setAttribute('name', $this->name);
            $checkbox->setAttribute('value', $key);
            if (in_array($key, $this->values)) {
                $checkbox->setAttribute('checked', 'checked');
            }
            $wrapper->appendChild($checkbox);
            $label = $doc->createElement('label', $value);
            $label->setAttribute('for', $this->name . '_' . $key);
            $wrapper->appendChild($label);
        }
        return $wrapper;
    }
}
