<?php

namespace MintyPHP\Form;

use DOMElement;

class FormLegend
{
    use HtmlElement;

    public function __construct()
    {
        $this->tag('legend');
    }

    public function render(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        return $label;
    }
}
