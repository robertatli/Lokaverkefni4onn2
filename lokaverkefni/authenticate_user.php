<?php
require_once 'connection.php';

$sql = "SELECT password FROM users WHERE email = ?";
// prepare statement
$stmt = $conn->prepare($sql);
// pass the input parameter as a single-element array
$stmt->execute(array($email));
$storedPwd = $stmt->fetchColumn();
var_dump($storedPwd, $password);
// check the submitted password against the stored version
if (password_verify($password, $storedPwd)) {
    $_SESSION['authenticated'] = 'Jethro Tull';
    // get the time the session started
    $_SESSION['start'] = time();
    session_regenerate_id();
    header("Location: $redirect"); exit;
} else {
    // if not verified, prepare error message
    $error = 'Invalid email or password';
}
