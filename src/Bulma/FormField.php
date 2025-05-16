<?php

namespace MintyPHP\Form\Bulma;

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
}
