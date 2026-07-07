# Deployment and Database Migration Guide

This document describes how the automated GitHub Actions deployment pipeline is structured for the Plasma Lab website, how to configure the required GitHub Secrets, and how to manage database updates.

---

## Architecture Overview

Whenever a push is made to the `main` branch (or you manually trigger the workflow), the following pipeline executes:

```mermaid
graph TD
    A[Push to main] --> B[Lint Check: Verify PHP syntax]
    B --> C[Build: Install Composer dependencies]
    C --> D[Deploy: Rsync files to target server via SSH]
    D --> E[Database: Execute Database/migrate.php on server]
    E --> F[Finished Successfully]
```

---

## 1. Server SSH Configuration

To allow GitHub Actions to copy files and execute commands on your server, you need to set up SSH access:

### Step 1.1: Generate an SSH Key Pair
If you don't already have a dedicated deployment key, generate one on your local computer:
```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f id_github_deploy
```
*Do not enter a passphrase when prompted (press Enter twice).*

This generates two files:
1. `id_github_deploy` (Private Key - keep secret!)
2. `id_github_deploy.pub` (Public Key)

### Step 1.2: Add the Public Key to the Remote Server
Log into your target remote server and add the public key content to the deployment user's `authorized_keys` file:
```bash
mkdir -p ~/.ssh
echo "PASTE_THE_CONTENT_OF_id_github_deploy.pub_HERE" >> ~/.ssh/authorized_keys
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
```

---

## 2. GitHub Secrets Setup

Go to your repository on GitHub:
1. Click **Settings** -> **Secrets and variables** -> **Actions**.
2. Click **New repository secret** to add each of the following secrets:

| Secret Name | Description | Example Value |
| :--- | :--- | :--- |
| `SSH_HOST` | The hostname or IP address of your remote server | `192.168.1.100` or `example.com` |
| `SSH_USER` | The user name to connect via SSH | `root` or `ubuntu` |
| `SSH_PRIVATE_KEY`| The entire contents of the private key (`id_github_deploy` file) | `-----BEGIN OPENSSH PRIVATE KEY-----...` |
| `SSH_PORT` | The SSH port of your server *(Optional: defaults to 22)* | `22` or `2222` |
| `DEPLOY_PATH` | The absolute path on the server where files should reside | `/var/www/html/plasmalab` |
| `PLASMA_DB_HOST` | The MySQL host accessible from the remote server | `localhost` or `127.0.0.1` |
| `PLASMA_DB_NAME` | The name of your database | `plasma_lab_ru` |
| `PLASMA_DB_USER` | The MySQL username on the server | `plasma_user` |
| `PLASMA_DB_PASS` | The MySQL password on the server | `your_database_password` |

---

## 3. Database Migrations Guide

Instead of manually importing database schemas or completely overwriting the database during updates (which would erase user data), we use a structured migration system.

### Baseline Initialization
On the very first deployment, the script checks if the core `members` table exists in your target database.
- If it **does not exist**, it automatically imports the complete base schema from `Database/plasma_lab_ru.sql`.
- If it **does exist**, it skips the baseline import to preserve your data.

### How to Apply New Database Changes
When you need to make schema updates (e.g. creating a new table, adding a column, or altering a column size):
1. Create a new `.sql` file in the `Database/migrations/` directory.
2. Follow the naming convention `XXXX_description.sql` where `XXXX` is a sequential 4-digit number.
   - Example: `0001_create_logs_table.sql`
   - Example: `0002_add_phone_to_members.sql`
3. Commit and push the file to the `main` branch.
4. During deployment, the workflow will detect the new file, execute it, and record it in the `migrations` database table so it never runs again.

---

## 4. Manual Verification & Troubleshooting

If you need to test the database migration script manually on your server, you can log in via SSH and run:

```bash
PLASMA_DB_HOST="localhost" \
PLASMA_DB_NAME="plasma_lab_ru" \
PLASMA_DB_USER="plasma_user" \
PLASMA_DB_PASS="your_password" \
php Database/migrate.php
```

### Common Issues

#### 1. SSH Handshake or Connection Refused
- Double-check that your server's firewall allows incoming connections on the SSH port.
- Make sure `SSH_HOST`, `SSH_USER`, and `SSH_PORT` are configured correctly.
- Verify that `SSH_PRIVATE_KEY` matches the public key in your server's `~/.ssh/authorized_keys`.

#### 2. Rsync / Permission Denied
- Ensure the user specified in `SSH_USER` has write permissions on the directory path specified in `DEPLOY_PATH` on the server.
- You can grant permission on the server using: `chown -R user:group /var/www/html/plasmalab`

#### 3. Migration: Connection Refused or Database Access Denied
- Check that the MySQL/MariaDB server is running.
- Ensure that the database credentials in the GitHub secrets are correct and that the MySQL user has privileges to create tables and execute queries on the specified database.
