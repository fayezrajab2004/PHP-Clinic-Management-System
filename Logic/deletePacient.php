<?php
require_once 'security.php';
require_role('doctor');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

// check csrf token
require_valid_csrf();

$patientId = (int) ($_POST['id'] ?? 0);
$doctorId = (int) $_SESSION['user_id'];

// delete owned patient
$stmt = $conn->prepare('DELETE p FROM patients p JOIN patients_doctor pd ON p.id=pd.patient_id WHERE p.id=? AND pd.doc_id=?');
$stmt->bind_param('ii', $patientId, $doctorId);
$stmt->execute();

header('Location: ../View/ViewPacientScreen.php?deleted=true');
exit;
