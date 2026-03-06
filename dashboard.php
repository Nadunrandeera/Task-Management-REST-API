<?php
require 'includes/auth.php';
requireLogin();
include 'includes/header.php';
?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
<p class="mt-3">
    <a href="/task-manager/tasks/index.php" class="btn btn-primary">Manage Tasks</a>
</p>

<?php include 'includes/footer.php'; ?>
