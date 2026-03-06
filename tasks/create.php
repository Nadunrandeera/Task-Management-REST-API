<?php
require '../includes/auth.php';
requireLogin();
include '../includes/header.php';
?>

<h2 class="mb-4">Create Task</h2>

<form action="../actions/task_store.php" method="POST" class="w-75">
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save Task</button>
</form>

<?php include '../includes/footer.php'; ?>
