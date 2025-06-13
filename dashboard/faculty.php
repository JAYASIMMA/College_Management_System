<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'faculty') {
    header('Location: ../modules/login.php?role=faculty');
    exit;
}
require_once '../includes/db.php';
$stmt = $pdo->prepare('SELECT * FROM faculty WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$faculty = $stmt->fetch();
$notices = $pdo->query('SELECT * FROM notices ORDER BY created_at DESC LIMIT 5')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-title"><i class="fas fa-chalkboard-teacher"></i> Faculty</div>
        <ul>
            <li class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><a href="../modules/attendance_faculty.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
            <li><a href="../modules/marks_faculty.php"><i class="fas fa-chart-bar"></i> Marks</a></li>
            <li><a href="../modules/notices_faculty.php"><i class="fas fa-bullhorn"></i> Notices</a></li>
            <li><a href="../modules/profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="../modules/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <h1>Welcome, <?=$_SESSION['name']?>!</h1>
        <div class="faculty-info">
            <strong>Department:</strong> <?=htmlspecialchars($faculty['department'])?>
        </div>
        <div class="dashboard-cards">
            <div class="dash-card"><i class="fas fa-calendar-check"></i><span><a href="../modules/attendance_faculty.php">Attendance</a></span></div>
            <div class="dash-card"><i class="fas fa-chart-bar"></i><span><a href="../modules/marks_faculty.php">Marks</a></span></div>
            <div class="dash-card"><i class="fas fa-bullhorn"></i><span><a href="../modules/notices_faculty.php">Notices</a></span></div>
            <div class="dash-card"><i class="fas fa-user"></i><span><a href="../modules/profile.php">Profile</a></span></div>
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