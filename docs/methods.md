# Methods

This pages contains an overview of the structural methods that you can use to build a form.

All structural methods return a self-reference allowing to chain the method calls.

## Form

Is created by:

- **form**: Create a Form

And has the following structure building methods:

- **fieldsets**: Add multiple Fieldset elements
- **fieldset**: Add a single Fieldset element
- **fields**: Add multiple Field elements
- **field**: Add a single Field element
- **header**: Add a single Header element

Instead of:

    $form = E::form()->fields([...]);

You can use:

    $form = E::form([...]);

as a shortcut.

## Fieldset (optional)

Is created by:

- **fieldset**: Create a Fieldset

And has the following structure building methods:

- **legend**: Add a Legend element to the Fieldset
- **header**: Add a single Header element
- **fields**: Add multiple Field elements
- **field**: Add a single Field element

NB: Unless required you should use "fields", "field" and "header" on Form instead.

## Field

Is created by:

- **field**: Create a Field

And has the following structure building methods:

- **label**: Set the label for the Field
- **control**: Set the control for the Field
- **validators**: Set the validators for the Field

Instead of:

    $form = E::field()->control($control)->label($label)->validators([$validator]);

You can use:

    $form = E::field($control,$label,[$validator]);

as a shortcut.

## Input

Is created by:

- **text**: Create a text Input
- **password**: Create a password Input
- **email**: Create an email Input
- **number**: Create a number Input
- **submit**: Create a submit Input

And has the following structure building methods:

- **type**: Set the type of the Input
- **name**: Set the name of the Input
- **value**: Set the value of the Input
- **placeholder**: Set the placeholder of the Input

Instead of:

    $form = E::text()->name($name)->placeholder($placeholder);
    $form = E::submit()->value($value);

You can use:

    $form = E::text($name,$placeholder);
    $form = E::submit($value);

as a shortcut.