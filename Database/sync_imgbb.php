<?php
/**
 * ImgBB Image Sync Utility
 * 
 * Synchronizes all local images to ImgBB and updates database image references.
 * Can be run from CLI:
 *   php Database/sync_imgbb.php
 * Or via Web with migration token:
 *   https://example.com/Database/sync_imgbb.php?token=YOUR_MIGRATION_TOKEN
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    if (file_exists(__DIR__ . '/config_secrets.php')) {
        include(__DIR__ . '/config_secrets.php');
    }
    $expected_token = defined('MIGRATION_TOKEN') ? MIGRATION_TOKEN : getenv('MIGRATION_TOKEN');
    
    // Read from .env if still not found
    if (!$expected_token && file_exists(dirname(__DIR__) . '/.env')) {
        $lines = file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $l) {
            if (strpos($l, 'MIGRATION_TOKEN=') === 0) {
                $expected_token = trim(substr($l, strlen('MIGRATION_TOKEN=')));
                break;
            }
        }
    }

    if (!$expected_token || empty($_GET['token']) || $_GET['token'] !== $expected_token) {
        header('HTTP/1.1 403 Forbidden');
        echo "Error: Forbidden. Invalid or missing migration token.";
        exit(1);
    }
    header('Content-Type: text/plain; charset=utf-8');
}

require_once __DIR__ . '/imgbb.php';

$apiKey = get_imgbb_api_key();
if (empty($apiKey)) {
    echo "Error: IMGBB_API_KEY is not configured.\n";
    exit(1);
}

echo "=== ImgBB Image Sync Utility ===\n";
echo "ImgBB API Key: " . substr($apiKey, 0, 8) . "...\n\n";

$rootDir = dirname(__DIR__);
$mappingFile = __DIR__ . '/imgbb_mapping.json';
$mapping = [];
if (file_exists($mappingFile)) {
    $mapping = json_decode(file_get_contents($mappingFile), true) ?: [];
}

// 1. Scan image folders
$dirs = [
    $rootDir . '/images',
    $rootDir . '/dashboard/assets/images',
];

$allFiles = [];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $relPath = ltrim(str_replace($rootDir, '', $file->getPathname()), '/\\');
                $allFiles[] = $relPath;
            }
        }
    }
}
sort($allFiles);

$uploaded = 0;
$skipped = 0;
$failed = 0;

foreach ($allFiles as $relPath) {
    $fullPath = $rootDir . '/' . $relPath;
    if (!empty($mapping[$relPath])) {
        $skipped++;
        continue;
    }

    echo "Uploading new image: $relPath... ";
    $err = '';
    $url = upload_image_to_imgbb($fullPath, basename($relPath), $err);
    if ($url) {
        $mapping[$relPath] = $url;
        file_put_contents($mappingFile, json_encode($mapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo "SUCCESS: $url\n";
        $uploaded++;
    } else {
        echo "FAILED: $err\n";
        $failed++;
    }
    usleep(200000); // 0.2s
}

echo "\nScan complete: " . count($allFiles) . " total files ($skipped existing, $uploaded uploaded, $failed failed).\n";

// 2. Regenerate catalog
$catalogFile = __DIR__ . '/imgbb_catalog.php';
$phpCode = "<?php\n/**\n * Auto-generated ImgBB image URL catalog.\n * Maps relative file paths and filenames to hosted ImgBB URLs.\n */\n\nreturn [\n";
foreach ($mapping as $relPath => $url) {
    $phpCode .= "    " . var_export($relPath, true) . " => " . var_export($url, true) . ",\n";
}
foreach ($mapping as $relPath => $url) {
    if (strpos($relPath, 'images/') === 0) {
        $sub = substr($relPath, strlen('images/'));
        if (!isset($mapping[$sub])) {
            $phpCode .= "    " . var_export($sub, true) . " => " . var_export($url, true) . ",\n";
        }
    }
    $base = basename($relPath);
    if (!isset($mapping[$base])) {
        $phpCode .= "    " . var_export($base, true) . " => " . var_export($url, true) . ",\n";
    }
}
$phpCode .= "];\n";
file_put_contents($catalogFile, $phpCode);
echo "Regenerated catalog at: $catalogFile\n";

// 3. Update database rows if database is reachable
echo "\nChecking database connection for row updates...\n";
$db_host = getenv('PLASMA_DB_HOST') ?: 'localhost';
$db_name = getenv('PLASMA_DB_NAME') ?: 'plasma_lab_ru';
$db_user = getenv('PLASMA_DB_USER') ?: 'plasma_user';
$db_pass = getenv('PLASMA_DB_PASS') ?: 'plasma*&User24';

if (file_exists(__DIR__ . '/config_secrets.php')) {
    include(__DIR__ . '/config_secrets.php');
}

$conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn && !getenv('PLASMA_DB_USER')) {
    $conn = @mysqli_connect($db_host, 'root', '', $db_name);
}

if ($conn) {
    mysqli_set_charset($conn, 'utf8mb4');
    echo "Connected to database ($db_name). Updating image columns and paths...\n";

    // Run migration queries from 0014 if file exists
    $migFile = __DIR__ . '/migrations/0014_migrate_images_to_imgbb.sql';
    if (file_exists($migFile)) {
        $sqls = file_get_contents($migFile);
        $queries = explode(";\n", $sqls);
        $execCount = 0;
        foreach ($queries as $q) {
            $q = trim($q);
            if (!empty($q) && strpos($q, '--') !== 0) {
                @mysqli_query($conn, $q);
                $execCount++;
            }
        }
        echo "Executed $execCount database sync statements.\n";
    }
    mysqli_close($conn);
    echo "Database sync completed successfully.\n";
} else {
    echo "Notice: Database connection not available in this environment. Run Database/migrate.php during deployment.\n";
}

echo "\n=== All done! ===\n";
