<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/assets/inc/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $email = filter_var(trim((string)($_POST['ad_email'] ?? '')), FILTER_VALIDATE_EMAIL);
        $password = (string)($_POST['ad_pwd'] ?? '');
        $admin = null;
        if ($email && $password !== '') {
            $stmt = $mysqli->prepare('SELECT ad_id, ad_email, ad_pwd FROM his_admin WHERE ad_email = ? LIMIT 1');
            if ($stmt) { $stmt->bind_param('s', $email); $stmt->execute(); $result = $stmt->get_result(); $admin = $result ? $result->fetch_assoc() : null; $stmt->close(); }
        }
        [$valid, $upgrade] = $admin ? verify_login_password($password, (string)$admin['ad_pwd']) : [false, false];
        if ($valid) {
            session_regenerate_id(true);
            $_SESSION['ad_id'] = (int)$admin['ad_id'];
            $_SESSION['ad_email'] = (string)$admin['ad_email'];
            if ($upgrade) upgrade_password_hash($mysqli, 'his_admin', 'ad_id', (int)$admin['ad_id'], $password);
            header('Location: his_admin_dashboard.php'); exit;
        }
        $error = 'Access denied. Please check your credentials.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Administrator login | Hospify</title><link rel="stylesheet" href="assets/css/bootstrap.min.css"><link rel="stylesheet" href="../../assets2/css/hospify-modern.css"></head><body class="hospify-modern min-vh-100 d-flex align-items-center"><main class="container py-5"><div class="row justify-content-center"><div class="col-sm-10 col-md-7 col-lg-5"><section class="hm-card"><a class="hm-brand d-inline-flex align-items-center mb-4" href="../../index.php"><span class="hm-brand-mark">+</span>Hospify</a><p class="hm-eyebrow mb-2">Secure workspace</p><h1 class="h2 fw-bold">Administrator sign in</h1><?php if ($error !== ''): ?><div class="alert alert-danger" role="alert"><?= h($error) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><div class="mb-3"><label class="form-label" for="admin-email">Email address</label><input class="form-control form-control-lg" id="admin-email" name="ad_email" type="email" autocomplete="username" required></div><div class="mb-4"><label class="form-label" for="admin-password">Password</label><input class="form-control form-control-lg" id="admin-password" name="ad_pwd" type="password" autocomplete="current-password" required></div><button class="btn hm-btn-primary btn-lg w-100" name="admin_login" type="submit">Sign in</button></form><div class="d-flex justify-content-between mt-4 small"><a href="his_admin_pwd_reset.php">Forgot password?</a><a href="../../index.php">Back to website</a></div></section></div></div></main></body></html>
