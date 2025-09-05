<?php
$returnUrl = isset($_GET['returnUrl']) ? htmlspecialchars($_GET['returnUrl']) : '/';
header("Refresh: 2; URL=$returnUrl");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <meta http-equiv="refresh" content="2;url=<?php echo $returnUrl; ?>">
</head>
<body>
    <div class="container my-5">
        <div class="notification is-success">
            <p>Your data is being processed.<br>You are automatically redirected in 2 seconds.</p>
        </div>
    </div>
</body>
</html>