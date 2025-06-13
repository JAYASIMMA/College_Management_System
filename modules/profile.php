<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
require_once '../includes/db.php';
$role = $_SESSION['role'];
$id = $_SESSION['user_id'];
$msg = '';
if ($role === 'student') {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} elseif ($role === 'faculty') {
    $stmt = $pdo->prepare('SELECT * FROM faculty WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} else {
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    if ($role === 'student') {
        $rollno = trim($_POST['rollno']);
        $department = trim($_POST['department']);
        $stmt = $pdo->prepare('UPDATE students SET name=?, email=?, rollno=?, department=? WHERE id=?');
        $stmt->execute([$name, $email, $rollno, $department, $id]);
    } elseif ($role === 'faculty') {
        $department = trim($_POST['department']);
        $stmt = $pdo->prepare('UPDATE faculty SET name=?, email=?, department=? WHERE id=?');
        $stmt->execute([$name, $email, $department, $id]);
    } else {
        $stmt = $pdo->prepare('UPDATE admins SET name=?, email=? WHERE id=?');
        $stmt->execute([$name, $email, $id]);
    }
    $_SESSION['name'] = $name;
    $msg = 'Profile updated!';
    header('Location: profile.php?success=1');
    exit;
}
if (isset($_GET['success'])) $msg = 'Profile updated!';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Edit Profile</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <form method="post" class="form" style="max-width:400px;">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?=htmlspecialchars($user['name'])?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
        </div>
        <?php if($role==='student'): ?>
        <div class="form-group">
            <label>Roll No</label>
            <input type="text" name="rollno" value="<?=htmlspecialchars($user['rollno'])?>" required>
        </div>
        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" value="<?=htmlspecialchars($user['department'])?>" required>
        </div>
        <?php elseif($role==='faculty'): ?>
        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" value="<?=htmlspecialchars($user['department'])?>" required>
        </div>
        <?php endif; ?>
        <button type="submit" class="btn-primary">Update Profile</button>
    </form>
    <div style="margin-top:1.2rem;"><a href="../dashboard/<?=$role?>.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 