<?php

namespace MintyPHP\Form;

use DOMElement;

class Legend
{
    use HtmlElement;

    public function __construct()
    {
        $this->tag('legend');
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        return $label;
    }
}
