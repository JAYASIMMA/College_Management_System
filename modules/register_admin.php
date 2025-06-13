<?php
require_once '../includes/db.php';
$msg = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (!$name || !$email || !$password) {
        $msg = 'All fields are required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Invalid email address.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $msg = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);
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
    <title>Admin Registration - College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="landing-bg">
    <div class="landing-container" style="max-width: 420px;">
        <h2 class="landing-title"><i class="fas fa-user-plus"></i> Admin Registration</h2>
        <?php if($msg): ?><div class="<?= $success ? 'success-msg' : 'error-msg' ?>"><?=$msg?></div><?php endif; ?>
        <?php if(!$success): ?>
        <form method="post" class="form">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Register</button>
        </form>
        <?php endif; ?>
        <div style="margin-top:1.2rem;"><a href="login.php?role=admin">&larr; Back to Admin Login</a></div>
    </div>
    <div class="footer">Created by Jayasimma D</div>
</body>
</html> 