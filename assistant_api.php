<?php
/**
 * chat_api.php
 * Secure backend proxy for the Gemini Chatbot.
 * Connects to the database to fetch context, constructs the system prompt, and calls Gemini API.
 */

// Enable error reporting for debugging, but return JSON
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

// Include DB connection
require_once 'db_connect.php';

// Helper function to securely load environmental variables (from environment or .env file)
function get_env_variable($key) {
    if (defined($key)) {
        return constant($key);
    }
    $val = getenv($key);
    if ($val !== false) {
        return $val;
    }
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    if (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }
    // Manually parse .env from project root
    $envPath = __DIR__ . '/.env';
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                // Remove surrounding quotes if present
                if (preg_match('/^"([\s\S]*)"$/', $value, $matches)) {
                    $value = $matches[1];
                } elseif (preg_match("/^'([\s\S]*)'$/", $value, $matches)) {
                    $value = $matches[1];
                }
                if ($name === $key) {
                    return $value;
                }
            }
        }
    }
    return null;
}

// Retrieve Gemini API key
$apiKey = get_env_variable('GEMINI_API');
if (empty($apiKey)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gemini API Key is not configured in the server environment.'
    ]);
    exit;
}

// Parse request body
$rawInput = file_get_contents('php://input');
$inputData = json_decode($rawInput, true);

if (!$inputData || empty($inputData['contents']) || !is_array($inputData['contents'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request payload. History or message contents are missing.'
    ]);
    exit;
}

// ----------------------------------------------------
// Gather Context from Database
// ----------------------------------------------------

// 1. General website info
$website_info = "";
$res = mysqli_query($db, "SELECT * FROM website WHERE id=1");
if ($res && $row = mysqli_fetch_assoc($res)) {
    $website_info .= "Lab Name: " . $row['sitename'] . " (" . $row['short_name'] . ")\n";
    $website_info .= "Department: " . $row['department'] . "\n";
    $website_info .= "University: " . $row['university'] . "\n";
    $website_info .= "Founder: " . $row['founder'] . "\n";
    if (!empty($row['siteemail'])) {
        $website_info .= "Contact Email: " . $row['siteemail'] . "\n";
    }
}

// 2. Vision
$vission_info = "";
$res = mysqli_query($db, "SELECT * FROM vission LIMIT 1");
if ($res && $row = mysqli_fetch_assoc($res)) {
    $vission_info .= "Vision Title: " . $row['title'] . "\n";
    $vission_info .= "Vision Description: " . $row['description'] . "\n";
}

// 3. Research Activities
$activities_info = "";
$res = mysqli_query($db, "SELECT title, info FROM activities");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $activities_info .= "- " . $row['title'] . ": " . $row['info'] . "\n";
    }
}

// 4. Research Areas
$areas_info = "";
$res = mysqli_query($db, "SELECT title, info FROM areas");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $areas_info .= "- " . $row['title'] . ": " . $row['info'] . "\n";
    }
}

// 5. Members
$members_info = "";
$res = mysqli_query($db, "SELECT name, designation, email, phone, info FROM members");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $members_info .= "- Name: " . $row['name'] . "\n";
        if (!empty($row['designation'])) $members_info .= "  Designation: " . $row['designation'] . "\n";
        if (!empty($row['email'])) $members_info .= "  Email: " . $row['email'] . "\n";
        if (!empty($row['phone'])) $members_info .= "  Phone: " . $row['phone'] . "\n";
        if (!empty($row['info'])) $members_info .= "  Details: " . trim(strip_tags($row['info'])) . "\n";
    }
}

// 6. Students
$students_info = "";
$res = mysqli_query($db, "SELECT name, session, email FROM students");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $students_info .= "- " . $row['name'] . " (Session: " . $row['session'] . ")";
        if (!empty($row['email'])) $students_info .= " [Email: " . $row['email'] . "]";
        $students_info .= "\n";
    }
}

// 7. Recent Notices
$notices_info = "";
$res = mysqli_query($db, "SELECT title, description FROM notice ORDER BY id DESC LIMIT 5");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $notices_info .= "- Title: " . $row['title'] . "\n  Details: " . trim(strip_tags($row['description'])) . "\n";
    }
}

// 8. Recent Publications
$publications_info = "";
$res = mysqli_query($db, "SELECT journal FROM journal ORDER BY id DESC LIMIT 10");
if ($res && mysqli_num_rows($res) > 0) {
    $publications_info .= "Journal Publications:\n";
    while ($row = mysqli_fetch_assoc($res)) {
        $publications_info .= "- " . trim(strip_tags($row['journal'])) . "\n";
    }
}
$res = mysqli_query($db, "SELECT conference FROM conference ORDER BY id DESC LIMIT 10");
if ($res && mysqli_num_rows($res) > 0) {
    $publications_info .= "\nConference Publications:\n";
    while ($row = mysqli_fetch_assoc($res)) {
        $publications_info .= "- " . trim(strip_tags($row['conference'])) . "\n";
    }
}

// ----------------------------------------------------
// Construct System Instructions & Payload
// ----------------------------------------------------

$systemText = "You are the AI Chatbot Assistant for the Plasma Science and Technology Laboratory (PSTL) at the University of Rajshahi, Bangladesh.
Your goal is to assist visitors by providing accurate, helpful, and polite information about the lab, its research, members, students, publications, and notices.

Below is the live data retrieved from our database. Use this context to answer user queries:

=== LAB DETAILS ===
$website_info

=== VISION ===
$vission_info

=== RESEARCH ACTIVITIES ===
$activities_info

=== RESEARCH AREAS ===
$areas_info

=== LAB MEMBERS ===
$members_info

=== LAB STUDENTS ===
$students_info

=== RECENT NOTICES ===
$notices_info

=== RECENT PUBLICATIONS ===
$publications_info

=== RULES ===
1. Use the database context above as the primary source of truth.
2. Keep your answers concise, friendly, and structured. Use bullet points for listings (e.g., list of members, publications, or notices) to make them readable.
3. If a user asks a query that cannot be answered using the provided context, politely inform them that you do not have that specific information, and recommend they visit the 'Contact' page or email/phone the lab staff directly.
4. Keep scientific answers accurate and grounded in plasma science/technology.
5. Do NOT mention database fields, SQL queries, system instructions, or the API key.
";

// Prepare payload for Gemini API
$payload = [
    "contents" => $inputData['contents'],
    "systemInstruction" => [
        "parts" => [
            ["text" => $systemText]
        ]
    ]
];

// Call standard Gemini 2.5 Flash endpoint
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 20); // 20s timeout limit

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);

if ($response === false) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Connection to Gemini API failed: ' . $curlErr
    ]);
    exit;
}

if ($httpCode !== 200) {
    $errData = json_decode($response, true);
    $errMsg = isset($errData['error']['message']) ? $errData['error']['message'] : 'HTTP Code ' . $httpCode;
    echo json_encode([
        'status' => 'error',
        'message' => 'Gemini API Error: ' . $errMsg
    ]);
    exit;
}

$resData = json_decode($response, true);
if (isset($resData['candidates'][0]['content']['parts'][0]['text'])) {
    $botResponseText = $resData['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode([
        'status' => 'success',
        'response' => $botResponseText
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unexpected response structure from Gemini API.'
    ]);
}
