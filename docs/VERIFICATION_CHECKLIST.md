# Hospify Verification Checklist

## Completed by repository inspection

- [x] Dedicated modernization branch created from `main`
- [x] Existing repository structure inspected
- [x] Audit documented in `docs/UPGRADE_AUDIT.md`
- [x] `.gitignore` added
- [x] Environment example added without real credentials
- [x] Public homepage redesigned without fabricated claims or patient data
- [x] Admin and doctor login handlers migrated to `password_verify()` with legacy fallback
- [x] Successful login regenerates the session ID
- [x] Login forms include CSRF tokens and validate them
- [x] Admin and doctor route guards reject missing or malformed session IDs
- [x] Admin and doctor logout handlers invalidate session data and cookies
- [x] Shared admin/doctor dashboard head assets updated with the modern design layer

## Not executable in the connected repository environment

- PHP CLI syntax checks
- MySQL import and schema validation
- Login/logout smoke tests with synthetic users
- CRUD tests for patient, pharmacy, laboratory, payroll, accounting, prescription, and equipment modules
- Browser responsive testing and console inspection
- Production security, privacy, backup, and clinical compliance verification

## Local commands

From the repository root, with PHP installed:

```bash
find . -name '*.php' -print0 | xargs -0 -n1 php -l
```

Import `DB/hms.sql` into a local `hmisphp` database, configure `config/.env`, then test:

1. Public homepage and both login links.
2. Legacy-hash administrator and doctor users; confirm successful login upgrades their stored hash.
3. Invalid credentials and invalid/missing CSRF tokens.
4. Protected URLs before login.
5. Logout followed by browser back and direct protected URL access.
6. Existing CRUD workflows using synthetic data only.
