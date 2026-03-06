<?php
require '../includes/auth.php';
requireLogin();
require '../config/database.php';

$userId = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("UPDATE tasks SET deleted_at = NOW() WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $userId]);

header("Location: /task-manager/tasks/index.php");
exit;
