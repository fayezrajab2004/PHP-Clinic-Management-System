<?php
require_once 'security.php';
require_role('pharmacist');
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

// check csrf token
require_valid_csrf();

$drugId = (int) ($_POST['id'] ?? 0);

// delete drug
$stmt = $conn->prepare('DELETE FROM drugs WHERE id=?');
$stmt->bind_param('i', $drugId);
$stmt->execute();

header('Location: ../View/ViewDrugsScreen.php?deleted=true');
exit;
