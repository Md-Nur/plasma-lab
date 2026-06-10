<?php 

include('db_connect.php'); 

?>



<!DOCTYPE html>
<html lang="zxx">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?php echo $site_row['sitename']; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- //meta-tags -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="css/style.css?v=1.1" rel="stylesheet" type="text/css" media="all" />
	<link href="css/gallary.css" rel='stylesheet' type='text/css' />
	<link href="css/gallary-img.css" rel='stylesheet' type='text/css' />
	<!-- font-awesome -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- fonts -->
	<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="theme/jquery.css" media="screen">
	<script src="js/modernizr.custom.js"></script>
	<script src="theme/jquery-3.js"></script>
	<script src="theme/scripts.js"></script>
	<script src="theme/jquery.js"></script>



</head>

<body>



	<?php include('menu.php'); ?>

	<div class="clearfix"></div>

	<?php include('gallary_items.php'); ?>


	<?php include('notice.php'); ?>

	<?php include('footer.php'); ?>



	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script src="js/agency.js"></script>
	<script src="js/jquery.easing.js"></script>
	<script src="js/classie.js"></script>
	<script src="js/jquery.fancybox.pack.js"></script>
	<script src="js/jquery.fancybox-media.js"></script>
	<script src="js/masonry.pkgd.min.js"></script>
	<script src="js/imagesloaded.js"></script>
	<script src="js/AnimOnScroll.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/functions.js"></script>
	<script>
		new AnimOnScroll(document.getElementById('grid'), {
			minDuration: 0.4,
			maxDuration: 0.7,
			viewportFactor: 0.2
		});

	</script>
</body>

</html>
