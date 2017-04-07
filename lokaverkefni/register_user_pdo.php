<?php
require_once 'CheckPassword.php';
$usernameMinChars = 6;
$errors = [];
if (strlen($username) < $usernameMinChars) {
    $errors[] = "Username must be at least $usernameMinChars characters.";
}
if (preg_match('/\s/', $username)) {
    $errors[] = 'Username should not contain spaces.';
}
$checkPwd = new CheckPassword($password, 7);
$checkPwd->requireMixedCase();
$checkPwd->requireNumbers(2);
$passwordOK = $checkPwd->check();
if (!$passwordOK) {
    $errors = array_merge($errors, $checkPwd->getErrors());
}
if ($password != $retyped) {
    $errors[] = "Your passwords don't match.";
}
if (!errors) {
    echo "Halló";
    // encrypt password using default encryption
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,username,password)VALUES(:name,:email,:username,:password)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':name'=>$name, ':email'=>$email, ':username'=>$username, ':password'=>$password));         

	if ($stmt->rowCount() == 1) {
        $success = "$username has been registered. You may now log in.";
    } elseif ($stmt->errorCode() == 23000) {
        $errors[] = "$username is already in use. Please choose another username.";
    } else {
        $errorInfo = $stmt->errorInfo();
        if (isset($errorInfo[2])) {
            $errors[] = $errorInfo[2];
        }
    }
}