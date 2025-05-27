<?php

namespace MintyPHP\Form\Bulma;

use DOMElement;
use MintyPHP\Form\Input as Base;

class Input extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->class('input');
    }

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
        if ($this->type == 'submit') {
            $this->removeClass('input');
            $this->addClass('button');
            $this->addClass('is-primary');
        }
        $input = parent::renderDom($doc);
        if ($input->tagName == 'div') {
            $wrapper = $input;
        } else {
            $wrapper = $doc->createElement('div');
            $wrapper->appendChild($input);
        }
        $wrapper->setAttribute('class', 'control');
        return $wrapper;
    }
}
