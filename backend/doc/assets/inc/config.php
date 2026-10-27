<?php
declare(strict_types=1);

$envFile = dirname(__DIR__, 4) . '/config/.env';
$values = [];
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $values[trim($key)] = trim($value, " \t\n\r\0\x0B\"");
    }
}
$dbuser = $values['DB_USER'] ?? getenv('DB_USER') ?: 'root';
$dbpass = $values['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$host = $values['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
$port = (int)($values['DB_PORT'] ?? getenv('DB_PORT') ?: 3306);
$db = $values['DB_NAME'] ?? getenv('DB_NAME') ?: 'hmisphp';

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = new mysqli($host, $dbuser, $dbpass, $db, $port);
if ($mysqli->connect_errno) {
    error_log('Hospify database connection failed: ' . $mysqli->connect_error);
    http_response_code(503);
    exit('The application is temporarily unavailable. Please check the local database configuration.');
}
$mysqli->set_charset('utf8mb4');
