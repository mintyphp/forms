<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class Field
{
    use HtmlElement;

    protected ?Label $label = null;
    protected ?Control $control = null;
    protected ?Error $error = null;
    /** @var Validator[] */
    protected array $validators = [];

    protected bool $hideError = false;

    protected bool $disabled = false;
    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $autofocus = false;

    public function __construct()
    {
        $this->tag('div');
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

    public function label(Label $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function control(Control $control): self
    {
        $this->control = $control;
        return $this;
    }

    public function getControl(): ?Control
    {
        return $this->control;
    }

    /**
     * @param Validator[] $validators
     */
    public function validators(array $validators): self
    {
        foreach ($validators as $validator) {
            $this->validators[] = $validator;
        }
        return $this;
    }

    public function error(Error $error): self
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        if ($this->control) {
            $this->control->fill($data);
        }
    }

    /**
     * @return array<string, string|string[]|null>
     */
    public function extract(): array
    {
        $data = [];
        if ($this->control) {
            $data = $this->control->extract();
        }
        return $data;
    }

    public function validate(): string
    {
        if (!$this->error) {
            $this->hideError = true;
        }
        foreach ($this->validators as $validator) {
            $errorMessage = $this->control->validate($validator);
            if ($errorMessage) {
                return $errorMessage;
            }
        }
        return '';
    }

    public function setError(string $message): void
    {
        if ($message) {
            $this->addClass('error');
        } else {
            $this->removeClass('error');
        }
        if ($this->label) {
            $this->label->setError($message);
        }
        if ($this->control) {
            $this->control->setError($message);
        }
        if ($message) {
            if (!$this->error) {
                /** @var Error */
                $error = Elements::create('Error');
                $this->error = $error;
            }
        } else if ($this->hideError) {
            $this->error = null;
            $this->hideError = false;
        }
        if ($this->error) {
            $this->error->setError($message);
        }
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $field = $this->renderElement($doc);
        if ($this->control && $this->label) {
            $id = $this->control->getId();
            if (!$id) {
                $id = $this->control->getName();
                $this->control->id($id);
            }
            $this->label->for($id);
        }
        if ($this->label) {
            $field->appendChild($this->label->renderDom($doc));
        }
        if ($this->control) {
            $control = $this->control->renderDom($doc);
            if ($this->disabled) {
                $control->setAttribute('disabled', 'disabled');
            }
            if ($this->readonly) {
                $control->setAttribute('readonly', 'readonly');
            }
            if ($this->required) {
                $control->setAttribute('required', 'required');
            }
            if ($this->autofocus) {
                $control->setAttribute('autofocus', 'autofocus');
            }
            $field->appendChild($control);
        }
        if ($this->error) {
            $field->appendChild($this->error->renderDom($doc));
        }
        return $field;
    }
}
