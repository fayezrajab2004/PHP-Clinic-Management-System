<?php
require_once 'security.php';
require_role('pharmacist');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update_Drugs'])) {
    header('Location: ../View/ViewDrugsScreen.php');
    exit;
}

// check csrf token
require_valid_csrf();

$id = (int) ($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$dosage = trim($_POST['dosage'] ?? '');
$productionDate = ($_POST['production_date'] ?? '') ?: null;
$expiryDate = ($_POST['expiry_date'] ?? '') ?: null;

// update drug
$stmt = $conn->prepare('UPDATE drugs SET name=?,dosage=?,production_date=?,expiry_date=? WHERE id=?');
$stmt->bind_param('ssssi', $name, $dosage, $productionDate, $expiryDate, $id);
$stmt->execute();

header('Location: ../View/ViewDrugsScreen.php?updateDrugs=true');
exit;
