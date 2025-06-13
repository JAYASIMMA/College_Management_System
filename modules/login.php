<?php
session_start();
require_once '../includes/db.php';
$role = $_GET['role'] ?? '';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $table = $role === 'admin' ? 'admins' : ($role === 'student' ? 'students' : 'faculty');
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $user['name'];
        header('Location: ../dashboard/' . $role . '.php');
        exit;
    } else {
        $msg = 'Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=ucfirst($role)?> Login - College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="landing-bg">
    <div class="landing-container" style="max-width: 370px;">
        <h2 class="landing-title"><i class="fas fa-sign-in-alt"></i> <?=ucfirst($role)?> Login</h2>
        <?php if($msg): ?><div class="error-msg"><?=$msg?></div><?php endif; ?>
        <form method="post" class="form">
            <input type="hidden" name="role" value="<?=$role?>">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required autocomplete="username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <div class="register-links" style="margin-top:1.2rem;">
            <?php if($role==='student'): ?>
                <a href="register.php?role=student">Student Registration</a>
            <?php elseif($role==='faculty'): ?>
                <a href="register.php?role=faculty">Faculty Registration</a>
            <?php endif; ?>
        </div>
        <div style="margin-top:1.2rem;"><a href="../index.php">&larr; Back to Home</a></div>
    </div>
    <div class="footer">Created by Jayasimma D</div>
</body>
</html> 