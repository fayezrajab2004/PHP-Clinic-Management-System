<?php
require_once 'security.php';
require_role('admin');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../View/Register.php');
    exit;
}

// check csrf token
require_valid_csrf();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$phoneNumber = trim($_POST['phone_number'] ?? '');
$role = $_POST['role'] ?? '';
if (!in_array($role, ['doctor', 'pharmacist'], true)) {
    $_SESSION['error_message'] = 'Invalid role.';
    header('Location: ../View/Register.php');
    exit;
}

$table = $role === 'doctor' ? 'doctors' : 'pharmacists';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO {$table} (name, email, password, phone_number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $name, $email, $hashedPassword, $phoneNumber);
if ($stmt->execute()) {
    $_SESSION['sucess_message'] = 'Added Successfully';
} else {
    error_log('Registration failed: ' . $stmt->error);
    $_SESSION['error_message'] = 'Unable to register this account. The email may already exist.';
}
header('Location: ../View/Register.php');
exit;
