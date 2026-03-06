<?php
require '../config/database.php';
require 'auth.php';

requireApiLogin();

$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Valid task id is required.'
    ]);
    exit;
}

$taskStmt = $pdo->prepare("
    SELECT id, user_id, title, description, status, due_date, created_at, updated_at
    FROM tasks
    WHERE id = ? AND user_id = ? AND deleted_at IS NULL
");
$taskStmt->execute([$id, $userId]);
$task = $taskStmt->fetch();

if (!$task) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Task not found.'
    ]);
    exit;
}

if ($method === 'GET') {
    echo json_encode([
        'success' => true,
        'data' => $task
    ]);
    exit;
}

if ($method === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    $title = trim($input['title'] ?? '');
    $description = trim($input['description'] ?? '');
    $status = $input['status'] ?? 'pending';
    $dueDate = !empty($input['due_date']) ? $input['due_date'] : null;

    $allowedStatuses = ['pending', 'in_progress', 'completed'];

    if (empty($title)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Title is required.'
        ]);
        exit;
    }

    if (!in_array($status, $allowedStatuses, true)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid status.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE tasks
        SET title = ?, description = ?, status = ?, due_date = ?, updated_at = CURRENT_TIMESTAMP
        WHERE id = ? AND user_id = ? AND deleted_at IS NULL
    ");
    $stmt->execute([$title, $description, $status, $dueDate, $id, $userId]);

    $updatedStmt = $pdo->prepare("
        SELECT id, title, description, status, due_date, created_at, updated_at
        FROM tasks
        WHERE id = ? AND user_id = ? AND deleted_at IS NULL
    ");
    $updatedStmt->execute([$id, $userId]);
    $updatedTask = $updatedStmt->fetch();

    echo json_encode([
        'success' => true,
        'message' => 'Task updated successfully.',
        'data' => $updatedTask
    ]);
    exit;
}

if ($method === 'DELETE') {
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET deleted_at = CURRENT_TIMESTAMP
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $userId]);

    echo json_encode([
        'success' => true,
        'message' => 'Task soft deleted successfully.'
    ]);
    exit;
}

http_response_code(405);
echo json_encode([
    'success' => false,
    'message' => 'Method not allowed.'
]);
