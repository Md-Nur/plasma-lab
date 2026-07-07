# Deployment Guide

This document explains how to fully set up automated deployment for the Plasma Lab website.

---

## Step 1 — Get your SSH_PRIVATE_KEY

SSH uses a **key pair**: a private key (secret, goes in GitHub) and a public key (goes on the server to grant access). Think of the public key as a lock, and the private key as the only key that opens it.

### 1.1 — Generate the key pair (run this on your local computer)

Open a terminal and run:

```bash
ssh-keygen -t ed25519 -C "github-deploy" -f ~/.ssh/github_deploy
```

- Press **Enter** twice when asked for a passphrase (leave it empty).
- This creates two files:
  - `~/.ssh/github_deploy` → **Private key** (keep this secret)
  - `~/.ssh/github_deploy.pub` → **Public key** (share this with the server)

### 1.2 — Add the public key to your server

Log into your server via SSH and run:

```bash
mkdir -p ~/.ssh
cat >> ~/.ssh/authorized_keys << 'EOF'
PASTE_THE_CONTENTS_OF_github_deploy.pub_HERE
EOF
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
```

To see the public key contents on your local computer:
```bash
cat ~/.ssh/github_deploy.pub
```

### 1.3 — Copy the private key into GitHub

On your local computer, run:
```bash
cat ~/.ssh/github_deploy
```

Copy the **entire output** (including the `-----BEGIN...` and `-----END...` lines).

Go to: **GitHub → Your Repo → Settings → Secrets and variables → Actions → New repository secret**

- Name: `SSH_PRIVATE_KEY`
- Value: paste the entire private key content

---

## Step 2 — Add all GitHub Secrets

Go to: **GitHub repo → Settings → Secrets and variables → Actions**

Add the following secrets one by one:

| Secret Name | What it is | Example |
|:---|:---|:---|
| `SSH_HOST` | Your server's IP address or domain | `203.0.113.55` |
| `SSH_USER` | Your server SSH login username | `ubuntu` or `root` |
| `SSH_PRIVATE_KEY` | The entire private key (from Step 1.3) | `-----BEGIN OPENSSH...` |
| `SSH_PORT` | SSH port *(optional, skip if 22)* | `22` |
| `DEPLOY_PATH` | Full path on server where the site lives | `/var/www/html/plasmalab` |
| `MYSQL_ROOT_PASS` | The MySQL root password on your server | `YourServerMySQLRootPass` |
| `PLASMA_DB_HOST` | MySQL host (almost always `localhost`) | `localhost` |
| `PLASMA_DB_NAME` | Name for your database | `plasma_lab_ru` |
| `PLASMA_DB_USER` | Username for the app's DB user (you choose) | `plasma_user` |
| `PLASMA_DB_PASS` | Password for the app's DB user (you choose) | `Str0ng!P@ssword99` |

> **`PLASMA_DB_USER` and `PLASMA_DB_PASS` are credentials you invent.**
> The deployment workflow will automatically create this user in MySQL on your server
> the first time it runs. You don't need to create it manually.
> Choose any username and a strong password — then add both as GitHub Secrets.

---

## Step 3 — What happens on deployment

Once all secrets are set, every `git push` to `main` will:

```
1. Lint Check     → Verify all PHP files have no syntax errors
2. DB Setup       → Create the MySQL database + app user (if not exists)
3. File Sync      → Copy all project files to the server via rsync
4. DB Migrations  → Run Database/migrate.php to initialize or update the schema
```

On the **first deploy**, the migration script imports the full baseline database from `Database/plasma_lab_ru.sql`.
On **subsequent deploys**, it only runs new `.sql` files you add to `Database/migrations/`.

---

## Step 4 — Adding future database changes

When you need to change the database schema (add a table, add a column, etc.):

1. Create a new file in `Database/migrations/` with a numbered name:
   ```
   Database/migrations/0001_add_videos_table.sql
   Database/migrations/0002_add_phone_to_members.sql
   ```
2. Write your SQL inside the file.
3. Commit and push — the workflow will run it automatically.

---

## Troubleshooting

### "Permission denied (publickey)" during rsync or ssh
- Make sure the **public key** content is correctly added to `~/.ssh/authorized_keys` on the server.
- Make sure the **private key** in GitHub secrets starts with `-----BEGIN OPENSSH PRIVATE KEY-----`.
- Check that the `SSH_USER` secret matches the user whose `authorized_keys` you edited.

### "Access denied for user" on MySQL step
- `MYSQL_ROOT_PASS` is wrong. Verify the MySQL root password on your server with:
  ```bash
  mysql -u root -p
  ```

### "No such file or directory" for DEPLOY_PATH
- The directory doesn't exist on the server yet. Create it:
  ```bash
  mkdir -p /var/www/html/plasmalab
  ```
