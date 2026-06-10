<?php

	$db = mysqli_connect('localhost', 'root', '', 'plasma_lab_ru');
     
// Check connection

     if ($db) {

        $site_info = "SELECT * FROM website WHERE id = '1'";
		$site_result = mysqli_query($db, $site_info);
		$site_row = mysqli_fetch_array( $site_result ); 
//		 echo $site_row['sitename'];

     }else {
           die("Connection failed: " . mysqli_connect_error());
           echo "Connect failed";
     }



?>
