<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class SelectOrType implements Control
{
    use HtmlElement;

    protected string $name = '';
    /** @var array<string> $options */
    protected array $options = [];
    /** @var array<string> $originalOptions */
    protected array $originalOptions = [];
    protected string $value = '';
    protected string $placeholder = '';
    protected string $typeCaption = 'Type a value ...';

    protected bool $disabled = false;
    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $autofocus = false;
    protected string $autocomplete = '';

    protected bool $inputMode = false;

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
     * @param array<string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
        if (!in_array('', $this->options)) {
            array_unshift($this->options, ''); // Add empty option if not present
        }
        $this->originalOptions = $this->options;
        $this->options[] = $this->typeCaption;
        return $this;
    }

    public function value(string $value): self
    {
        $this->value = $value;
        $this->options = $this->originalOptions;
        if ($this->value && !in_array($this->value, $this->options)) {
            $this->options[] = $this->value;
        }
        $this->options[] = $this->typeCaption;
        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function typeCaption(string $typeCaption): self
    {
        $this->typeCaption = $typeCaption;
        array_pop($this->options);
        array_push($this->options, $this->typeCaption);
        return $this;
    }

    /**
     * @param array<string, string|null> $data
     */
    public function fill(array $data): void
    {
        $this->value($data[$this->name] ?? '');
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
        if (!in_array($this->value, $this->options)) {
            return 'Invalid option value';
        }
        return $validator->validate($this->value);
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $select = $this->renderElement($doc);
        $select->setAttribute('name', $this->name);
        if ($this->required) {
            $select->setAttribute('required', 'required');
        }
        $i = 0;
        foreach ($this->options as $value) {
            $caption = $value ?: '...';
            $isLast = $i == count($this->options) - 1;
            $option = $doc->createElement('option', $caption);
            if (!$isLast) {
                $option->setAttribute('value', $value);
                if ($value == $this->value) {
                    $option->setAttribute('selected', 'selected');
                }
            }
            $select->appendChild($option);
            $i += 1;
            if ($i == count($this->originalOptions)) {
                $hr = $doc->createElement('hr');
                $select->appendChild($hr);
            }
        }
        $select->setAttribute('onchange', "var last=this.options[this.options.length-1]; var hasPrevious=last.previousSibling.nodeName=='HR'; if (this.options.length-1==this.selectedIndex) { var str=prompt(last.text,last.previousSibling.text); if (str) { if (hasPrevious) { opt=document.createElement('option'); this.insertBefore(opt, last); } else { opt=last.previousSibling; } opt.value=opt.text=str; this.selectedIndex-=1; } else { this.selectedIndex=this.dataset.lastIndex; } } this.dataset.lastIndex=this.selectedIndex;");
        return $select;
    }
}
