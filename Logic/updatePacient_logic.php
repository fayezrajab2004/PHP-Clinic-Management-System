<?php
require_once 'security.php';
require_role('doctor');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update_pacient'])) {
    header('Location: ../View/ViewPacientScreen.php');
    exit;
}

// check csrf token
require_valid_csrf();

$patientId = (int) ($_POST['id'] ?? 0);
$doctorId = (int) $_SESSION['user_id'];
$name = trim($_POST['new_name'] ?? '');
$email = trim($_POST['new_email'] ?? '');
$age = (int) ($_POST['new_age'] ?? 0);
$gender = trim($_POST['new_gender'] ?? '');
$problem = trim($_POST['new_problem'] ?? '');
$entranceDate = ($_POST['new_entrance_date'] ?? '') ?: null;
$phoneNumber = trim($_POST['new_phone_number'] ?? '');
$newPassword = $_POST['new_password'] ?? '';

// update owned patient
if ($newPassword !== '') {
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('UPDATE patients p JOIN patients_doctor pd ON p.id=pd.patient_id SET p.name=?,p.email=?,p.age=?,p.gender=?,p.problem=?,p.entrance_date=?,p.phone_number=?,p.password=? WHERE p.id=? AND pd.doc_id=?');
    $stmt->bind_param('ssisssssii', $name, $email, $age, $gender, $problem, $entranceDate, $phoneNumber, $hash, $patientId, $doctorId);
} else {
    $stmt = $conn->prepare('UPDATE patients p JOIN patients_doctor pd ON p.id=pd.patient_id SET p.name=?,p.email=?,p.age=?,p.gender=?,p.problem=?,p.entrance_date=?,p.phone_number=? WHERE p.id=? AND pd.doc_id=?');
    $stmt->bind_param('ssissssii', $name, $email, $age, $gender, $problem, $entranceDate, $phoneNumber, $patientId, $doctorId);
}

$stmt->execute();

header('Location: ../View/ViewPacientScreen.php?updated=true');
exit;
