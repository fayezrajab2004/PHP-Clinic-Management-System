<?php
require_once '../Logic/security.php';
require_role('doctor', 'login.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Patient | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background doctor-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="doctor_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <a class="btn btn-outline-secondary btn-sm" href="doctor_dashboard.php">
                    <i class="bi bi-grid me-1"></i>Dashboard</a>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header text-center">
                <h1 class="page-title">Add a new patient</h1>
                <p class="page-subtitle">Create the patient account and basic medical record.</p>
            </header>
            <section class="surface-card form-card">
                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= e($_SESSION['error_message']) ?>
                </div>
                <?php unset($_SESSION['error_message']); endif; ?>
                <form action="../Logic/AddNewPaientLogic.php" method="post">
                    <?= csrf_input() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="paient_name">Full name</label>
                            <input class="form-control" id="paient_name" type="text" name="paient_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="paient_email">Email address</label>
                            <input class="form-control" id="paient_email" type="email" name="paient_email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="paient_password">Temporary password</label>
                            <input class="form-control" id="paient_password" type="password" name="paient_password" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="paient_age">Age</label>
                            <input class="form-control" id="paient_age" type="number" name="paient_age" min="0" max="120">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label d-block">Gender</label>
                            <div class="d-flex gap-3 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" id="female" type="radio" value="Female" name="paient_gender" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="male" type="radio" value="Male" name="paient_gender" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="paient_problem">Medical problem</label>
                            <input class="form-control" id="paient_problem" type="text" name="paient_problem">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="paient_phone_number">Phone number</label>
                            <input class="form-control" id="paient_phone_number" type="text" name="paient_phone_number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="paient_entrance_date">Entrance date</label>
                            <input class="form-control" id="paient_entrance_date" type="date" name="paient_entrance_date">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit" name="add_paient">
                            <i class="bi bi-person-plus me-2"></i>Add patient</button>
                        <a class="btn btn-outline-secondary" href="doctor_dashboard.php">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
