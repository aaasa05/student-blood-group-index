<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
    <link rel="stylesheet" href="css/styles.css">
    <?php
    require('db_connection.php');

    session_start();
    if (empty($_SESSION['isLoggedIn'])) {
        header('Location: admin_login.php');
    }
    ?>
</head>
<body>
    <!-- Topbar -->
    <div class="topbar">
        <h1>Blood Group Management System</h1>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php">Dashboard</a>
        <a href="admin_list.php">Admins</a>
        <a href="dept_list.php">Departments</a>
        <a href="student_list.php">Students</a>
    </div>
    <!-- Main Content -->
    <div class="main-content">