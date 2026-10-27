<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/assets/inc/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doc_login'])) {
    $number = trim((string)($_POST['doc_number'] ?? ''));
    $password = (string)($_POST['doc_pwd'] ?? '');
    $doctor = null;
    if ($number !== '' && $password !== '') {
        $stmt = $mysqli->prepare('SELECT doc_id, doc_number, doc_pwd FROM his_docs WHERE doc_number = ? LIMIT 1');
        if ($stmt) { $stmt->bind_param('s', $number); $stmt->execute(); $result = $stmt->get_result(); $doctor = $result ? $result->fetch_assoc() : null; $stmt->close(); }
    }
    [$valid, $upgrade] = $doctor ? verify_login_password($password, (string)$doctor['doc_pwd']) : [false, false];
    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['doc_id'] = (int)$doctor['doc_id'];
        $_SESSION['doc_number'] = (string)$doctor['doc_number'];
        if ($upgrade) upgrade_password_hash($mysqli, 'his_docs', 'doc_id', (int)$doctor['doc_id'], $password);
        header('Location: his_doc_dashboard.php'); exit;
    }
    $error = 'Access denied. Please check your credentials.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Doctor login | Hospify</title><link rel="stylesheet" href="assets/css/bootstrap.min.css"><link rel="stylesheet" href="../../assets2/css/hospify-modern.css"></head><body class="hospify-modern min-vh-100 d-flex align-items-center"><main class="container py-5"><div class="row justify-content-center"><div class="col-sm-10 col-md-7 col-lg-5"><section class="hm-card"><a class="hm-brand d-inline-flex align-items-center mb-4" href="../../index.php"><span class="hm-brand-mark">+</span>Hospify</a><p class="hm-eyebrow mb-2">Clinical workspace</p><h1 class="h2 fw-bold">Doctor sign in</h1><?php if ($error !== ''): ?><div class="alert alert-danger" role="alert"><?= h($error) ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label" for="doc-number">Doctor number</label><input class="form-control form-control-lg" id="doc-number" name="doc_number" type="text" autocomplete="username" required></div><div class="mb-4"><label class="form-label" for="doc-password">Password</label><input class="form-control form-control-lg" id="doc-password" name="doc_pwd" type="password" autocomplete="current-password" required></div><button class="btn hm-btn-primary btn-lg w-100" name="doc_login" type="submit">Sign in</button></form><div class="d-flex justify-content-between mt-4 small"><a href="his_doc_reset_pwd.php">Forgot password?</a><a href="../../index.php">Back to website</a></div></section></div></div></main></body></html>
