
<?php
// Ensure the Dashboard always has ?id=dashboard so the sidebar highlights correctly
// and the header shows "Dashboard Overview" instead of "Admin Panel".
if (!isset($_GET['id']) || $_GET['id'] !== 'dashboard') {
    header('Location: index.php?id=dashboard');
    exit;
}
?>
<?php include ('head.php');?>
<?php include ('redirect.php');?>
<?php include ('navigation.php');?>

<?php include ('home.php');?>

<?php include ('bottom.php');?>