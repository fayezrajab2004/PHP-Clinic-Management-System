<?php
require_once '../Logic/security.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="auth-body page-background auth-background">
        <main class="auth-card">
            <div class="text-center">
                <span class="brand-mark">
                    <i class="bi bi-heart-pulse"></i>
                </span>
                <h1 class="auth-title">Clinic Management</h1>
                <p class="auth-subtitle">Sign in to access your healthcare dashboard.</p>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger py-2" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= e($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['sucess_message'])): ?>
            <div class="alert alert-success py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= e($_SESSION['sucess_message']) ?>
            </div>
            <?php unset($_SESSION['sucess_message']); ?>
            <?php endif; ?>
            <form method="POST" action="../Logic/loginHandleLogic.php">
                <?= csrf_input() ?>
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-envelope text-secondary"></i>
                        </span>
                        <input class="form-control" id="email" type="email" name="email" placeholder="name@example.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-lock text-secondary"></i>
                        </span>
                        <input class="form-control" id="password" type="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <button class="btn btn-clinic w-100" type="submit" name="Login" value="Login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
                </button>
            </form>
            <div class="border-top mt-4 pt-3 text-center">
                <a class="small text-clinic fw-semibold" href="admin.php">
                    <i class="bi bi-shield-lock me-1"></i>Administrator access
                </a>
            </div>
        </main>
    </body>
</html>
