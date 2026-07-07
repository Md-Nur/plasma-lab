<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Gallery | <?php echo $site_row['sitename']; ?></title>
	<meta name="description" content="Photo and video gallery from the Plasma Engineering Laboratory.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.1">

	<script src="js/jquery-2.1.4.min.js"></script>
</head>

<body>

	<?php include('menu.php'); ?>

	<div class="clearfix"></div>

	<?php include('gallary_items.php'); ?>

	<?php include('notice.php'); ?>

	<?php include('footer.php'); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>

