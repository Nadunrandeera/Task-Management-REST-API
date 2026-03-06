<?php
session_start();

header('Content-Type: application/json');

function requireApiLogin()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized. Please log in first.'
        ]);
        exit;
    }
}
