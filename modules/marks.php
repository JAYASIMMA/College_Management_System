<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php?role=student');
    exit;
}
require_once '../includes/db.php';
$student_id = $_SESSION['user_id'];
$marks = $pdo->prepare('SELECT marks.*, subjects.name as subject_name FROM marks LEFT JOIN subjects ON marks.subject_id = subjects.id WHERE marks.student_id = ? ORDER BY semester, subject_name');
$marks->execute([$student_id]);
$marks = $marks->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Marks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>My Marks</h2>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>Semester</th><th>Subject</th><th>Marks</th></tr>
        <?php foreach($marks as $m): ?>
        <tr>
            <td><?=$m['semester']?></td>
            <td><?=htmlspecialchars($m['subject_name'])?></td>
            <td><?=$m['marks']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/student.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 