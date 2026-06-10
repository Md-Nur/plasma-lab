<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?php echo $site_row['sitename']; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
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


	<?php include('slider.php'); ?>


	<div class="clearfix"></div>

	<section class="lab_activities">
		<div class="container">
			<div class="title-div text-center">
				<h1><span>R</span>esearch <span>A</span>ctivities</h1>
			</div>
			<div class="tittle-style"></div>
			<div class="row" style="margin-top: 40px;">


				<?php 
	$result_activities = mysqli_query($db, "SELECT * FROM activities"); 
	
?>
				<?php while($row_activities = mysqli_fetch_array($result_activities)){ ?>

				<div class="col-md-3 col-sm-6 ">
					<div class="service-box">
						<div class="service-icon">
							<img src="images/activities/<?php echo $row_activities['image']; ?>" style="width: 100%;height: 100%;">
						</div>
						<div class="service-content" style="background-color:#fff;">
							<h4 style="color: #8E5083; font-size:20px; font-weight:700;">
								<?php echo $row_activities['title']; ?>
							</h4>
							<div class="seperator"></div>
							<p style="color: #222; text-align: center;">
								<?php echo $row_activities['info']; ?>
							</p>
						</div>
					</div>
				</div>

				<?php } ?>



			</div>
		</div>
	</section>

	<div class="clearfix"></div>

	<section class="lab_vission">
		<div class="top-bottom">
			<div class="container">
				<div class="title-div text-center">
					<h1 class="tittle">
						<span>V</span>ission
					</h1>
				</div>
				<div class="tittle-style"></div>
				<div >
					<div class="col-md-12">
						<?php 
						$result_vission = mysqli_query($db, "SELECT * FROM vission"); 
						$row_vission = mysqli_fetch_array($result_vission);
					?>
						<div class="">
							<h3>“
								<?php echo $row_vission['title'] ?>”</h3>
						</div>
						<p style="white-space: pre-line;">
							<?php echo $row_vission['description'] ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>


	<div class="clearfix"></div>

	<?php include('notice.php'); ?>

	<?php include('footer.php'); ?>



	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- wow effect -->
	<script src="js/wow.min.js"></script>
	<script>
		new WOW().init();

	</script>
</body>

</html>
