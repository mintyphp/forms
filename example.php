<?php

use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

// include MintyPHP Forms
require_once 'vendor/autoload.php';

// set style to Bulma
E::$style = 'bulma';

// create a form object
$form = E::form([
    E::field(E::text('username'), E::label('Username'), [V::required('Username is required')]),
    E::field(E::password('password'), E::label('Password')),
    E::field(E::submit('Login')),
]);

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // fill the form with the submitted data
    $form->fill($_POST);
    // if the form is valid, process the data
    if ($form->validate()) {
        // extract the data
        $data = $form->extract();
        // process the data (e.g., login, save to database, etc.)
        if ($data['username'] == 'user' && $data['password'] == 'pass') {
            // redirect to the dashboard page
            die('logged in, redirecting to dashboard...');
        } else {
            // invalidate credentials
            $form->addErrors([
                'username' => 'Invalid username/password combination',
                'password' => 'Invalid username/password combination',
            ]);
        }
    }
} else {
    // if the form is not submitted, fill it with empty values
    $form->fill(['username' => '', 'password' => '']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/1.0.3/css/bulma.min.css">
</head>

<body class="container p-5">
    <h1 class="title">Login</h1>
    <?php $form->render(); ?>
</body>

</html>