<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /task-manager/dashboard.php");
    exit;
}

header("Location: /task-manager/auth/login.php");
exit;
