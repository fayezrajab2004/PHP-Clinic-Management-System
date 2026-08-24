<?php
require_once 'security.php';
require_role('doctor');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add_paient'])) {
    header('Location: ../View/AddNewPaientScreen.php');
    exit;
}

// check csrf token
require_valid_csrf();

$name = trim($_POST['paient_name'] ?? '');
$email = trim($_POST['paient_email'] ?? '');
$password = $_POST['paient_password'] ?? '';
$age = (int) ($_POST['paient_age'] ?? 0);
$gender = $_POST['paient_gender'] ?? '';
$problem = trim($_POST['paient_problem'] ?? '');
$entranceDate = ($_POST['paient_entrance_date'] ?? '') ?: null;
$phoneNumber = trim($_POST['paient_phone_number'] ?? '');
$doctorId = (int) $_SESSION['user_id'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// create patient and relationship together
$conn->begin_transaction();

try {
    $stmt = $conn->prepare('INSERT INTO patients (name,email,password,age,gender,problem,entrance_date,phone_number) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->bind_param('sssissss', $name, $email, $hashedPassword, $age, $gender, $problem, $entranceDate, $phoneNumber);
    $stmt->execute();

    $patientId = $conn->insert_id;
    $stmt->close();

    $stmt = $conn->prepare('INSERT INTO patients_doctor (patient_id,doc_id) VALUES (?,?)');
    $stmt->bind_param('ii', $patientId, $doctorId);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    header('Location: ../View/ViewPacientScreen.php?Added=true');
    exit;
} catch (Throwable $exception) {
    $conn->rollback();
    error_log('Patient creation failed: ' . $exception->getMessage());
    $_SESSION['error_message'] = 'Unable to add the patient.';

    header('Location: ../View/AddNewPaientScreen.php');
    exit;
}
