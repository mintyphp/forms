<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class FormField
{
    use HtmlElement;

    protected ?FormLabel $label = null;
    protected ?FormControl $control = null;
    protected ?FormError $error = null;
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

    public function label(FormLabel $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function control(FormControl $control): self
    {
        $this->control = $control;
        return $this;
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

    public function error(FormError $error): self
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @param array<string, string|string[]> $data
     */
    public function fill(array $data): void
    {
        if ($this->control) {
            $this->control->fill($data);
        }
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
                /** @var FormError */
                $error = Elements::create('FormError');
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

    public function render(\DOMDocument $doc): \DOMElement
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
            $field->appendChild($this->label->render($doc));
        }
        if ($this->control) {
            $control = $this->control->render($doc);
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
            $field->appendChild($this->error->render($doc));
        }
        return $field;
    }
}
