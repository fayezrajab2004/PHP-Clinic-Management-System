<?php
require_once 'security.php';
require_role('pharmacist');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add_Drugs'])) {
    header('Location: ../View/AddDrugs.php');
    exit;
}

// check csrf token
require_valid_csrf();

$name = trim($_POST['Drugs_name'] ?? '');
$dosage = trim($_POST['Dosage'] ?? '');
$productionDate = ($_POST['production_date'] ?? '') ?: null;
$expiryDate = ($_POST['Expiry_date'] ?? '') ?: null;

// add drug
$stmt = $conn->prepare('INSERT INTO drugs (name,dosage,production_date,expiry_date) VALUES (?,?,?,?)');
$stmt->bind_param('ssss', $name, $dosage, $productionDate, $expiryDate);

if ($stmt->execute()) {
    header('Location: ../View/pharmacist_dashboard.php?Add-Drugs=true');
    exit;
}

error_log('Drug creation failed: ' . $stmt->error);
$_SESSION['error_message'] = 'Unable to add the drug.';

header('Location: ../View/AddDrugs.php');
exit;
