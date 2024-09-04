<?php
session_start();

// Dummy data for users and availability
$users = [
    'doctor1' => ['password' => password_hash('password1', PASSWORD_DEFAULT), 'role' => 'doctor'],
    'doctor2' => ['password' => password_hash('password2', PASSWORD_DEFAULT), 'role' => 'doctor'],
    'admin' => ['password' => password_hash('admin', PASSWORD_DEFAULT), 'role' => 'admin'],
    'qa' => ['password' => password_hash('qa', PASSWORD_DEFAULT), 'role' => 'qa']
];

$available_doctors = [
    'doctor1' => ['2024-09-01 09:00', '2024-09-01 17:00']
];

$doctor_breaks = [
    'doctor1' => new DateTime('2024-09-01 12:00', new DateTimeZone('Asia/Kolkata'))
];
?>
