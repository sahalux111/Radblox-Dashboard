<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'doctor') {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$start_date = $_POST['start_date'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';

if ($start_date && $start_time && $end_time) {
    $start_datetime = new DateTime("$start_date $start_time", new DateTimeZone('Asia/Kolkata'));
    $end_datetime = new DateTime("$start_date $end_time", new DateTimeZone('Asia/Kolkata'));

    $available_doctors[$username] = [$start_datetime->format('Y-m-d H:i'), $end_datetime->format('Y-m-d H:i')];
    header('Location: dashboard.php');
    exit();
} else {
    echo 'Invalid input';
}
?>
