<?php
require_once '../Logic/security.php';
require_role('patient', 'login.php');
require_once '../Logic/connectionDB.php';

// get patient data
$id = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT name,email,age,phone_number FROM patients WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

if (!$patient) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Dashboard | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background patient-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="patient_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="role-badge">
                        <i class="bi bi-person-heart me-1"></i>Patient</span>
                    <span class="navbar-user-name small text-secondary">
                        <?= e($_SESSION['user_Name']) ?>
                    </span>
                    <form class="logout-form" method="POST" action="../Logic/logout.php">
                        <?= csrf_input() ?>
                        <button class="btn btn-outline-secondary btn-sm" type="submit">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline ms-1">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <main class="page-shell">
            <?php if (($_GET['updated'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Profile updated successfully.</div>
            <?php endif; ?>
            <section class="welcome-panel">
                <h1>Hello, <?= e($_SESSION['user_Name']) ?>
                </h1>
                <p>View your assigned medication and keep your personal details current.</p>
            </section>
            <section class="row g-3 feature-grid">
                <div class="col-md-6">
                    <article class="surface-card feature-card">
                        <span class="feature-icon">
                            <i class="bi bi-capsule-pill"></i>
                        </span>
                        <h2>Assigned medication</h2>
                        <p>Review the medication currently assigned to your account.</p>
                        <a class="btn btn-clinic align-self-start" href="ViewPacintDrugs.php">View medication <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </article>
                </div>
                <div class="col-md-6">
                    <article class="surface-card feature-card">
                        <span class="feature-icon">
                            <i class="bi bi-person-gear"></i>
                        </span>
                        <h2>Personal information</h2>
                        <p>Update your name, contact details, or account password.</p>
                        <a class="btn btn-outline-clinic align-self-start" href="UpdatePaientInfo.php">Update profile <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </article>
                </div>
            </section>
        </main>
    </body>
</html>
