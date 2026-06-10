<?php 
session_start();
if(isset($_SESSION["sess_username"])){
     
     $admin_username = $_SESSION["sess_username"];
     $admin_id = $_SESSION["id"];
     
    $for_admin = mysqli_query($db, "SELECT * FROM admin_login WHERE id = $admin_id");
	$record_admin = mysqli_fetch_array($for_admin);
	$admin_email = $record_admin['email'];
	$admin_firstname = $record_admin['firstname'];
	$admin_lastname = $record_admin['lastname'];
	$admin_image = $record_admin['image'];
	$admin_phone = $record_admin['phone'];
	$admin_password = $record_admin['password'];
    $admin_fullname = $admin_firstname.' '.$admin_lastname ;

    $for_page = mysqli_query($db, "SELECT * FROM website WHERE id = 1");
    $record_site = mysqli_fetch_array($for_page);
    $website_name = $record_site['sitename'];
    $website_email = $record_site['siteemail'];
    $website_password = $record_site['sitepassword'];



    if ($admin_image == '') {
    	$admin_image = 'admin.jpg';
    }
     
}else {
     header('location: login.php');
}

?>