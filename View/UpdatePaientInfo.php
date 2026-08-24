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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile | Clinic Management</title>
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
            <header class="page-header text-center">
                <h1 class="page-title">My profile</h1>
                <p class="page-subtitle">Keep your contact and account information up to date.</p>
            </header>
            <section class="surface-card form-card form-card-narrow">
                <form action="../Logic/UpdatePacientInfo_logic.php" method="post">
                    <?= csrf_input() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="new_name">Full name</label>
                            <input class="form-control" id="new_name" type="text" name="new_name" value="<?= e($patient['name']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="new_email">Email address</label>
                            <input class="form-control" id="new_email" type="email" name="new_email" value="<?= e($patient['email']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_age">Age</label>
                            <input class="form-control" id="new_age" type="number" name="new_age" value="<?= e($patient['age']) ?>">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" for="new_phone_number">Phone number</label>
                            <input class="form-control" id="new_phone_number" type="text" name="new_phone_number" value="<?= e($patient['phone_number']) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="new_password">New password <span class="text-secondary fw-normal">(optional)</span>
                            </label>
                            <input class="form-control" id="new_password" type="password" name="new_password" placeholder="Leave blank to keep the current password">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit" name="update_pacient">
                            <i class="bi bi-check-lg me-2"></i>Save profile</button>
                        <a class="btn btn-outline-secondary" href="patient_dashboard.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
