<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php?role=student');
    exit;
}
require_once '../includes/db.php';
$student_id = $_SESSION['user_id'];
$attendance = $pdo->prepare('SELECT attendance.*, subjects.name as subject_name FROM attendance LEFT JOIN subjects ON attendance.subject_id = subjects.id WHERE attendance.student_id = ? ORDER BY date DESC');
$attendance->execute([$student_id]);
$attendance = $attendance->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Attendance</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>My Attendance</h2>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>Date</th><th>Subject</th><th>Status</th></tr>
        <?php foreach($attendance as $a): ?>
        <tr>
            <td><?=date('d M Y', strtotime($a['date']))?></td>
            <td><?=htmlspecialchars($a['subject_name'])?></td>
            <td><?=$a['status']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/student.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 