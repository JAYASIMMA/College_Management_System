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
// Handle marks submission
if (isset($_POST['assign_marks'])) {
    $subject_id = $_POST['subject_id'];
    $semester = $_POST['semester'];
    foreach ($_POST['marks'] as $student_id => $marks) {
        $stmt = $pdo->prepare('INSERT INTO marks (student_id, subject_id, semester, marks) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE marks = VALUES(marks)');
        $stmt->execute([$student_id, $subject_id, $semester, $marks]);
    }
    $msg = 'Marks assigned!';
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
    <title>Assign Marks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Assign Marks</h2>
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
            <label>Semester</label>
            <input type="number" name="semester" min="1" max="8" value="<?=isset($_POST['semester'])?$_POST['semester']:1?>" required>
        </div>
    </form>
    <?php if($students): ?>
    <form method="post" class="form">
        <input type="hidden" name="subject_id" value="<?=$subject_id?>">
        <input type="hidden" name="semester" value="<?=isset($_POST['semester'])?$_POST['semester']:1?>">
        <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
            <tr><th>Student</th><th>Marks</th></tr>
            <?php foreach($students as $stu): ?>
            <tr>
                <td><?=htmlspecialchars($stu['name'])?></td>
                <td><input type="number" name="marks[<?=$stu['id']?>]" min="0" max="100" required></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" name="assign_marks" class="btn-primary">Submit Marks</button>
    </form>
    <?php endif; ?>
    <div style="margin-top:1.2rem;"><a href="../dashboard/faculty.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 