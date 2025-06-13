<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?role=admin');
    exit;
}
require_once '../includes/db.php';
// Fetch departments
$departments = $pdo->query('SELECT * FROM departments')->fetchAll();
// Handle add
$msg = '';
if (isset($_POST['add_course'])) {
    $name = trim($_POST['name']);
    $dept = $_POST['department_id'];
    if ($name && $dept) {
        $stmt = $pdo->prepare('INSERT INTO courses (name, department_id) VALUES (?, ?)');
        $stmt->execute([$name, $dept]);
        $msg = 'Course added!';
    } else {
        $msg = 'All fields required.';
    }
}
// Handle delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM courses WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    $msg = 'Course deleted!';
}
// List courses
$courses = $pdo->query('SELECT courses.*, departments.name as dept_name FROM courses LEFT JOIN departments ON courses.department_id = departments.id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Manage Courses</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <form method="post" class="form" style="max-width:400px;">
        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" required>
                <option value="">Select</option>
                <?php foreach($departments as $d): ?>
                <option value="<?=$d['id']?>"><?=$d['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="add_course" class="btn-primary">Add Course</button>
    </form>
    <h3>All Courses</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Name</th><th>Department</th><th>Action</th></tr>
        <?php foreach($courses as $c): ?>
        <tr>
            <td><?=$c['id']?></td>
            <td><?=htmlspecialchars($c['name'])?></td>
            <td><?=htmlspecialchars($c['dept_name'])?></td>
            <td><a href="?delete=<?=$c['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/admin.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 