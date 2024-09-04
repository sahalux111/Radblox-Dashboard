<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'qa') {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$current_time = new DateTime('now', new DateTimeZone('Asia/Kolkata'));

$available_now = [];
$upcoming_scheduled = [];
$breaks = [];

foreach ($doctor_breaks as $doctor => $break_end) {
    if ($current_time >= $break_end) {
        // Break is over, move doctor back to available
        list($start_time, $end_time) = $available_doctors[$doctor] ?? [null, null];
        if ($start_time && $end_time) {
            $start_time = new DateTime($start_time);
            $end_time = new DateTime($end_time);
            if ($start_time <= $current_time && $current_time <= $end_time) {
                $available_now[$doctor] = $end_time->format('Y-m-d H:i');
            }
        }
        unset($doctor_breaks[$doctor]);
    } else {
        // Break is ongoing
        $breaks[$doctor] = $break_end->format('Y-m-d H:i');
    }
}

foreach ($available_doctors as $doctor => [$start_time, $end_time]) {
    $start_time = new DateTime($start_time);
    $end_time = new DateTime($end_time);

    if ($start_time <= $current_time && $current_time <= $end_time && !isset($doctor_breaks[$doctor])) {
        $available_now[$doctor] = $end_time->format('Y-m-d H:i');
    } elseif ($start_time > $current_time) {
        $upcoming_scheduled[$doctor] = [$start_time->format('Y-m-d H:i'), $end_time->format('Y-m-d H:i')];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QA Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .bg-available { background-color: #e9ecef; border-left: 5px solid #28a745; }
        .bg-upcoming { background-color: #e9ecef; border-left: 5px solid #17a2b8; }
        .bg-break { background-color: #e9ecef; border-left: 5px solid #ffc107; }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>QA Dashboard</h1>
        <div class="mb-4">
            <h3>Available Now</h3>
            <?php if ($available_now): ?>
                <ul class="list-group">
                    <?php foreach ($available_now as $doctor => $end_time): ?>
                        <li class="list-group-item bg-available">
                            <strong><?= htmlspecialchars($doctor) ?></strong> is available until <span class="badge bg-success"><?= htmlspecialchars($end_time) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No doctors are available now.</p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <h3>Upcoming Scheduled Availability</h3>
            <?php if ($upcoming_scheduled): ?>
                <ul class="list-group">
                    <?php foreach ($upcoming_scheduled as $doctor => [$start_time, $end_time]): ?>
                        <li class="list-group-item bg-upcoming">
                            <strong><?= htmlspecialchars($doctor) ?></strong> will be available from <span class="badge bg-info"><?= htmlspecialchars($start_time) ?></span> to <span class="badge bg-info"><?= htmlspecialchars($end_time) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No upcoming schedules.</p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <h3>Doctors on Break</h3>
            <?php if ($breaks): ?>
                <ul class="list-group">
                    <?php foreach ($breaks as $doctor => $break_end): ?>
                        <li class="list-group-item bg-break">
                            <strong><?= htmlspecialchars($doctor) ?></strong> is on break until <span class="badge bg-warning text-dark"><?= htmlspecialchars($break_end) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No doctors are currently on break.</p>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
