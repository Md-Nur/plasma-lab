# Database Migrations

This directory contains incremental database schema updates (migrations) for the Plasma Engineering Laboratory website.

## How to use migrations

1. All migration files must be SQL files and placed directly in this folder.
2. Naming convention: Use sequential numeric prefixes (e.g., `0001_add_new_table.sql`, `0002_add_column_to_members.sql`). Migrations are applied in lexicographical order.
3. The automatic deployment workflow runs these migrations on the server via `php Database/migrate.php`.
4. Migrations are recorded in the `migrations` table in the database to ensure each script runs exactly once.

## Guidelines for writing migrations

- **No duplicate table creations**: Use `CREATE TABLE IF NOT EXISTS`.
- **Make alterations safe**: Use conditionals or check if columns exist if you can, or structure updates carefully.
- **Transactions**: For critical operations, wrap statements in transactions (`START TRANSACTION; ... COMMIT;`).
