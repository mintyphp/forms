<?php

namespace MintyPHP\Form\Bulma;

use MintyPHP\Form\Label as Base;

class Label extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->class('label');
    }
}
