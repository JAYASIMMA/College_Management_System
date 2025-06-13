<?php
require_once '../includes/db.php';
$role = $_GET['role'] ?? '';
$msg = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $department = $_POST['department'] ?? '';
    $rollno = $_POST['rollno'] ?? '';
    if ($role === 'student') {
        $required = $name && $email && $password && $rollno && $department;
    } elseif ($role === 'faculty') {
        $required = $name && $email && $password && $department;
    } else { // admin
        $required = $name && $email && $password;
    }
    if (!$required) {
        $msg = 'All fields are required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Invalid email address.';
    } else {
        if ($role === 'student') {
            $table = 'students';
        } elseif ($role === 'faculty') {
            $table = 'faculty';
        } else {
            $table = 'admins';
        }
        $stmt = $pdo->prepare("SELECT id FROM $table WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $msg = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            if ($role === 'student') {
                $stmt = $pdo->prepare("INSERT INTO students (name, rollno, email, department, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $rollno, $email, $department, $hash]);
            } elseif ($role === 'faculty') {
                $stmt = $pdo->prepare("INSERT INTO faculty (name, email, department, password) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $department, $hash]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hash]);
            }
            $msg = 'Registration successful! You can now login.';
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=ucfirst($role)?> Registration - College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="landing-bg">
    <div class="landing-container" style="max-width: 420px;">
        <h2 class="landing-title"><i class="fas fa-user-plus"></i> <?=ucfirst($role)?> Registration</h2>
        <?php if($msg): ?><div class="<?= $success ? 'success-msg' : 'error-msg' ?>"><?=$msg?></div><?php endif; ?>
        <?php if(!$success): ?>
        <form method="post" class="form">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <?php if($role==='student'): ?>
            <div class="form-group">
                <label>Roll No</label>
                <input type="text" name="rollno" required>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <?php if($role==='student' || $role==='faculty'): ?>
            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" required>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Register</button>
        </form>
        <?php endif; ?>
        <div style="margin-top:1.2rem;"><a href="login.php?role=<?=$role?>">&larr; Back to Login</a></div>
    </div>
    <div class="footer">Created by Jayasimma D</div>
</body>
</html> 