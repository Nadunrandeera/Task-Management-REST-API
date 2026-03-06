<?php
require '../includes/auth.php';
requireLogin();
require '../config/database.php';

$userId = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$status = $_POST['status'];
$dueDate = !empty($_POST['due_date']) ? $_POST['due_date'] : null;

if (empty($title)) {
    die('Title is required.');
}

$stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, status, due_date) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$userId, $title, $description, $status, $dueDate]);

header("Location: /task-manager/tasks/index.php");
exit;
