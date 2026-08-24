<?php
require_once '../Logic/security.php';
require_role('doctor', 'login.php');
require_once '../Logic/connectionDB.php';

// get doctor's patients
$doctorId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT p.id,p.name,p.email,p.age,p.gender,p.problem,p.entrance_date,p.phone_number FROM patients p JOIN patients_doctor pd ON p.id=pd.patient_id WHERE pd.doc_id=? ORDER BY p.id');
$stmt->bind_param('i', $doctorId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patients | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background doctor-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="doctor_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <div class="d-flex gap-2">
                    <a class="btn btn-clinic btn-sm" href="AddNewPaientScreen.php">
                        <i class="bi bi-person-plus me-1"></i>Add patient</a>
                    <a class="btn btn-outline-secondary btn-sm" href="doctor_dashboard.php">
                        <i class="bi bi-grid"></i>
                        <span class="d-none d-sm-inline ms-1">Dashboard</span>
                    </a>
                </div>
            </div>
        </nav>
        <main class="page-shell page-shell-wide">
            <header class="page-header">
                <h1 class="page-title">My patients</h1>
                <p class="page-subtitle">Review patient records and manage their medication.</p>
            </header>
            <?php if (($_GET['Added'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Patient added successfully.</div>
            <?php endif; ?>
            <?php if (($_GET['deleted'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Patient deleted successfully.</div>
            <?php endif; ?>
            <?php if (($_GET['updated'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Patient updated successfully.</div>
            <?php endif; ?>
            <?php if (($_GET['addDrugs'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Drug assigned successfully.</div>
            <?php endif; ?>
            <?php if (($_GET['drugdsnotExisit'] ?? '') === 'true'): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>Drug not found or already assigned.</div>
            <?php endif; ?>
            <section class="surface-card table-card">
                <div class="table-responsive">
                    <table class="table clinic-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Problem</th>
                                <th>Entrance date</th>
                                <th>Phone</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-semibold">
                                    <?= e($row['name']) ?>
                                </td>
                                <td>
                                    <?= e($row['email']) ?>
                                </td>
                                <td>
                                    <?= e($row['age']) ?>
                                </td>
                                <td>
                                    <?= e($row['gender']) ?>
                                </td>
                                <td>
                                    <?= e($row['problem']) ?>
                                </td>
                                <td>
                                    <?= e($row['entrance_date']) ?>
                                </td>
                                <td>
                                    <?= e($row['phone_number']) ?>
                                </td>
                                <td>
                                    <div class="table-actions justify-content-end">
                                        <a class="btn btn-outline-clinic" href="AsignDrugsPatient.php?id=<?= e($row['id']) ?>" title="Assign drug">
                                            <i class="bi bi-capsule"></i>
                                        </a>
                                        <a class="btn btn-outline-secondary" href="updatePacient.php?id=<?= e($row['id']) ?>" title="Edit patient">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="../Logic/deletePacient.php">
                                            <?= csrf_input() ?>
                                            <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                                            <button class="btn btn-outline-danger" type="submit" title="Delete patient">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
