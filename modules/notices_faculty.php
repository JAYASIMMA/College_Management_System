<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'faculty') {
    header('Location: login.php?role=faculty');
    exit;
}
require_once '../includes/db.php';
$notices = $pdo->query('SELECT * FROM notices ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Notices</h2>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>Title</th><th>Content</th><th>Date</th></tr>
        <?php foreach($notices as $n): ?>
        <tr>
            <td><?=htmlspecialchars($n['title'])?></td>
            <td><?=htmlspecialchars($n['content'])?></td>
            <td><?=date('d M Y, H:i', strtotime($n['created_at']))?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/faculty.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 