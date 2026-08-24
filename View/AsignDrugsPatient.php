<?php
require_once '../Logic/security.php';
require_role('doctor', 'login.php');
require_once '../Logic/connectionDB.php';

// get owned patient
$patientId = (int) ($_GET['id'] ?? 0);
$doctorId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT p.name FROM patients p JOIN patients_doctor pd ON p.id=pd.patient_id WHERE p.id=? AND pd.doc_id=?');
$stmt->bind_param('ii', $patientId, $doctorId);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

if (!$patient) {
    http_response_code(403);
    exit('You cannot manage this patient.');
}

// get available drugs
$result = $conn->query('SELECT id,name FROM drugs ORDER BY name');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assign Drug | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background doctor-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="doctor_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <a class="btn btn-outline-secondary btn-sm" href="ViewPacientScreen.php">
                    <i class="bi bi-arrow-left me-1"></i>Patient list</a>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header text-center">
                <h1 class="page-title">Assign medication</h1>
                <p class="page-subtitle">Choose a drug for <?= e($patient['name']) ?>.</p>
            </header>
            <section class="surface-card form-card form-card-narrow">
                <form method="POST" action="../Logic/AsignDrugsPatient_Logic.php">
                    <?= csrf_input() ?>
                    <input type="hidden" name="id" value="<?= e($patientId) ?>">
                    <div>
                        <label class="form-label" for="drug_id">Medication</label>
                        <select class="form-select" id="drug_id" name="drug_id" required>
                            <option value="">Select a drug</option>
                            <?php while ($drug = $result->fetch_assoc()): ?>
                            <option value="<?= e($drug['id']) ?>">
                                <?= e($drug['name']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit">
                            <i class="bi bi-capsule me-2"></i>Assign drug</button>
                        <a class="btn btn-outline-secondary" href="ViewPacientScreen.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
