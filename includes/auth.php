<?php
declare(strict_types=1);
require_once __DIR__ . '/security.php';

function verify_login_password(string $plain, string $stored): array
{
    return password_matches_and_needs_upgrade($plain, $stored);
}

function upgrade_password_hash(mysqli $db, string $table, string $idColumn, int $id, string $plain): void
{
    $allowed = ['his_admin' => 'ad_id', 'his_docs' => 'doc_id'];
    if (!isset($allowed[$table]) || $allowed[$table] !== $idColumn) return;
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    $sql = "UPDATE {$table} SET " . ($table === 'his_admin' ? 'ad_pwd' : 'doc_pwd') . " = ? WHERE {$idColumn} = ?";
    $stmt = $db->prepare($sql);
    if ($stmt) { $stmt->bind_param('si', $hash, $id); $stmt->execute(); $stmt->close(); }
}
