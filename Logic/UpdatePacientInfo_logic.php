<?php
require_once 'security.php';
require_role('patient');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update_pacient'])) {
    header('Location: ../View/patient_dashboard.php');
    exit;
}

// check csrf token
require_valid_csrf();

$patientId = (int) $_SESSION['user_id'];
$name = trim($_POST['new_name'] ?? '');
$email = trim($_POST['new_email'] ?? '');
$age = (int) ($_POST['new_age'] ?? 0);
$phoneNumber = trim($_POST['new_phone_number'] ?? '');
$newPassword = $_POST['new_password'] ?? '';

// update patient profile
if ($newPassword !== '') {
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('UPDATE patients SET name=?,email=?,age=?,phone_number=?,password=? WHERE id=?');
    $stmt->bind_param('ssissi', $name, $email, $age, $phoneNumber, $hash, $patientId);
} else {
    $stmt = $conn->prepare('UPDATE patients SET name=?,email=?,age=?,phone_number=? WHERE id=?');
    $stmt->bind_param('ssisi', $name, $email, $age, $phoneNumber, $patientId);
}

$stmt->execute();
$_SESSION['user_Name'] = $name;

header('Location: ../View/patient_dashboard.php?updated=true');
exit;
