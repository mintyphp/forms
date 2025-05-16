<?php

namespace MintyPHP\Form\Bulma;

use MintyPHP\Form\FormError as Base;

class FormError extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->tag('p');
        $this->class('help');
    }

    public function setError(string $message): void
    {
        parent::setError($message);
        if ($message) {
            $this->addClass('is-danger');
        } else {
            $this->removeClass('is-danger');
        }
    }
}
