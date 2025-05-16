<?php

namespace MintyPHP\Form\Bulma;

use MintyPHP\Form\FormCheckbox;
use MintyPHP\Form\FormCheckboxes;
use MintyPHP\Form\FormField as Base;

class FormField extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->class('field');
    }

    public function setError(string $message): void
    {
        parent::setError($message);
        $this->removeClass('error');
    }

    public function render(\DOMDocument $doc): \DOMElement
    {
        if ($this->control instanceof FormCheckbox && $this->label) {
            $this->label->removeClass('label');
            $this->label->addClass('checkbox');
            $control = $this->control->render($doc);
            $label = $this->label->render($doc);
            $text = $label->textContent;
            $label->textContent = '';
            $field = $this->renderElement($doc);
            $label->appendChild($control);
            $label->insertAdjacentText('beforeend', $text);
            $field->appendChild($label);
            if ($this->error) {
                $field->appendChild($this->error->render($doc));
            }
            return $field;
        }
        if ($this->control instanceof FormCheckboxes && $this->label) {
            $field = $this->renderElement($doc);
            $field->appendChild($this->label->render($doc));
            $field->appendChild($this->control->render($doc));
            if ($this->error) {
                $field->appendChild($this->error->render($doc));
            }
            return $field;
        }
        return parent::render($doc);
    }
}
