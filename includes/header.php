<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/task-manager/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/task-manager/dashboard.php">Task Manager</a>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/task-manager/tasks/index.php" class="btn btn-sm btn-light">Tasks</a>
                <a href="/task-manager/actions/logout.php" class="btn btn-sm btn-danger">Logout</a>
            <?php else: ?>
                <a href="/task-manager/auth/login.php" class="btn btn-sm btn-light">Login</a>
                <a href="/task-manager/auth/register.php" class="btn btn-sm btn-success">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container">
