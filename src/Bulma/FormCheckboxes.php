<?php

namespace MintyPHP\Form\Bulma;

use DOMElement;
use MintyPHP\Form\FormCheckboxes as Base;

class FormCheckboxes extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->tag('div');
        $this->class('checkboxes');
    }

    public function setError(string $message): void
    {
        if ($message) {
            $this->addClass('is-danger');
        } else {
            $this->removeClass('is-danger');
        }
    }

    public function render(\DOMDocument $doc): \DOMElement
    {
        $div = $this->renderElement($doc);
        foreach ($this->options as $key => $value) {
            $label = $doc->createElement('label');
            $label->setAttribute('class', 'checkbox');
            $checkbox = $doc->createElement('input');
            $checkbox->setAttribute('type', 'checkbox');
            $checkbox->setAttribute('name', $this->name);
            $checkbox->setAttribute('value', $key);
            if (in_array($key, $this->values)) {
                $checkbox->setAttribute('checked', 'checked');
            }
            $label->appendChild($checkbox);
            $label->insertAdjacentText('beforeend', $value);
            $div->appendChild($label);
        }
        return $div;
    }
}
