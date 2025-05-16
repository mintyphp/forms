<?php

namespace MintyPHP\Form\Bulma;

use MintyPHP\Form\FormLabel as Base;

class FormLabel extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->class('label');
    }
}
