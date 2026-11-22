<?php
/**
 * ImgBB Image Upload and Helper Functions
 * 
 * Automatically uploads dashboard images to ImgBB if IMGBB_API_KEY is configured.
 * Safely falls back to local storage if API key is missing or upload fails.
 * Automatically resolves both local and hosted images through get_image_url().
 */

// Load static URL catalog if available
if (!isset($GLOBALS['IMGBB_CATALOG'])) {
    $catalogPath = __DIR__ . '/imgbb_catalog.php';
    if (file_exists($catalogPath)) {
        $GLOBALS['IMGBB_CATALOG'] = require $catalogPath;
    } else {
        $GLOBALS['IMGBB_CATALOG'] = [];
    }
}

if (!function_exists('get_imgbb_api_key')) {
    function get_imgbb_api_key() {
        if (defined('IMGBB_API_KEY') && !empty(IMGBB_API_KEY)) {
            return IMGBB_API_KEY;
        }

        $envKey = getenv('IMGBB_API_KEY');
        if (!empty($envKey)) {
            return $envKey;
        }

        if (!empty($_ENV['IMGBB_API_KEY'])) {
            return $_ENV['IMGBB_API_KEY'];
        }

        if (!empty($_SERVER['IMGBB_API_KEY'])) {
            return $_SERVER['IMGBB_API_KEY'];
        }

        // Try reading from .env in project root
        $envPath = dirname(__DIR__) . '/.env';
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if ($lines !== false) {
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) {
                        continue;
                    }
                    if (strpos($line, 'IMGBB_API_KEY=') === 0) {
                        $val = trim(substr($line, strlen('IMGBB_API_KEY=')));
                        $val = trim($val, "\"' \t\n\r\0\x0B");
                        if (!empty($val)) {
                            return $val;
                        }
                    }
                }
            }
        }

        return '';
    }
}

if (!defined('IMGBB_API_KEY')) {
    $foundKey = get_imgbb_api_key();
    define('IMGBB_API_KEY', $foundKey);
}

if (!function_exists('upload_image_to_imgbb')) {
    /**
     * Upload an image file to ImgBB API v1 with automatic retry.
     *
     * @param string $fileTmpPath Absolute path to the local/temporary image file
     * @param string $originalName Original filename
     * @param string &$errorMessage Output parameter for any error message
     * @return string|false Hosted image URL on success, or false on failure
     */
    function upload_image_to_imgbb($fileTmpPath, $originalName = '', &$errorMessage = '') {
        $apiKey = get_imgbb_api_key();
        if (empty($apiKey)) {
            $errorMessage = 'ImgBB API key is not configured.';
            return false;
        }

        if (!file_exists($fileTmpPath) || !is_readable($fileTmpPath)) {
            $errorMessage = 'Upload temporary file not found or unreadable.';
            return false;
        }

        $mime = @mime_content_type($fileTmpPath) ?: 'image/jpeg';
        $filename = !empty($originalName) ? basename($originalName) : 'image.jpg';

        $maxAttempts = 3;
        $attempt = 0;
        $lastErr = '';

        while ($attempt < $maxAttempts) {
            $attempt++;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . urlencode($apiKey));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 45);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'image' => new CURLFile($fileTmpPath, $mime, $filename)
            ]);

            $response = curl_exec($ch);
            $curlErr = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($curlErr) {
                $lastErr = 'ImgBB connection error: ' . $curlErr;
                usleep(300000); // 0.3s before retry
                continue;
            }

            $json = json_decode($response, true);
            if ($httpCode === 200 && !empty($json['success']) && !empty($json['data']['url'])) {
                $hostedUrl = $json['data']['url'];

                // Dynamically update the runtime catalog and mapping file
                if (!isset($GLOBALS['IMGBB_CATALOG'])) {
                    $GLOBALS['IMGBB_CATALOG'] = [];
                }
                $GLOBALS['IMGBB_CATALOG'][$filename] = $hostedUrl;
                if (!empty($originalName)) {
                    $GLOBALS['IMGBB_CATALOG'][basename($originalName)] = $hostedUrl;
                }

                $mappingFile = __DIR__ . '/imgbb_mapping.json';
                if (file_exists($mappingFile) && is_writable($mappingFile)) {
                    $existing = json_decode(@file_get_contents($mappingFile), true) ?: [];
                    $existing[$filename] = $hostedUrl;
                    @file_put_contents($mappingFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                }

                return $hostedUrl;
            }

            $apiMsg = $json['error']['message'] ?? ('HTTP ' . $httpCode);
            $lastErr = 'ImgBB upload failed: ' . $apiMsg;
            usleep(300000);
        }

        $errorMessage = $lastErr ?: 'ImgBB upload failed after retries.';
        return false;
    }
}

if (!function_exists('upload_dashboard_image')) {
    /**
     * Upload an image from $_FILES input, trying ImgBB first and falling back to local disk.
     *
     * @param array $fileInput An item from $_FILES (e.g. $_FILES['image'])
     * @param string $fallbackDir Local folder path to save to if ImgBB fails/unavailable
     * @param string &$errorMessage Error message output
     * @param string $customPrefix Prefix for local filename fallback (e.g. timestamp)
     * @return string|false ImgBB URL or local filename on success, false on failure
     */
    function upload_dashboard_image($fileInput, $fallbackDir = '', &$errorMessage = '', $customPrefix = '') {
        if (!isset($fileInput) || !is_array($fileInput)) {
            $errorMessage = 'No image upload data provided.';
            return false;
        }

        if ($fileInput['error'] !== UPLOAD_ERR_OK || empty($fileInput['tmp_name']) || !file_exists($fileInput['tmp_name'])) {
            $errorMessage = 'Upload error or empty file.';
            return false;
        }

        // 1. Try uploading to ImgBB
        $apiKey = get_imgbb_api_key();
        if (!empty($apiKey)) {
            $imgbbError = '';
            $imgbbUrl = upload_image_to_imgbb($fileInput['tmp_name'], $fileInput['name'] ?? '', $imgbbError);
            if ($imgbbUrl) {
                return $imgbbUrl;
            }
            // If ImgBB failed, record the error in case fallback also fails
            $errorMessage = $imgbbError;
        }

        // 2. Fallback to local storage if fallbackDir is specified
        if (!empty($fallbackDir)) {
            if (!is_dir($fallbackDir) && !mkdir($fallbackDir, 0755, true)) {
                $errorMessage = 'Fallback upload directory could not be created: ' . $fallbackDir;
                return false;
            }

            $ext = pathinfo($fileInput['name'] ?? 'image.jpg', PATHINFO_EXTENSION);
            $ext = strtolower($ext ?: 'jpg');
            $prefix = $customPrefix ?: time();
            $localName = $prefix . '.' . $ext;

            $dest = rtrim($fallbackDir, '/') . '/' . $localName;
            if (move_uploaded_file($fileInput['tmp_name'], $dest)) {
                return $localName;
            } else {
                $errorMessage = 'Failed to save photo locally to ' . $dest;
                return false;
            }
        }

        return false;
    }
}

if (!function_exists('get_image_url')) {
    /**
     * Resolves an image value to a full displayable URL.
     * If the value is an absolute HTTP/HTTPS URL, it returns it directly.
     * If the value exists in the ImgBB catalog, it returns the hosted ImgBB URL.
     * If the value is a local relative filename, it prefixes the local folder.
     *
     * @param string $image Database image value (URL or filename)
     * @param string $localFolder Optional folder prefix for local images (e.g. 'images/member/members/' or '../images/member/members/')
     * @return string Valid image src URL
     */
    function get_image_url($image, $localFolder = '') {
        if (empty($image)) {
            return '';
        }

        $image = trim($image);

        // 1. Check if image is already an external URL or data URI
        if (preg_match('~^(https?://|//|data:)~i', $image)) {
            return $image;
        }

        // Determine if context is within dashboard (starts with '../')
        $isDashboard = (!empty($localFolder) && strpos($localFolder, '../') === 0);

        // Normalize image path by removing any leading '../', './', or '/'
        $cleanImage = preg_replace('~^(\.\./|\./|/)+~', '', $image);
        $cleanFolder = !empty($localFolder) ? preg_replace('~^(\.\./|\./|/)+~', '', $localFolder) : '';
        $cleanFolder = rtrim($cleanFolder, '/') . '/';
        $baseName = basename($cleanImage);

        // 2. Check ImgBB catalog mapping
        $catalog = $GLOBALS['IMGBB_CATALOG'] ?? [];
        if (!empty($catalog)) {
            $candidates = [
                $cleanImage,
                'images/' . $cleanImage,
                $cleanFolder . $baseName,
                'images/' . $cleanFolder . $baseName,
                $baseName,
            ];
            foreach ($candidates as $cand) {
                $cand = preg_replace('~/{2,}~', '/', $cand);
                if (!empty($catalog[$cand])) {
                    return $catalog[$cand];
                }
            }
        }

        // 3. Fallback to local file path
        if (strpos($cleanImage, 'images/') === 0) {
            return ($isDashboard ? '../' : '') . $cleanImage;
        }

        // Otherwise it's a bare filename like 'demo_image.png' or '1726478916.jpg'
        if (!empty($localFolder)) {
            $localFolder = rtrim($localFolder, '/') . '/';
            return $localFolder . $baseName;
        }

        return ($isDashboard ? '../' : '') . $cleanImage;
    }
}

if (!function_exists('safe_delete_image')) {
    /**
     * Safely deletes a local image file. If the image is an ImgBB / HTTP URL, it does nothing.
     *
     * @param string $image Image filename or URL
     * @param string $localFolder Directory where the local file would be stored
     */
    function safe_delete_image($image, $localFolder = '') {
        if (empty($image)) {
            return;
        }
        if (preg_match('~^(https?://|//|data:)~i', $image)) {
            // Hosted externally (e.g. ImgBB), no local file to unlink
            return;
        }
        $base = basename($image);
        if ($base === 'demo_image.png' || $base === 'admin.jpg') {
            return;
        }

        $fullPath = rtrim($localFolder, '/') . '/' . $base;
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
