<?php
require_once '../Logic/security.php';
require_role('admin', 'login.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Staff | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background admin-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="Register.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="role-badge">
                        <i class="bi bi-shield-check me-1"></i>Admin</span>
                    <form class="logout-form" method="POST" action="../Logic/logout.php">
                        <?= csrf_input() ?>
                        <button class="btn btn-outline-secondary btn-sm" type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <main class="page-shell">
            <header class="page-header text-center">
                <h1 class="page-title">Register a staff account</h1>
                <p class="page-subtitle">Create a secure account for a doctor or pharmacist.</p>
            </header>
            <section class="surface-card form-card form-card-narrow">
                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= e($_SESSION['error_message']) ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['sucess_message'])): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= e($_SESSION['sucess_message']) ?>
                </div>
                <?php unset($_SESSION['sucess_message']); ?>
                <?php endif; ?>
                <form method="POST" action="../Logic/RegisterHandleLogic.php">
                    <?= csrf_input() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="name">Full name</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Enter full name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="email">Email address</label>
                            <input class="form-control" id="email" type="email" name="email" placeholder="name@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" type="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone_number">Phone number</label>
                            <input class="form-control" id="phone_number" type="text" name="phone_number" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="role">Account role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="doctor">Doctor</option>
                                <option value="pharmacist">Pharmacist</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-clinic px-4" type="submit">
                            <i class="bi bi-person-plus me-2"></i>Register account</button>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
