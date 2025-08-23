<?php

namespace MintyPHP\Form\Bulma;

use DOMElement;
use MintyPHP\Form\SelectOrType as Base;

class SelectOrType extends Base
{
    public function setError(string $message): void
    {
        if ($message) {
            $this->addClass('is-danger');
        } else {
            $this->removeClass('is-danger');
        }
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $wrapper = $doc->createElement('div');
        $classes = array_merge(['select'], $this->classes);
        $wrapper->setAttribute('class', implode(' ', $classes));
        $select = parent::renderDom($doc);
        $select->removeAttribute('class');
        $wrapper->appendChild($select);
        return $wrapper;
    }
}
