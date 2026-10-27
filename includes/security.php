<?php
declare(strict_types=1);

/** Shared security helpers for incremental adoption across Hospify pages. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function verify_csrf(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function legacy_password_hash(string $password): string
{
    return sha1(md5($password));
}

/** @return array{0: bool, 1: bool} [matches, shouldUpgrade] */
function password_matches_and_needs_upgrade(string $password, string $storedHash): array
{
    if (password_verify($password, $storedHash)) {
        return [true, password_needs_rehash($storedHash, PASSWORD_DEFAULT)];
    }

    $legacyMatches = hash_equals(legacy_password_hash($password), $storedHash);
    return [$legacyMatches, $legacyMatches];
}
