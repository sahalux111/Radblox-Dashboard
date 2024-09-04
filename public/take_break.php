<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'doctor') {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$break_duration = $_POST['break_duration'] ?? 0;

if ($break_duration > 0) {
    $break_end = (new DateTime('now', new DateTimeZone('Asia/Kolkata')))
        ->add(new DateInterval("PT{$break_duration}M"));
    $doctor_breaks[$username] = $break_end;
    header('Location: dashboard.php');
    exit();
} else {
    echo 'Invalid break duration';
}
?>

