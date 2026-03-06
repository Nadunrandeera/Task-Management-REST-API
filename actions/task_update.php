<?php
require '../includes/auth.php';
requireLogin();
require '../config/database.php';

$userId = $_SESSION['user_id'];
$id = $_POST['id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$status = $_POST['status'];
$dueDate = !empty($_POST['due_date']) ? $_POST['due_date'] : null;

$stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, due_date = ? WHERE id = ? AND user_id = ? AND deleted_at IS NULL");
$stmt->execute([$title, $description, $status, $dueDate, $id, $userId]);

header("Location: /task-manager/tasks/index.php");
exit;
