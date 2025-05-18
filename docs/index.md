# MintyPHP Forms

MintyPHP Forms is a powerful PHP form builder that enables you to create and validate forms without having to write a lot of boiler plate code.

## Features

- Bulma renderer, easily creating good looking forms
- Validation rules, such as validating email, string length and numeric comparisons
- Support checkbox arrays and multi selects
- Best practices: follows best practices, well-tested, object oriented code
- Extensible: create support for your favorite framework or form rendering style

## Installation

Run the following command to install MintyPHP Forms with Composer.

```bash
composer require mintyphp/forms
```

The package has no dependencies on other packages.

## Quick Start

Then add the following to alias the most used classes in your PHP file:

```php
use MintyPHP\Forms\Elements as E;
use MintyPHP\Forms\Elements as V;
```

Create a simple login form using:

```php
$form = E::form([
    E::field(E::text('username'),E::label('Username'),[V::required('Username is required')]),
    E::field(E::password('password'),E::label('Password')),
    E::field(E::submit('Login')),
]);
$form->render(true);
```

Now render the form using:

```html 
<form method="post">
  <div>
    <label for="username">Username</label>
    <input id="username" type="text" name="username" value=""/>
  </div>
  <div>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" value=""/>
  </div>
  <div>
    <input type="submit" value="Login"/>
  </div>
</form>
```

Easy as that.

## Frameworks

MintyPHP Forms has support for the Bulma framework right out of the box. 
Just tell MintyPHP Forms that you want to use Bulmas style forms using:

```php
E::$style = 'bulma';
// now render the same form
$form = E::form([
    E::field(E::text('username'),E::label('Username'),[V::required('Username is required')]),
    E::field(E::password('password'),E::label('Password')),
    E::field(E::submit('Login')),
]);
$form->render(true);
```

And the output will be form in the familiar Bulma style:

```html 
<form method="post">',
  <div class="field">',
    <label class="label" for="username">Username</label>',
    <div class="control">',
      <input id="username" class="input" type="text" name="username" value=""/>',
    </div>',
  </div>',
  <div class="field">',
    <label class="label" for="password">Password</label>',
    <div class="control">',
      <input id="password" class="input" type="password" name="password" value=""/>',
    </div>',
  </div>',
  <div class="field">',
    <div class="control">',
      <input class="button is-primary" type="submit" value="Login"/>',
    </div>',
  </div>',
</form>',
```

In the future we will add support for other frameworks, such as bootstrap 5.

## Full Example

Copy and paste the following code into a new .php document and see just how fast and easy MintyPHP Forms really is.

A Full Contact Form using Bulma

<?php
// include MintyPHP Forms
require_once 'vendor/autoload.php';

// set style to Bulma

// create a form object
$form = new MintyPHP Forms\MintyPHP Forms;

// make all fields required
$form->required = '*';

// check if the form has been submitted
if ($form->submitted())
{
    // get our form values and assign them to a variable
    $data = $form->validate('Name, Email, Comments');

    // show a success message if no errors
    if($form->ok()) {
        $form->success_message = "Thank you, {$data['name']}!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
<body class="container">
    <?php $form->messages(); ?>
    <?php $form->create_form('Name, Email, Comments|textarea'); ?>
</body>
</html>

Next Methods
Made with Material for MkDocs
