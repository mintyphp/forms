<?php

namespace MintyPHP\Form\Bulma;

use MintyPHP\Form\Checkbox;
use MintyPHP\Form\Checkboxes;
use MintyPHP\Form\Field as Base;

class Field extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->class('field');
    }

    public function setError(string $message): void
    {
        parent::setError($message);
        $this->removeClass('has-error');
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        if ($this->control instanceof Checkbox && $this->label) {
            $this->label->removeClass('label');
            $this->label->addClass('checkbox');
            $control = $this->control->renderDom($doc);
            $label = $this->label->renderDom($doc);
            $text = $label->textContent;
            $label->textContent = '';
            $field = $this->renderElement($doc);
            $label->appendChild($control);
            $label->insertAdjacentText('beforeend', $text);
            $field->appendChild($label);
            if ($this->error) {
                $field->appendChild($this->error->renderDom($doc));
            }
            return $field;
        }
        if ($this->control instanceof Checkboxes && $this->label) {
            $field = $this->renderElement($doc);
            $field->appendChild($this->label->renderDom($doc));
            $field->appendChild($this->control->renderDom($doc));
            if ($this->error) {
                $field->appendChild($this->error->renderDom($doc));
            }
            return $field;
        }
        return parent::renderDom($doc);
    }
}
