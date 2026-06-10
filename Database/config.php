<?php

$db_host = getenv('PLASMA_DB_HOST') ?: 'localhost';
$db_name = getenv('PLASMA_DB_NAME') ?: 'plasma_lab_ru';
$db_user = getenv('PLASMA_DB_USER') ?: 'plasma_user';
$db_pass = getenv('PLASMA_DB_PASS') ?: 'plasma*&User24';

$db = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db && !getenv('PLASMA_DB_USER')) {
    $db = @mysqli_connect($db_host, 'root', '', $db_name);
}

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($db, 'utf8mb4');

$site_info = "SELECT * FROM website WHERE id = '1'";
$site_result = mysqli_query($db, $site_info);
$site_row = mysqli_fetch_array($site_result);

?>
