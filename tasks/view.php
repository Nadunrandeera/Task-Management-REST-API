<?php
require '../includes/auth.php';
requireLogin();
require '../config/database.php';
include '../includes/header.php';

$userId = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ? AND deleted_at IS NULL");
$stmt->execute([$id, $userId]);
$task = $stmt->fetch();

if (!$task) {
    die('Task not found.');
}
?>

<h2 class="mb-4">Task Details</h2>

<div class="card">
    <div class="card-body">
        <h4><?php echo htmlspecialchars($task['title']); ?></h4>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description'] ?: 'No description'); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
        <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['due_date'] ?: '-'); ?></p>
        <a href="/task-manager/tasks/index.php" class="btn btn-secondary">Back</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
