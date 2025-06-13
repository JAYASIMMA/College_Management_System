<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'faculty') {
    header('Location: login.php?role=faculty');
    exit;
}
require_once '../includes/db.php';
$faculty_id = $_SESSION['user_id'];
$msg = '';
// Fetch subjects assigned to this faculty
$subjects = $pdo->prepare('SELECT * FROM subjects WHERE faculty_id = ?');
$subjects->execute([$faculty_id]);
$subjects = $subjects->fetchAll();
// Handle attendance submission
if (isset($_POST['mark_attendance'])) {
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    foreach ($_POST['attendance'] as $student_id => $status) {
        $stmt = $pdo->prepare('INSERT INTO attendance (student_id, subject_id, date, status) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status)');
        $stmt->execute([$student_id, $subject_id, $date, $status]);
    }
    $msg = 'Attendance marked!';
}
// Fetch students for selected subject
$students = [];
if (isset($_POST['subject_id']) || isset($_GET['subject_id'])) {
    $subject_id = $_POST['subject_id'] ?? $_GET['subject_id'];
    $stmt = $pdo->prepare('SELECT students.* FROM students JOIN courses ON students.department = courses.department_id JOIN subjects ON subjects.course_id = courses.id WHERE subjects.id = ?');
    $stmt->execute([$subject_id]);
    $students = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Mark Attendance</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <form method="post" class="form" style="max-width:400px;">
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" required onchange="this.form.submit()">
                <option value="">Select</option>
                <?php foreach($subjects as $s): ?>
                <option value="<?=$s['id']?>" <?=isset($subject_id)&&$subject_id==$s['id']?'selected':''?>><?=$s['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" value="<?=date('Y-m-d')?>" required>
        </div>
    </form>
    <?php if($students): ?>
    <form method="post" class="form">
        <input type="hidden" name="subject_id" value="<?=$subject_id?>">
        <input type="hidden" name="date" value="<?=isset($_POST['date'])?$_POST['date']:date('Y-m-d')?>">
        <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
            <tr><th>Student</th><th>Present</th><th>Absent</th></tr>
            <?php foreach($students as $stu): ?>
            <tr>
                <td><?=htmlspecialchars($stu['name'])?></td>
                <td><input type="radio" name="attendance[<?=$stu['id']?>]" value="Present" required></td>
                <td><input type="radio" name="attendance[<?=$stu['id']?>]" value="Absent"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" name="mark_attendance" class="btn-primary">Submit Attendance</button>
    </form>
    <?php endif; ?>
    <div style="margin-top:1.2rem;"><a href="../dashboard/faculty.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 