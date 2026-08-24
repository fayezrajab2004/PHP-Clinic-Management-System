<?php
require_once '../Logic/security.php';
require_role('pharmacist', 'login.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Drug | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background pharmacist-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="pharmacist_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <a class="btn btn-outline-secondary btn-sm" href="pharmacist_dashboard.php">
                    <i class="bi bi-grid me-1"></i>Dashboard</a>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header text-center">
                <h1 class="page-title">Add medication</h1>
                <p class="page-subtitle">Enter the drug and dosage information below.</p>
            </header>
            <section class="surface-card form-card form-card-narrow">
                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= e($_SESSION['error_message']) ?>
                </div>
                <?php unset($_SESSION['error_message']); endif; ?>
                <form action="../Logic/addDrugsLogic.php" method="post">
                    <?= csrf_input() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="drug_name">Drug name</label>
                            <input class="form-control" id="drug_name" type="text" name="Drugs_name" placeholder="Example: Paracetamol" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="dosage">Dosage</label>
                            <input class="form-control" id="dosage" type="text" name="Dosage" placeholder="Example: 500 mg as needed" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="production_date">Production date</label>
                            <input class="form-control" id="production_date" type="date" name="production_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="expiry_date">Expiry date</label>
                            <input class="form-control" id="expiry_date" type="date" name="Expiry_date">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit" name="add_Drugs">
                            <i class="bi bi-plus-lg me-2"></i>Add drug</button>
                        <a class="btn btn-outline-secondary" href="pharmacist_dashboard.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
