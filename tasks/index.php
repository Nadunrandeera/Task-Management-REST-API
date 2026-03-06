<?php
require '../includes/auth.php';
requireLogin();
require '../config/database.php';
include '../includes/header.php';

$userId = $_SESSION['user_id'];
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1);
$limit = 5;
$offset = ($page - 1) * $limit;

$where = "WHERE user_id = ? AND deleted_at IS NULL";
$params = [$userId];

if (!empty($status)) {
    $where .= " AND status = ?";
    $params[] = $status;
}

if (!empty($search)) {
    $where .= " AND title LIKE ?";
    $params[] = "%$search%";
}

$countSql = "SELECT COUNT(*) as total FROM tasks $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalTasks = $countStmt->fetch()['total'];
$totalPages = ceil($totalTasks / $limit);

$sql = "SELECT * FROM tasks $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tasks = $stmt->fetchAll();
?>

<h2 class="mb-4">My Tasks</h2>

<a href="/task-manager/tasks/create.php" class="btn btn-success mb-3">Add Task</a>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search by title">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">All Status</option>
            <option value="pending" <?php if ($status === 'pending') echo 'selected'; ?>>Pending</option>
            <option value="in_progress" <?php if ($status === 'in_progress') echo 'selected'; ?>>In Progress</option>
            <option value="completed" <?php if ($status === 'completed') echo 'selected'; ?>>Completed</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($tasks): ?>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <td><?php echo htmlspecialchars($task['due_date'] ?: '-'); ?></td>
                    <td>
                        <a href="/task-manager/tasks/view.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-info">View</a>
                        <a href="/task-manager/tasks/edit.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/task-manager/actions/task_delete.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No tasks found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status); ?>&search=<?php echo urlencode($search); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include '../includes/footer.php'; ?>
