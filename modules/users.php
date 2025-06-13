<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?role=admin');
    exit;
}
require_once '../includes/db.php';
$msg = '';
// Handle delete
if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = $_GET['delete'];
    $type = $_GET['type'];
    $table = $type === 'student' ? 'students' : ($type === 'faculty' ? 'faculty' : 'admins');
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    $msg = ucfirst($type).' deleted!';
}
$students = $pdo->query('SELECT * FROM students')->fetchAll();
$faculty = $pdo->query('SELECT * FROM faculty')->fetchAll();
$admins = $pdo->query('SELECT * FROM admins')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Manage Users</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <h3>Admins</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
        <?php foreach($admins as $a): ?>
        <tr>
            <td><?=$a['id']?></td>
            <td><?=htmlspecialchars($a['name'])?></td>
            <td><?=htmlspecialchars($a['email'])?></td>
            <td><a href="?delete=<?=$a['id']?>&type=admin" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3>Faculty</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Action</th></tr>
        <?php foreach($faculty as $f): ?>
        <tr>
            <td><?=$f['id']?></td>
            <td><?=htmlspecialchars($f['name'])?></td>
            <td><?=htmlspecialchars($f['email'])?></td>
            <td><?=htmlspecialchars($f['department'])?></td>
            <td><a href="?delete=<?=$f['id']?>&type=faculty" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3>Students</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Name</th><th>Roll No</th><th>Email</th><th>Department</th><th>Action</th></tr>
        <?php foreach($students as $s): ?>
        <tr>
            <td><?=$s['id']?></td>
            <td><?=htmlspecialchars($s['name'])?></td>
            <td><?=htmlspecialchars($s['rollno'])?></td>
            <td><?=htmlspecialchars($s['email'])?></td>
            <td><?=htmlspecialchars($s['department'])?></td>
            <td><a href="?delete=<?=$s['id']?>&type=student" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/admin.php">&larr; Back to Dashboard</a></div>
</div>
<div class="footer">Created by Jayasimma D</div>
</body>
</html> 