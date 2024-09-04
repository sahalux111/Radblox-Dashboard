<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1>Admin Control</h1>
        <div class="mb-4">
            <h3>Manage Users</h3>
            <!-- Example content, replace with actual user management functionality -->
            <p>Here you can manage users, view logs, etc.</p>
        </div>
        
        <div class="text-center">
            <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
