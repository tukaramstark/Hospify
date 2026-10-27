# Hospify Modernization Audit

**Audit status:** Phase 0 completed from repository inspection on 2026-10-27.
**Repository:** `tukaramstark/Hospify`
**Scope:** Verified repository structure and representative application entry points. Database execution and browser testing were not available during this audit.

## 1. Existing architecture

Hospify is a server-rendered PHP application backed by MySQL/MariaDB. Public entry points are `index.php` and `index2.php`. Authenticated code is separated into `backend/admin` and `backend/doc`, each with its own assets and shared includes. Database access currently uses duplicated `mysqli` configuration files.

The application is page-oriented: PHP pages combine request processing, database queries, and HTML rendering. Modernization will be incremental and preserve existing workflows.

## 2. Verified functional modules

Repository inspection confirms administrator and doctor workflows for:

- Administrator and doctor dashboards and accounts
- Patient registration, management, viewing, transfer, and discharge
- Prescriptions and pharmaceutical inventory
- Pharmacy categories
- Laboratory tests, results, and patient vitals
- Equipment inventory
- Employee and payroll workflows
- Accounting records and payable/receivable entries
- Authentication, logout, and password reset pages

File presence does not prove that every workflow is complete; runtime verification requires a configured database.

## 3. Database tables and relationships

`DB/hms.sql` is the verified schema source. Inspected code references `his_admin`, `his_docs`, and patient, pharmacy, laboratory, prescription, payroll, employee, accounting, and equipment data sets. The SQL dump remains the source of truth for exact columns and relationships.

No destructive schema change is planned. Future changes must be additive, versioned, backed up, and documented with rollback notes.

## 4. Confirmed bugs and security concerns

- Administrator and doctor logins use legacy `sha1(md5(password))` hashing.
- Login handlers assign session identifiers before confirming authentication success.
- Session IDs are not regenerated after successful authentication in inspected handlers.
- Database credentials are hard-coded in duplicated `config.php` files.
- Route guards use `strlen($_SESSION[...])` and are not centralized.
- CSRF protection was not present in inspected login handlers.
- Validation and output escaping are inconsistent across the page-oriented codebase.
- Database failure handling requires safer production behavior.
- The public site contains placeholder contact values and overlapping entry points.
- The repository had no `.gitignore` before this modernization branch.
- `assets2/images/Thumbs.db` is an unnecessary generated file.

## 5. Duplicate or obsolete assets

Two public asset families (`assets` and `assets2`) and separate admin/doctor vendor bundles exist. Bootstrap 4, Font Awesome 4, jQuery-era plugins, and older dashboard bundles are present. They will not be removed until route usage is verified.

## 6. Missing or incomplete functionality

Runtime confirmation is still required for login/logout, password migration, CSRF coverage, authorization on every action, automated tests, browser responsiveness, environment-based configuration, logging, backups, and clinical compliance controls.

## 7. Five-phase plan

1. Foundation and audit: documentation, safe configuration conventions, security helpers, and public shell.
2. UI system: typography, color tokens, responsive navigation, cards, forms, tables, alerts, and dashboard styling.
3. Authentication and authorization: legacy hash verification with automatic upgrade, session regeneration, guards, CSRF, and safer configuration.
4. Existing modules: modernize administrator and doctor dashboards, then improve verified patient, pharmacy, laboratory, payroll, accounting, prescription, and equipment workflows.
5. Verification and release: PHP syntax checks, database smoke tests when MySQL is available, browser checks, navigation checks, documentation, and limitations.

## Verified versus assumed

**Verified:** repository structure, entry points, named modules, duplicated configuration, legacy login hashing, basic session guards, SQL dump, missing `.gitignore`, and legacy asset families.

**Not verified:** exact runtime behavior of every module, database connectivity, credentials, all schema constraints, browser responsiveness, and reachability of every page.
