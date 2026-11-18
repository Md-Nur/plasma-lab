<?php
// Ensure the Dashboard always defaults to ?id=dashboard so the sidebar highlights correctly
// and the header shows "Dashboard Overview" instead of "Admin Panel".
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_GET['id'] = 'dashboard';
}

include ('head.php');
include ('redirect.php');
include ('navigation.php');
include ('home.php');
include ('bottom.php');
