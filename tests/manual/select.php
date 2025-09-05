<?php

// alias the most used classes
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

// ensure all classes are (auto)loaded:
require_once __DIR__ . '/../../vendor/autoload.php';

// set style to Bulma
E::$style = 'bulma';

// create a form object
$form = E::form([
    E::field(E::submit('Save')->attribute('style','float:right; margin-top: 2rem;')),
    E::field(E::select('room', ['b'=>'Bathroom', 'k'=>'Kitchen'])->required(), E::label('Select a room')),
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
        die(header('Location: redirect.php?returnUrl=select.php'));
    }
} else {
    // if the form is not submitted, fill it with empty values
    $form->fill([]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/1.0.3/css/bulma.min.css">
</head>

<body>
    <div class="container my-5">
        <?php $form->render(); ?>
    </div>
</body>

</html>