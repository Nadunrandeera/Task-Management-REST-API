<?php
session_start();
require '../config/database.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($name) || empty($email) || empty($password)) {
    die("All fields are required.");
}

// Check if email already exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    die("Email is already registered.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
if ($stmt->execute([$name, $email, $hashedPassword])) {
    header("Location: /task-manager/auth/login.php");
    exit;
} else {
    die("Registration failed.");
}
