<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		Plasma Engineering Laboratory
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.2">

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
			
			<div class="activities-grid">
				<?php 
				$result_activities = mysqli_query($db, "SELECT * FROM activities"); 
				while($row_activities = mysqli_fetch_array($result_activities)){ 
				?>
				<div class="service-box activity-card">
					<div class="service-icon">
						<img src="images/activities/<?php echo htmlspecialchars($row_activities['image']); ?>" alt="<?php echo htmlspecialchars($row_activities['title']); ?>">
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

	<!-- ── Featured Videos Section ─────────────────────── -->
	<?php
	$result_featured_vids = mysqli_query($db, "SELECT * FROM videos WHERE youtube_url != '' ORDER BY id DESC LIMIT 3");
	$feat_count = mysqli_num_rows($result_featured_vids);
	if ($feat_count > 0):
	?>
	<section style="padding: 80px 0; background: var(--lab-soft);">
		<div class="container">
			<div class="title-div text-center" style="margin-bottom: 16px;">
				<h1><span>L</span>ab <span>V</span>ideos</h1>
				<div class="tittle-style"></div>
			</div>
			<p style="text-align: center; color: var(--lab-muted); margin-bottom: 40px; font-size: 15px;">Watch research videos and recordings from our laboratory</p>

			<div class="home-videos-grid">
				<?php while($fv = mysqli_fetch_array($result_featured_vids)):
					$yt_id = '';
					if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $fv['youtube_url'], $m)) {
						$yt_id = $m[1];
					}
					if (!$yt_id) continue;
				?>
				<div class="home-video-embed">
					<div class="home-video-frame-wrap">
						<iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($yt_id); ?>?rel=0"
						        title="<?php echo htmlspecialchars($fv['title']); ?>"
						        frameborder="0"
						        loading="lazy"
						        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						        allowfullscreen></iframe>
					</div>
					<div class="home-video-meta">
						<h4><?php echo htmlspecialchars($fv['title']); ?></h4>
						<?php if ($fv['info']): ?>
						<p><?php echo htmlspecialchars($fv['info']); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php endwhile; ?>
			</div>

			<div style="text-align: center; margin-top: 36px;">
				<a href="gallary.php#videos" class="btn btn-info" style="padding: 12px 32px; font-size: 15px; border-radius: 8px;">
					<i class="fa fa-play-circle" style="margin-right: 8px;"></i> View All Videos
				</a>
			</div>
		</div>
	</section>

	<style>
	.home-videos-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
		gap: 28px;
	}

	.home-video-embed {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 8px 28px rgba(23,33,47,0.10);
		transition: transform 0.25s ease, box-shadow 0.25s ease;
	}

	.home-video-embed:hover {
		transform: translateY(-4px);
		box-shadow: 0 18px 44px rgba(23,33,47,0.16);
	}

	.home-video-frame-wrap {
		position: relative;
		width: 100%;
		padding-bottom: 56.25%;
		height: 0;
		background: #000;
	}

	.home-video-frame-wrap iframe {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
	}

	.home-video-meta {
		padding: 16px 20px 20px;
	}

	.home-video-meta h4 {
		font-size: 16px;
		font-weight: 800;
		color: var(--lab-ink, #17212f);
		margin: 0 0 6px;
		line-height: 1.35;
	}

	.home-video-meta p {
		font-size: 13px;
		color: var(--lab-muted, #6b7280);
		margin: 0;
		line-height: 1.5;
		white-space: normal;
		text-align: left;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	@media (max-width: 600px) {
		.home-videos-grid {
			grid-template-columns: 1fr;
			gap: 18px;
		}
	}
	</style>
	<?php endif; ?>

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
