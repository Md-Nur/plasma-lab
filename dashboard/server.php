<?php
// Start the session here — before head.php outputs any HTML.
// server.php is included by head.php which is always the first include,
// so this guarantees session_start() runs before any output on every page.
// session_status() check prevents "already started" warnings.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../Database/config.php');
?>
