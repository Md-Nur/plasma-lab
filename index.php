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
			<div class="title-div text-center" style="margin-bottom: 40px;">
				<h1><span>R</span>esearch <span>A</span>ctivities</h1>
				<div class="tittle-style"></div>
			</div>
			
			<div class="activities-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 28px;">
				<?php 
				$result_activities = mysqli_query($db, "SELECT * FROM activities"); 
				while($row_activities = mysqli_fetch_array($result_activities)){ 
				?>
				<div class="service-box" style="margin-bottom: 0;">
					<div class="service-icon">
						<img src="images/activities/<?php echo $row_activities['image']; ?>" alt="<?php echo htmlspecialchars($row_activities['title']); ?>">
					</div>
					<div class="service-content">
						<h4><?php echo htmlspecialchars($row_activities['title']); ?></h4>
						<div class="seperator"></div>
						<p><?php echo htmlspecialchars($row_activities['info']); ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>

	<section class="lab_vission" style="background: linear-gradient(135deg, rgba(123, 61, 115, 0.05), rgba(28, 167, 168, 0.05)); padding: 80px 0;">
		<div class="container">
			<div class="title-div text-center" style="margin-bottom: 40px;">
				<h1><span>V</span>ision</h1>
				<div class="tittle-style"></div>
			</div>
			
			<div style="max-width: 800px; margin: 0 auto; background: var(--lab-card); border: 1px solid var(--lab-line); border-radius: 16px; padding: 48px; box-shadow: var(--lab-shadow); backdrop-filter: blur(10px); text-align: center;">
				<?php 
				$result_vission = mysqli_query($db, "SELECT * FROM vission"); 
				$row_vission = mysqli_fetch_array($result_vission);
				?>
				<h3 style="font-size: 24px; font-weight: 800; color: var(--lab-plum); line-height: 1.5; margin-bottom: 24px; font-style: italic;">
					&ldquo;<?php echo htmlspecialchars($row_vission['title']); ?>&rdquo;
				</h3>
				<p style="font-size: 16px; color: var(--lab-muted); line-height: 1.8; text-align: justify; text-justify: inter-word; white-space: pre-line; margin: 0;">
					<?php echo htmlspecialchars($row_vission['description']); ?>
				</p>
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
