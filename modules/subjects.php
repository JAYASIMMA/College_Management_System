<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?role=admin');
    exit;
}
require_once '../includes/db.php';
// Fetch courses and faculty
$courses = $pdo->query('SELECT * FROM courses')->fetchAll();
$faculty = $pdo->query('SELECT * FROM faculty')->fetchAll();
$msg = '';
if (isset($_POST['add_subject'])) {
    $name = trim($_POST['name']);
    $course_id = $_POST['course_id'];
    $faculty_id = $_POST['faculty_id'];
    if ($name && $course_id && $faculty_id) {
        $stmt = $pdo->prepare('INSERT INTO subjects (name, course_id, faculty_id) VALUES (?, ?, ?)');
        $stmt->execute([$name, $course_id, $faculty_id]);
        $msg = 'Subject added!';
    } else {
        $msg = 'All fields required.';
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM subjects WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    $msg = 'Subject deleted!';
}
$subjects = $pdo->query('SELECT subjects.*, courses.name as course_name, faculty.name as faculty_name FROM subjects LEFT JOIN courses ON subjects.course_id = courses.id LEFT JOIN faculty ON subjects.faculty_id = faculty.id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Subjects</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Manage Subjects</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <form method="post" class="form" style="max-width:400px;">
        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Course</label>
            <select name="course_id" required>
                <option value="">Select</option>
                <?php foreach($courses as $c): ?>
                <option value="<?=$c['id']?>"><?=$c['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Faculty</label>
            <select name="faculty_id" required>
                <option value="">Select</option>
                <?php foreach($faculty as $f): ?>
                <option value="<?=$f['id']?>"><?=$f['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="add_subject" class="btn-primary">Add Subject</button>
    </form>
    <h3>All Subjects</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Name</th><th>Course</th><th>Faculty</th><th>Action</th></tr>
        <?php foreach($subjects as $s): ?>
        <tr>
            <td><?=$s['id']?></td>
            <td><?=htmlspecialchars($s['name'])?></td>
            <td><?=htmlspecialchars($s['course_name'])?></td>
            <td><?=htmlspecialchars($s['faculty_name'])?></td>
            <td><a href="?delete=<?=$s['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/admin.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 