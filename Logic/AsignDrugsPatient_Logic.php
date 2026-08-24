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
$drugId = (int) ($_POST['drug_id'] ?? 0);
$doctorId = (int) $_SESSION['user_id'];

// make sure the doctor owns this patient
$stmt = $conn->prepare('SELECT 1 FROM patients_doctor WHERE patient_id=? AND doc_id=?');
$stmt->bind_param('ii', $patientId, $doctorId);
$stmt->execute();

if (!$stmt->get_result()->fetch_row()) {
    http_response_code(403);
    exit('You cannot manage this patient.');
}

// assign drug
$stmt = $conn->prepare('INSERT IGNORE INTO patients_drugs (patient_id,drug_id) SELECT ?,id FROM drugs WHERE id=?');
$stmt->bind_param('ii', $patientId, $drugId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: ../View/ViewPacientScreen.php?addDrugs=true');
} else {
    header('Location: ../View/ViewPacientScreen.php?drugdsnotExisit=true');
}

exit;
