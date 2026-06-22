<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Research Areas | <?php echo $site_row['sitename']; ?></title>
	<meta name="description" content="Explore the research areas at the Plasma Science and Technology Laboratory.">
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

	<section class="blog-cource" style="margin-top: 80px; margin-bottom: 80px;">
		<div class="container">
			<div class="title-div text-center" style="margin-bottom: 30px;">
				<h1><span>R</span>esearch <span>A</span>reas</h1>
				<div class="tittle-style"></div>
			</div>

			<?php $result_areas = mysqli_query($db, "SELECT * FROM areas"); ?>

			<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 28px; margin-top: 10px;">
				<?php while($row_areas = mysqli_fetch_array($result_areas)){ ?>
				<div class="service-box">
					<div class="service-icon">
						<img src="images/areas/<?php echo $row_areas['image']; ?>" alt="<?php echo htmlspecialchars($row_areas['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
					</div>
					<div class="service-content" style="background-color: #fff;">
						<h3 style="color: var(--lab-plum);">
							<?php echo htmlspecialchars($row_areas['title']); ?>
						</h3>
						<div class="seperator"></div>
						<p style="color: var(--lab-muted); text-align: center; font-size: 14px;">
							<?php echo htmlspecialchars($row_areas['info']); ?>
						</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<?php include('notice.php'); ?>
	<?php include('footer.php'); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
