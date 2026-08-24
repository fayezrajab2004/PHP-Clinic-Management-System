<?php
require_once '../Logic/security.php';
require_role('pharmacist', 'login.php');
require_once '../Logic/connectionDB.php';

// get drug data
$id = (int) ($_GET['id'] ?? 0);
$stmt = $conn->prepare('SELECT id,name,dosage,production_date,expiry_date FROM drugs WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$drug = $stmt->get_result()->fetch_assoc();

if (!$drug) {
    http_response_code(404);
    exit('Drug not found.');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Drug | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background pharmacist-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="pharmacist_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <a class="btn btn-outline-secondary btn-sm" href="ViewDrugsScreen.php">
                    <i class="bi bi-arrow-left me-1"></i>Drug list</a>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header text-center">
                <h1 class="page-title">Update medication</h1>
                <p class="page-subtitle">Edit the details for <?= e($drug['name']) ?>.</p>
            </header>
            <section class="surface-card form-card form-card-narrow">
                <form action="../Logic/UpdateDrugs_logic.php" method="post">
                    <?= csrf_input() ?>
                    <input type="hidden" name="id" value="<?= e($drug['id']) ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="name">Drug name</label>
                            <input class="form-control" id="name" type="text" name="name" value="<?= e($drug['name']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="dosage">Dosage</label>
                            <input class="form-control" id="dosage" type="text" name="dosage" value="<?= e($drug['dosage']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="production_date">Production date</label>
                            <input class="form-control" id="production_date" type="date" name="production_date" value="<?= e($drug['production_date']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="expiry_date">Expiry date</label>
                            <input class="form-control" id="expiry_date" type="date" name="expiry_date" value="<?= e($drug['expiry_date']) ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit" name="update_Drugs">
                            <i class="bi bi-check-lg me-2"></i>Save changes</button>
                        <a class="btn btn-outline-secondary" href="ViewDrugsScreen.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
