<?php
require_once '../Logic/security.php';
require_once '../Logic/connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check csrf token
    require_valid_csrf();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // get admin account
    $stmt = $conn->prepare('SELECT id,name,password FROM admins WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $admin['id'];
        $_SESSION['user_Name'] = $admin['name'];
        $_SESSION['role'] = 'admin';

        header('Location: Register.php');
        exit;
    }

    $_SESSION['error_message'] = 'Incorrect email or password.';
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login | Clinic Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Styles/main.css">
    </head>
    <body class="auth-body page-background admin-background">
        <main class="auth-card">
            <div class="text-center">
                <span class="brand-mark">
                    <i class="bi bi-shield-check"></i>
                </span>
                <h1 class="auth-title">Administrator Login</h1>
                <p class="auth-subtitle">Access staff account registration.</p>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger py-2" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= e($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <form method="POST" action="admin.php">
                <?= csrf_input() ?>
                <div class="mb-3">
                    <label class="form-label" for="email">Admin email</label>
                    <input class="form-control" id="email" type="email" name="email" placeholder="admin@example.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button class="btn btn-clinic w-100" type="submit">
                    <i class="bi bi-shield-lock me-2"></i>Continue
                </button>
            </form>
            <div class="border-top mt-4 pt-3 text-center">
                <a class="small text-secondary fw-semibold" href="login.php">
                    <i class="bi bi-arrow-left me-1"></i>Back to user login
                </a>
            </div>
        </main>
    </body>
</html>
