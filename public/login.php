<?php
session_start();
require 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $users[$username]['role'];
    header('Location: dashboard.php');
} else {
    echo 'Invalid credentials';
}
?>
