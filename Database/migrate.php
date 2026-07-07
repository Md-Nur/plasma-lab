<?php
/**
 * Database Migration Script
 * 
 * This script runs automatically during deployment to initialize the database 
 * and apply any pending schema updates. It reads connection details from 
 * environment variables or config_secrets.php.
 * 
 * Supports both CLI execution and Web execution (via secure token verification).
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define paths
$base_dir = dirname(__DIR__);
$sql_file = $base_dir . '/Database/plasma_lab_ru.sql';
$migrations_dir = $base_dir . '/Database/migrations';

// Load database configuration from env or fallback to defaults
$db_host = getenv('PLASMA_DB_HOST') ?: 'localhost';
$db_name = getenv('PLASMA_DB_NAME') ?: 'plasma_lab_ru';
$db_user = getenv('PLASMA_DB_USER') ?: 'plasma_user';
$db_pass = getenv('PLASMA_DB_PASS') ?: 'plasma*&User24';

// Override with secrets file if present (e.g. on production server)
if (file_exists(__DIR__ . '/config_secrets.php')) {
    include(__DIR__ . '/config_secrets.php');
}

// Check execution mode (CLI or Web)
$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    // If Web, verify migration token for security
    $expected_token = defined('MIGRATION_TOKEN') ? MIGRATION_TOKEN : getenv('MIGRATION_TOKEN');
    
    if (!$expected_token || empty($_GET['token']) || $_GET['token'] !== $expected_token) {
        header('HTTP/1.1 403 Forbidden');
        echo "Error: Forbidden. Invalid or missing migration token.";
        exit(1);
    }
    
    // Output plain text for readability in browser/curl
    header('Content-Type: text/plain; charset=utf-8');
}

// Fix file permissions for static chatbot files (sometimes uploaded as 600 or 700)
$chatbot_css = $base_dir . '/css/chatbot.css';
$chatbot_js = $base_dir . '/js/chatbot.js';
if (file_exists($chatbot_css)) {
    @chmod($chatbot_css, 0644);
}
if (file_exists($chatbot_js)) {
    @chmod($chatbot_js, 0644);
}

echo "=== Starting Database Migrations ===\n";
echo "Database Host: $db_host\n";
echo "Database Name: $db_name\n";
echo "Database User: $db_user\n\n";

try {
    // 1. Connect to MySQL server (without selecting DB first, to ensure DB exists)
    $dsn = "mysql:host=$db_host;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    // 2. Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db_name`");
    echo "Connected to database successfully.\n";

    // 3. Create migrations tracking table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `migration` VARCHAR(255) NOT NULL UNIQUE,
        `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 4. Check if baseline database import is needed (e.g. if 'members' table doesn't exist)
    $stmt = $pdo->query("SHOW TABLES LIKE 'members'");
    $members_exists = $stmt->fetch();

    if (!$members_exists) {
        echo "Baseline table 'members' not found. Importing baseline database schema from plasma_lab_ru.sql...\n";
        if (!file_exists($sql_file)) {
            throw new Exception("Baseline SQL file not found at: $sql_file");
        }

        // Disable foreign key checks during baseline import
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        executeSqlFile($pdo, $sql_file);
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        
        // Record baseline migration as completed
        $stmt = $pdo->prepare("INSERT INTO `migrations` (`migration`) VALUES (?) ON DUPLICATE KEY UPDATE `migration`=`migration`");
        $stmt->execute(['baseline_schema']);
        echo "Baseline database schema imported successfully.\n";
    } else {
        echo "Database already initialized. Skipping baseline import.\n";
    }

    // 5. Scan migrations directory and execute pending migrations
    if (!is_dir($migrations_dir)) {
        mkdir($migrations_dir, 0755, true);
    }

    $files = glob($migrations_dir . '/*.sql');
    sort($files); // Ensure migrations run in lexicographical order

    // Fetch already executed migrations
    $stmt = $pdo->query("SELECT `migration` FROM `migrations`");
    $executed_migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $applied_count = 0;
    foreach ($files as $file) {
        $migration_name = basename($file);
        if (!in_array($migration_name, $executed_migrations)) {
            echo "Applying migration: $migration_name...\n";
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
            executeSqlFile($pdo, $file);
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

            // Record the migration
            $insert_stmt = $pdo->prepare("INSERT INTO `migrations` (`migration`) VALUES (?)");
            $insert_stmt->execute([$migration_name]);
            
            echo "Successfully applied $migration_name.\n";
            $applied_count++;
        }
    }

    echo "\nMigrations completed successfully. Applied $applied_count new migration(s).\n";

} catch (Exception $e) {
    if ($is_cli) {
        fwrite(STDERR, "\n[ERROR] Migration failed: " . $e->getMessage() . "\n");
    } else {
        echo "\n[ERROR] Migration failed: " . $e->getMessage() . "\n";
    }
    exit(1);
}

/**
 * Helper function to execute a SQL file query-by-query to avoid multi-statement issues in PDO
 */
function executeSqlFile($pdo, $filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("SQL file not found: $filePath");
    }

    $handle = fopen($filePath, "r");
    if (!$handle) {
        throw new Exception("Cannot open SQL file: $filePath");
    }

    $query = '';
    $in_comment_block = false;

    while (($line = fgets($handle)) !== false) {
        $trimmed_line = trim($line);

        // Skip empty lines
        if ($trimmed_line === '') {
            continue;
        }

        // Handle multi-line block comments (e.g. /* ... */)
        if ($in_comment_block) {
            if (strpos($trimmed_line, '*/') !== false) {
                $in_comment_block = false;
                $parts = explode('*/', $trimmed_line, 2);
                $trimmed_line = trim($parts[1]);
                if ($trimmed_line === '') {
                    continue;
                }
            } else {
                continue;
            }
        }

        if (strpos($trimmed_line, '/*') === 0) {
            if (strpos($trimmed_line, '*/') === false) {
                $in_comment_block = true;
                continue;
            } else {
                continue;
            }
        }

        // Skip line comments starting with -- or #
        if (strpos($trimmed_line, '--') === 0 || strpos($trimmed_line, '#') === 0) {
            continue;
        }

        $query .= $line;

        // Check if this line ends with a semicolon (optionally followed by space or comment)
        $check_line = preg_replace('/(--|#).*$/', '', $trimmed_line);
        $check_line = trim($check_line);
        
        if (substr($check_line, -1) === ';') {
            // Execute the query
            $pdo->exec($query);
            $query = '';
        }
    }

    fclose($handle);

    // Execute any remaining query
    if (trim($query) !== '') {
        $pdo->exec($query);
    }
}
