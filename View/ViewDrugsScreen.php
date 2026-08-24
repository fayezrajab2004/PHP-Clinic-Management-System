<?php
require_once '../Logic/security.php';
require_role('pharmacist', 'login.php');
require_once '../Logic/connectionDB.php';

// get all drugs
$result = $conn->query('SELECT id,name,dosage,production_date,expiry_date FROM drugs ORDER BY id');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medication | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background pharmacist-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="pharmacist_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <div class="d-flex gap-2">
                    <a class="btn btn-clinic btn-sm" href="AddDrugs.php">
                        <i class="bi bi-plus-lg me-1"></i>Add drug</a>
                    <a class="btn btn-outline-secondary btn-sm" href="pharmacist_dashboard.php">
                        <i class="bi bi-grid"></i>
                        <span class="d-none d-sm-inline ms-1">Dashboard</span>
                    </a>
                </div>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header">
                <h1 class="page-title">Medication inventory</h1>
                <p class="page-subtitle">Review and maintain all clinic medication records.</p>
            </header>
            <?php if (($_GET['deleted'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Drug deleted successfully.</div>
            <?php endif; ?>
            <?php if (($_GET['updateDrugs'] ?? '') === 'true'): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Drug updated successfully.</div>
            <?php endif; ?>
            <section class="surface-card table-card">
                <div class="table-responsive">
                    <table class="table clinic-table">
                        <thead>
                            <tr>
                                <th>Drug name</th>
                                <th>Dosage</th>
                                <th>Production date</th>
                                <th>Expiry date</th>
                                <th class="text-end">Actions</th>
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
                                <td>
                                    <div class="table-actions justify-content-end">
                                        <a class="btn btn-outline-secondary" href="updateDrugs.php?id=<?= e($row['id']) ?>">
                                            <i class="bi bi-pencil me-1"></i>Edit</a>
                                        <form method="POST" action="../Logic/deleteDrugs.php">
                                            <?= csrf_input() ?>
                                            <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                                            <button class="btn btn-outline-danger" type="submit">
                                                <i class="bi bi-trash me-1"></i>Delete</button>
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
