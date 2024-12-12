<?php
require_once 'User.php';

// Database credentials
$host = "localhost";
$user = "root";
$pass = "";
$db = "reserverendezvouz";

// Initialize the User class
$userObj = new User($host, $user, $pass, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($action == "register") {
        $fullname = trim($_POST['fullname']);
        echo $userObj->register($fullname, $email, $password);
    } elseif ($action == "login") {
        echo $userObj->login($email, $password);
    }
}
?>
