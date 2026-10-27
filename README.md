# Hospify

Hospify is a PHP/MySQL hospital management system for administrator and doctor workflows. This fork is being modernized incrementally without replacing the existing business modules.

## Verified modules

Repository inspection confirms administrator and doctor dashboards, patient registration/management/transfer/discharge, prescriptions, pharmacy categories and inventory, laboratory tests/results/vitals, equipment, employees, payroll, accounting, authentication, logout, and password-reset pages. Runtime completeness still requires a configured database.

## Stack

- PHP with server-rendered HTML
- MySQL/MariaDB
- HTML5, CSS3, JavaScript
- Existing Bootstrap and dashboard assets, with an incremental Hospify design layer

## Run locally with XAMPP

1. Install XAMPP with Apache, PHP, and MySQL/MariaDB.
2. Clone this repository into `htdocs/Hospify`.
3. Start Apache and MySQL from XAMPP.
4. Create a database named `hmisphp` in phpMyAdmin.
5. Import `DB/hms.sql`.
6. Review the existing local database configuration in `backend/admin/assets/inc/config.php` and `backend/doc/assets/inc/config.php`.
7. Open `http://localhost/Hospify/`.
8. Administrator login is at `backend/admin/`; doctor login is at `backend/doc/`.

Never put real credentials, patient records, API keys, or production data in this repository. Use `config/.env.example` as the documented starting point for future environment-based configuration.

## Modernization status

The five-phase modernization is being developed on `feature/hospify-next-modernization`:

1. **Audit and foundation:** verified audit, ignore rules, environment example, security helpers, and design tokens.
2. **UI system:** responsive public shell, reusable visual patterns, accessible navigation, and dashboard foundations.
3. **Authentication and authorization:** session hardening, CSRF coverage, legacy hash verification with upgrade to `password_hash()`.
4. **Existing modules:** improve real administrator and doctor workflows and then the verified clinical/operations modules.
5. **Verification and release:** PHP linting, database smoke tests, browser checks, navigation checks, and release documentation.

See [`docs/UPGRADE_AUDIT.md`](docs/UPGRADE_AUDIT.md) for verified findings and limitations.

## Testing

The repository currently has no automated test suite. Before release, run PHP syntax checks across modified files and test login, logout, protected-route access, forms, and database CRUD with synthetic data. MySQL and browser testing must be performed in a local XAMPP environment.

## Security limitations

This is a development modernization project, not a certified clinical system. Review access control, audit logging, backups, privacy requirements, deployment hardening, and applicable healthcare regulations before any real-world use. Existing modules still require a complete module-by-module security review.

## License

No explicit license is currently included. Add one before distributing the project.
