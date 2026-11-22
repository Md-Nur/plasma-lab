<?php
/**
 * Push All Images to ImgBB
 * 
 * Scans all image directories in the project (images/, dashboard/assets/images/)
 * and uploads any image that hasn't been uploaded yet to ImgBB using the configured API key.
 * 
 * Saves the mapping to Database/imgbb_mapping.json and generates Database/imgbb_catalog.php.
 * Also generates the SQL migration Database/migrations/0014_migrate_images_to_imgbb.sql.
 */

require_once __DIR__ . '/imgbb.php';

$apiKey = get_imgbb_api_key();
if (empty($apiKey)) {
    die("Error: IMGBB_API_KEY is not configured.\n");
}

echo "=== ImgBB Bulk Image Upload ===\n";
echo "Using ImgBB API Key: " . substr($apiKey, 0, 8) . "...\n\n";

$mappingFile = __DIR__ . '/imgbb_mapping.json';
$mapping = [];
if (file_exists($mappingFile)) {
    $existing = json_decode(file_get_contents($mappingFile), true);
    if (is_array($existing)) {
        $mapping = $existing;
    }
}

// Seed the ones we already uploaded in our test
$preUploaded = [
    'images/logo.png' => 'https://i.ibb.co/ns98n8wy/logo.jpg',
    'images/slider/1525857564.jpg' => 'https://i.ibb.co/GfpsCyG8/1525857564.jpg',
    'images/member/members/M_R_Talukder.JPG' => 'https://i.ibb.co/XkK15y7f/M-R-Talukder.jpg',
];
foreach ($preUploaded as $k => $v) {
    if (!isset($mapping[$k])) {
        $mapping[$k] = $v;
    }
}

// Scan directories
$rootDir = dirname(__DIR__);
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
                // Get path relative to root
                $relPath = ltrim(str_replace($rootDir, '', $file->getPathname()), '/\\');
                $allFiles[] = $relPath;
            }
        }
    }
}

sort($allFiles);
$total = count($allFiles);
echo "Found $total total image files to check.\n";

$uploadedCount = 0;
$skippedCount = 0;
$failedCount = 0;

foreach ($allFiles as $index => $relPath) {
    $num = $index + 1;
    $fullPath = $rootDir . '/' . $relPath;

    if (!empty($mapping[$relPath])) {
        echo "[$num/$total] Already on ImgBB: $relPath => {$mapping[$relPath]}\n";
        $skippedCount++;
        continue;
    }

    echo "[$num/$total] Uploading: $relPath (" . round(filesize($fullPath)/1024, 1) . " KB)... ";
    flush();

    $err = '';
    $url = upload_image_to_imgbb($fullPath, basename($relPath), $err);

    if ($url) {
        $mapping[$relPath] = $url;
        file_put_contents($mappingFile, json_encode($mapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo "SUCCESS: $url\n";
        $uploadedCount++;
    } else {
        echo "FAILED: $err\n";
        $failedCount++;
    }

    // Small delay to be polite to the ImgBB API
    usleep(250000); // 0.25s
}

echo "\n=== Upload Summary ===\n";
echo "Total files: $total\n";
echo "Uploaded:    $uploadedCount\n";
echo "Skipped:     $skippedCount\n";
echo "Failed:      $failedCount\n";

// Save updated mapping
file_put_contents($mappingFile, json_encode($mapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Saved mapping to: $mappingFile\n";

// Generate PHP catalog for O(1) in-memory lookup
$catalogFile = __DIR__ . '/imgbb_catalog.php';
$phpCode = "<?php\n/**\n * Auto-generated ImgBB image URL catalog.\n * Maps relative file paths and filenames to hosted ImgBB URLs.\n */\n\nreturn [\n";

// Add relative paths
foreach ($mapping as $relPath => $url) {
    $phpCode .= "    " . var_export($relPath, true) . " => " . var_export($url, true) . ",\n";
}

// Also add normalized variations:
// e.g. "slider/1525857564.jpg", "member/members/M_R_Talukder.JPG", "1525857564.jpg"
foreach ($mapping as $relPath => $url) {
    // Strip leading "images/" or "dashboard/assets/images/"
    if (strpos($relPath, 'images/') === 0) {
        $sub = substr($relPath, strlen('images/'));
        if (!isset($mapping[$sub])) {
            $phpCode .= "    " . var_export($sub, true) . " => " . var_export($url, true) . ",\n";
        }
    }
    // Also map by folder/basename
    $base = basename($relPath);
    if (!isset($mapping[$base]) && $base !== 'demo_image.png') {
        $phpCode .= "    " . var_export($base, true) . " => " . var_export($url, true) . ",\n";
    }
}

$phpCode .= "];\n";
file_put_contents($catalogFile, $phpCode);
echo "Generated catalog in: $catalogFile\n";
