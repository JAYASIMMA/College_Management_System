<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: ../modules/login.php?role=student');
    exit;
}
require_once '../includes/db.php';
// Fetch student info
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$student = $stmt->fetch();
// Fetch latest notices
$notices = $pdo->query('SELECT * FROM notices ORDER BY created_at DESC LIMIT 5')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-title"><i class="fas fa-user-graduate"></i> Student</div>
        <ul>
            <li class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><a href="../modules/profile.php"><i class="fas fa-id-card"></i> Profile</a></li>
            <li><a href="../modules/marks.php"><i class="fas fa-chart-bar"></i> Marks</a></li>
            <li><a href="../modules/attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
            <li><a href="../modules/notices.php"><i class="fas fa-bullhorn"></i> Notices</a></li>
            <li><a href="../modules/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <h1>Welcome, <?=$_SESSION['name']?>!</h1>
        <div class="student-info">
            <strong>Roll No:</strong> <?=htmlspecialchars($student['rollno'])?> | <strong>Department:</strong> <?=htmlspecialchars($student['department'])?>
        </div>
        <div class="dashboard-cards">
            <div class="dash-card"><i class="fas fa-id-card"></i><span>Profile</span></div>
            <div class="dash-card"><i class="fas fa-chart-bar"></i><span>Marks</span></div>
            <div class="dash-card"><i class="fas fa-calendar-check"></i><span>Attendance</span></div>
            <div class="dash-card"><i class="fas fa-bullhorn"></i><span>Notices</span></div>
        </div>
        <section class="notices-section">
            <h2><i class="fas fa-bullhorn"></i> Latest Notices</h2>
            <ul class="notices-list">
                <?php foreach($notices as $notice): ?>
                <li><strong><?=htmlspecialchars($notice['title'])?></strong> <span class="notice-date"><?=date('d M Y, H:i', strtotime($notice['created_at']))?></span><br><?=htmlspecialchars($notice['content'])?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</div>
<div class="footer">Created by Jayasimma D</div>
</body>
</html> 