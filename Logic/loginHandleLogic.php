<?php
require_once 'security.php';
require_once 'connectionDB.php';

// only allow the login form
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['Login'])) {
    header('Location: ../View/login.php');
    exit;
}

// check csrf token
require_valid_csrf();

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$accounts = [
    ['table'=>'patients', 'role'=>'patient', 'dashboard'=>'patient_dashboard.php'],
    ['table'=>'doctors', 'role'=>'doctor', 'dashboard'=>'doctor_dashboard.php'],
    ['table'=>'pharmacists', 'role'=>'pharmacist', 'dashboard'=>'pharmacist_dashboard.php'],
];

foreach ($accounts as $account) {
    $sql = "SELECT id, name, password FROM {$account['table']} WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($user && password_verify($password, $user['password'])) {
        // save logged-in user
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_Name'] = $user['name'];
        $_SESSION['role'] = $account['role'];
        header('Location: ../View/' . $account['dashboard']);
        exit;
    }
}

$_SESSION['error_message'] = 'Incorrect email or password.';
header('Location: ../View/login.php');
exit;
