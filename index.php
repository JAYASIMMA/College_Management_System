<?php
// index.php - College Management System Landing Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="landing-bg">
    <div class="landing-container">
        <h1 class="landing-title"><i class="fas fa-university"></i> College Management System</h1>
        <div class="landing-cards">
            <a href="modules/login.php?role=admin" class="card card-admin">
                <i class="fas fa-user-shield"></i>
                <span>Admin Login</span>
            </a>
            <a href="modules/login.php?role=student" class="card card-student">
                <i class="fas fa-user-graduate"></i>
                <span>Student Login</span>
            </a>
            <a href="modules/login.php?role=faculty" class="card card-faculty">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Faculty Login</span>
            </a>
        </div>
        <div class="register-links">
            <a href="modules/register.php?role=student">Student Registration</a> |
            <a href="modules/register.php?role=faculty">Faculty Registration</a>
        </div>
    </div>
    <div class="footer">Created by Jayasimma D</div>
</body>
</html> 