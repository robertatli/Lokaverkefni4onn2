<?php 
 $error = '';
 if (isset($_POST['login'])) {
 session_start();
 $email = $_POST['email'];
 $password = $_POST['password'];
 // location to redirect on success
 $redirect = 'index2.php';
 require_once 'authenticate_user.php';
 } ?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
<?php include 'includes/menu.php' ?>
<div class="site">
<h1>Login</h1>
<?php
if ($error) {
    echo "<p>$error</p>";
} elseif (isset($_GET['expired'])) {
    ?>
    <p>Your session has expired. Please log in again.</p>
<?php } ?>
<form method="post" action="">
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
    </p>
    <p>
        <label for="pwd">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input name="login" type="submit" id="login" value="login">
    </p>
</form>
</div>
</body>
</html>