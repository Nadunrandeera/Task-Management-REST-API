<?php
require '../config/database.php';
require 'auth.php';

requireApiLogin();

$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
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

    $countSql = "SELECT COUNT(*) AS total FROM tasks $where";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $total = (int) $countStmt->fetch()['total'];

    $sql = "SELECT id, title, description, status, due_date, created_at, updated_at 
            FROM tasks
            $where
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $tasks,
        'pagination' => [
            'current_page' => $page,
            'per_page' => $limit,
            'total' => $total,
            'total_pages' => ceil($total / $limit)
        ]
    ]);
    exit;
}

if ($method === 'POST') {
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
        INSERT INTO tasks (user_id, title, description, status, due_date)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $title, $description, $status, $dueDate]);

    $taskId = $pdo->lastInsertId();

    $taskStmt = $pdo->prepare("
        SELECT id, title, description, status, due_date, created_at, updated_at
        FROM tasks
        WHERE id = ? AND user_id = ?
    ");
    $taskStmt->execute([$taskId, $userId]);
    $task = $taskStmt->fetch();

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Task created successfully.',
        'data' => $task
    ]);
    exit;
}

http_response_code(405);
echo json_encode([
    'success' => false,
    'message' => 'Method not allowed.'
]);
