<?php
declare(strict_types=1);

function check_login(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['doc_id']) || !ctype_digit((string)$_SESSION['doc_id'])) {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) { $params = session_get_cookie_params(); setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']); }
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
