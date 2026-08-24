<?php
require_once '../Logic/security.php';
require_role('doctor', 'login.php');
require_once '../Logic/connectionDB.php';

// get owned patient
$patientId = (int) ($_GET['id'] ?? 0);
$doctorId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT p.id,p.name,p.email,p.age,p.gender,p.problem,p.entrance_date,p.phone_number FROM patients p JOIN patients_doctor pd ON p.id=pd.patient_id WHERE p.id=? AND pd.doc_id=?');
$stmt->bind_param('ii', $patientId, $doctorId);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

if (!$patient) {
    http_response_code(403);
    exit('You cannot manage this patient.');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Patient | Clinic Management</title>
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
                <h1 class="page-title">Update patient</h1>
                <p class="page-subtitle">Edit the account and medical details for <?= e($patient['name']) ?>.</p>
            </header>
            <section class="surface-card form-card">
                <form action="../Logic/updatePacient_logic.php" method="post">
                    <?= csrf_input() ?>
                    <input type="hidden" name="id" value="<?= e($patient['id']) ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="new_name">Full name</label>
                            <input class="form-control" id="new_name" type="text" name="new_name" value="<?= e($patient['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="new_email">Email address</label>
                            <input class="form-control" id="new_email" type="email" name="new_email" value="<?= e($patient['email']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_age">Age</label>
                            <input class="form-control" id="new_age" type="number" name="new_age" value="<?= e($patient['age']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_gender">Gender</label>
                            <input class="form-control" id="new_gender" type="text" name="new_gender" value="<?= e($patient['gender']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_entrance_date">Entrance date</label>
                            <input class="form-control" id="new_entrance_date" type="date" name="new_entrance_date" value="<?= e($patient['entrance_date']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="new_problem">Medical problem</label>
                            <input class="form-control" id="new_problem" type="text" name="new_problem" value="<?= e($patient['problem']) ?>">
                        </div>
                        <div class="col-md-6">
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
                            <i class="bi bi-check-lg me-2"></i>Save changes</button>
                        <a class="btn btn-outline-secondary" href="ViewPacientScreen.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
