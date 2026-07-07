<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Publications | <?php echo $site_row['sitename']; ?></title>
	<meta name="description" content="View journal and conference publications from the Plasma Engineering Laboratory.">
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

	<section class="publications" style="padding-top: 100px; padding-bottom: 80px;">
		<div class="container">
			<div class="title-div text-center" style="margin-bottom: 40px;">
				<h1><span>P</span>ublications</h1>
				<div class="tittle-style"></div>
			</div>

			<!-- Tab Navigation -->
			<ul class="nav nav-tabs pub-tabs" id="pubTabs" style="border-bottom: 2px solid var(--lab-line); margin-bottom: 36px;">
				<li class="active">
					<a href="#tab-journal" data-toggle="tab" id="tab-journal-link">
						<i class="fa fa-book" style="margin-right: 8px;"></i>Journal Publications
					</a>
				</li>
				<li>
					<a href="#tab-conference" data-toggle="tab" id="tab-conf-link">
						<i class="fa fa-microphone" style="margin-right: 8px;"></i>Conference Publications
					</a>
				</li>
			</ul>

			<div class="tab-content">

				<!-- Journal Tab -->
				<div id="tab-journal" class="tab-pane fade in active">
					<div class="scholar-cta" style="background: linear-gradient(135deg, rgba(28,167,168,0.12), rgba(123,61,115,0.08)); border: 1px solid var(--lab-line); border-radius: 12px; padding: 48px 40px; text-align: center; margin-bottom: 30px;">
						<div style="font-size: 56px; margin-bottom: 16px; color: var(--lab-teal);">
							<i class="fa fa-graduation-cap"></i>
						</div>
						<h3 style="font-size: 26px; font-weight: 800; color: var(--lab-ink); margin: 0 0 12px;">Journal Publications</h3>
						<p style="font-size: 16px; color: var(--lab-muted); max-width: 560px; margin: 0 auto 28px; line-height: 1.7;">
							Our journal publications are maintained and updated on Google Scholar. Click the button below to view the complete and up-to-date list sorted by publication date.
						</p>
						<a href="https://scholar.google.com/citations?hl=en&user=0RI4jGUAAAAJ&view_op=list_works&sortby=pubdate" 
						   target="_blank"
						   style="display: inline-flex; align-items: center; gap: 10px; background: var(--lab-teal-dark); color: #fff; font-weight: 800; font-size: 16px; padding: 14px 32px; border-radius: 999px; text-decoration: none; box-shadow: 0 10px 30px rgba(8,125,130,0.28); transition: transform 0.2s ease, box-shadow 0.2s ease;">
							<i class="fa fa-external-link"></i>
							View All Journal Publications
						</a>
					</div>

					<?php
					$i = 1;
					$result_jur = mysqli_query($db, "SELECT * FROM journal ORDER BY id DESC");
					if (mysqli_num_rows($result_jur) > 0) {
					?>
						<div class="journal-list">
							<?php while($row_jur = mysqli_fetch_array($result_jur)){ ?>
							<div class="journal-item">
								<span class="journal-num"><?php echo $i; ?></span>
								<div class="journal-text">
									<?php echo $row_jur['journal']; ?>
								</div>
							</div>
							<?php $i++; } ?>
						</div>
					<?php } ?>
				</div>

				<!-- Conference Tab -->
				<div id="tab-conference" class="tab-pane fade">
					<?php
					$j = 1;
					$result_con = mysqli_query($db, "SELECT * FROM conference ORDER BY id DESC");
					?>
					<div class="conf-list">
						<?php while($row_con = mysqli_fetch_array($result_con)){ ?>
						<div class="conf-item">
							<span class="conf-num"><?php echo $j; ?></span>
							<div class="conf-text">
								<?php echo $row_con['conference']; ?>
							</div>
						</div>
						<?php $j++; } ?>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php include('notice.php'); ?>
	<?php include('footer.php'); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<style>
		.pub-tabs > li > a {
			border-radius: 999px;
			color: var(--lab-ink);
			font-weight: 700;
			font-size: 15px;
			margin-right: 8px;
			border: 0;
			padding: 10px 20px;
		}
		.pub-tabs > li.active > a,
		.pub-tabs > li.active > a:hover,
		.pub-tabs > li > a:hover {
			background: rgba(28,167,168,0.12) !important;
			color: var(--lab-teal-dark) !important;
			border: 0;
		}
		.conf-list,
		.journal-list {
			background: #fff;
			border: 1px solid var(--lab-line);
			border-radius: 12px;
			box-shadow: var(--lab-shadow);
			overflow: hidden;
		}
		.conf-item,
		.journal-item {
			display: flex;
			align-items: flex-start;
			gap: 18px;
			padding: 18px 24px;
			border-bottom: 1px solid var(--lab-line);
			transition: background 0.2s ease;
		}
		.conf-item:last-child,
		.journal-item:last-child { border-bottom: 0; }
		.conf-item:hover,
		.journal-item:hover { background: rgba(28,167,168,0.04); }
		.conf-num,
		.journal-num {
			flex-shrink: 0;
			width: 30px;
			height: 30px;
			background: var(--lab-soft);
			border: 1px solid var(--lab-line);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
			font-weight: 800;
			color: var(--lab-teal-dark);
			margin-top: 2px;
		}
		.conf-text,
		.journal-text {
			font-size: 15px;
			color: var(--lab-ink);
			line-height: 1.6;
			text-align: justify;
		}
	</style>
</body>

</html>
