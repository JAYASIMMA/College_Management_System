<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?role=admin');
    exit;
}
require_once '../includes/db.php';
$msg = '';
if (isset($_POST['add_notice'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    if ($title && $content) {
        $stmt = $pdo->prepare('INSERT INTO notices (title, content) VALUES (?, ?)');
        $stmt->execute([$title, $content]);
        $msg = 'Notice posted!';
    } else {
        $msg = 'All fields required.';
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM notices WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    $msg = 'Notice deleted!';
}
$notices = $pdo->query('SELECT * FROM notices ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Notices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
    <h2>Manage Notices</h2>
    <?php if($msg): ?><div class="success-msg"><?=$msg?></div><?php endif; ?>
    <form method="post" class="form" style="max-width:400px;">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" required style="min-height:80px;width:100%;border-radius:8px;"></textarea>
        </div>
        <button type="submit" name="add_notice" class="btn-primary">Post Notice</button>
    </form>
    <h3>All Notices</h3>
    <table style="width:100%;background:#fff;border-radius:8px;box-shadow:0 1px 6px #1e3a8a11;">
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Date</th><th>Action</th></tr>
        <?php foreach($notices as $n): ?>
        <tr>
            <td><?=$n['id']?></td>
            <td><?=htmlspecialchars($n['title'])?></td>
            <td><?=htmlspecialchars($n['content'])?></td>
            <td><?=date('d M Y, H:i', strtotime($n['created_at']))?></td>
            <td><a href="?delete=<?=$n['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:1.2rem;"><a href="../dashboard/admin.php">&larr; Back to Dashboard</a></div>
</div>
</body>
</html> 