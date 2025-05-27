<?php

namespace MintyPHP\Form;

use DOMDocument;
use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Input implements Control
{
    use HtmlElement;

    protected string $name = '';
    protected string $value = '';
    protected string $type = 'text';
    protected string $placeholder = '';

    /** @var array<string|int,string> $options */
    protected array $options = [];

    protected bool $disabled = false;
    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $autofocus = false;
    protected string $autocomplete = '';

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
     * @param array<string|int,string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
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
        $value = trim($this->value);
        if ($withNulls) {
            $value = strlen($value) ? $value : null;
        }
        return [$this->name => $value];
    }

    public function validate(Validator $validator): string
    {
        if (!$this->required && !$this->value) {
            return '';
        }
        return $validator->validate($this->value);
    }

    public function setError(string $message): void {}

    public function renderDom(DOMDocument $doc): DOMElement
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
        if ($this->disabled) {
            $input->setAttribute('disabled', 'disabled');
        }
        if ($this->readonly) {
            $input->setAttribute('readonly', 'readonly');
        }
        if ($this->required) {
            $input->setAttribute('required', 'required');
        }
        if ($this->autofocus) {
            $input->setAttribute('autofocus', 'autofocus');
        }
        if ($this->autocomplete) {
            $input->setAttribute('autocomplete', 'on');
        }
        if ($this->options) {
            $input->setAttribute('list', $this->name . '-options');
            $datalist = $doc->createElement('datalist');
            $datalist->setAttribute('id', $this->name . '-options');
            foreach ($this->options as $value => $label) {
                $option = $doc->createElement('option', $label);
                if (!is_int($value)) {
                    $option->setAttribute('value', $value);
                }
                $datalist->appendChild($option);
            }
            $wrapper = $doc->createElement('div');
            $wrapper->appendChild($input);
            $wrapper->appendChild($datalist);
            return $wrapper;
        }
        return $input;
    }
}
