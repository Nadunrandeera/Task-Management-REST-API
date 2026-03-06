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

<h2 class="mb-4">Edit Task</h2>

<form action="../actions/task_update.php" method="POST" class="w-75">
    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"><?php echo htmlspecialchars($task['description']); ?></textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="pending" <?php if ($task['status'] === 'pending') echo 'selected'; ?>>Pending</option>
            <option value="in_progress" <?php if ($task['status'] === 'in_progress') echo 'selected'; ?>>In Progress</option>
            <option value="completed" <?php if ($task['status'] === 'completed') echo 'selected'; ?>>Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control" value="<?php echo htmlspecialchars($task['due_date']); ?>">
    </div>

    <button type="submit" class="btn btn-warning">Update Task</button>
</form>

<?php include '../includes/footer.php'; ?>
