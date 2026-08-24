<?php
require_once '../Logic/security.php';
require_role('doctor', 'login.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Dashboard | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="page-background doctor-background">
        <nav class="navbar app-navbar">
            <div class="container-xl">
                <a class="navbar-brand" href="doctor_dashboard.php">
                    <i class="bi bi-heart-pulse-fill text-clinic me-2"></i>Clinic Management</a>
                <div class="d-flex align-items-center gap-3">
                    <span class="role-badge">
                        <i class="bi bi-person-badge me-1"></i>Doctor</span>
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
            <section class="welcome-panel">
                <h1>Welcome, Dr. <?= e($_SESSION['user_Name']) ?>
                </h1>
                <p>Manage your patients and treatment assignments from one clear workspace.</p>
            </section>
            <section class="row g-3 feature-grid">
                <div class="col-md-6">
                    <article class="surface-card feature-card">
                        <span class="feature-icon">
                            <i class="bi bi-person-plus"></i>
                        </span>
                        <h2>Add a new patient</h2>
                        <p>Create a patient account and connect it to your care list.</p>
                        <a class="btn btn-clinic align-self-start" href="AddNewPaientScreen.php">Add patient <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </article>
                </div>
                <div class="col-md-6">
                    <article class="surface-card feature-card">
                        <span class="feature-icon">
                            <i class="bi bi-people"></i>
                        </span>
                        <h2>Manage patients</h2>
                        <p>Review patient details, update records, and assign medication.</p>
                        <a class="btn btn-outline-clinic align-self-start" href="ViewPacientScreen.php">View patients <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </article>
                </div>
            </section>
        </main>
    </body>
</html>
