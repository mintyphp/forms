<?php

namespace MintyPHP\Form;

use MintyPHP\Form\Validator\Validator;

class Elements
{
    public static string $style = 'none';
    /** @var array<string, string> */
    public static array $namespaces = [
        'none' => 'MintyPHP\\Form\\',
        'bulma' => 'MintyPHP\\Form\\Bulma\\',
    ];

    /**
     * @param Field[] $fields
     */
    public static function form(array $fields = []): Form
    {
        /** @var Form */
        $form = self::create('Form');
        if ($fields) {
            $form->fields($fields);
        }
        return $form;
    }

    /**
     * @param Validator[] $validators
     */
    public static function field(?Control $control = null, ?Label $label = null, array $validators = []): Field
    {
        /** @var Field */
        $field = self::create('Field');
        if ($control) {
            $field->control($control);
        }
        if ($label) {
            $field->label($label);
        }
        if ($validators) {
            $field->validators($validators);
        }
        return $field;
    }

    protected static function create(string $className): object
    {
        $class = self::$namespaces[self::$style] . $className;
        if (class_exists($class)) {
            return new $class();
        }
        $class = self::$namespaces['none'] . $className;
        if (class_exists($class)) {
            return new $class();
        }
        throw new \Exception("Class $class does not exist");
    }

    public static function text(string $name = '', string $placeholder = ''): Input
    {
        /** @var Input */
        $input = self::create('Input');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }

    public static function password(string $name = '', string $placeholder = ''): Input
    {
        /** @var Input */
        $input = self::create('Input');
        $input->type('password');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }

    public static function email(string $name = '', string $placeholder = ''): Input
    {
        /** @var Input */
        $input = self::create('Input');
        $input->type('email');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }

    public static function number(string $name = '', string $placeholder = ''): Input
    {
        /** @var Input */
        $input = self::create('Input');
        $input->type('number');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }

    public static function submit(string $caption = ''): Input
    {
        /** @var Input */
        $input = self::create('Input');
        $input->type('submit');
        if ($caption) {
            $input->value($caption);
        }
        return $input;
    }

    public static function textarea(string $name = '', string $placeholder = ''): TextArea
    {
        /** @var TextArea */
        $textarea = self::create('TextArea');
        if ($name) {
            $textarea->name($name);
        }
        if ($placeholder) {
            $textarea->placeholder($placeholder);
        }
        return $textarea;
    }

    public static function checkbox(string $name = '', string $value = 'on'): Checkbox
    {
        /** @var Checkbox */
        $input = self::create('Checkbox');
        if ($name) {
            $input->name($name);
        }
        if ($value) {
            $input->value($value);
        }
        return $input;
    }

    /**
     * @param array<string|int, string> $options
     */
    public static function select(string $name = '', array $options = []): Select
    {
        /** @var Select */
        $select = self::create('Select');
        if ($name) {
            $select->name($name);
        }
        if ($options) {
            $select->options($options);
        }
        return $select;
    }

    /**
     * @param array<string> $options
     */
    public static function selectOrType(string $name = '', array $options = [], string $typeCaption = ''): SelectOrType
    {
        /** @var SelectOrType */
        $select = self::create('SelectOrType');
        if ($name) {
            $select->name($name);
        }
        if ($options) {
            $select->options($options);
        }
        if ($typeCaption) {
            $select->typeCaption($typeCaption);
        }
        return $select;
    }

    /**
     * @param array<string, string> $options
     */
    public static function checkboxes(string $name = '', array $options = []): Checkboxes
    {
        /** @var Checkboxes */
        $checkboxes = self::create('Checkboxes');
        if ($name) {
            $checkboxes->name($name);
        }
        if ($options) {
            $checkboxes->options($options);
        }
        return $checkboxes;
    }

    public static function label(string $caption = ''): Label
    {
        /** @var Label */
        $label = self::create('Label');
        if ($caption) {
            $label->caption($caption);
        }
        return $label;
    }

    public static function header(): Header
    {
        /** @var Header */
        $header = self::create('Header');
        return $header;
    }

    public static function legend(): Legend
    {
        /** @var Legend */
        $legend = self::create('Legend');
        return $legend;
    }

    public static function error(): Error
    {
        /** @var Error */
        $error = self::create('Error');
        return $error;
    }

    public static function fieldset(): Fieldset
    {
        /** @var Fieldset */
        $fieldset = self::create('Fieldset');
        return $fieldset;
    }
}
