<?php
require_once '../Logic/security.php';
require_role('patient', 'login.php');
require_once '../Logic/connectionDB.php';

// get assigned drugs
$patientId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT d.name,d.dosage,d.production_date,d.expiry_date FROM drugs d JOIN patients_drugs pd ON d.id=pd.drug_id WHERE pd.patient_id=? ORDER BY d.name');
$stmt->bind_param('i', $patientId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Medication | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background patient-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="patient_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <a class="btn btn-outline-secondary btn-sm" href="patient_dashboard.php">
                    <i class="bi bi-grid me-1"></i>Dashboard</a>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header">
                <h1 class="page-title">My assigned medication</h1>
                <p class="page-subtitle">Medication currently connected to your patient record.</p>
            </header>
            <section class="surface-card table-card">
                <div class="table-responsive">
                    <table class="table clinic-table">
                        <thead>
                            <tr>
                                <th>Drug name</th>
                                <th>Dosage</th>
                                <th>Production date</th>
                                <th>Expiry date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="bi bi-capsule text-clinic me-2"></i>
                                    <?= e($row['name']) ?>
                                </td>
                                <td>
                                    <?= e($row['dosage']) ?>
                                </td>
                                <td>
                                    <?= e($row['production_date']) ?>
                                </td>
                                <td>
                                    <?= e($row['expiry_date']) ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </body>
</html>
