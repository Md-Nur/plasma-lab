<?php
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>All Notices | Plasma Engineering Laboratory</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.1">
	<script src="js/jquery.min.js"></script>
</head>
<body>

	<?php include('menu.php'); ?>

	<section class="all-notices-section" style="padding-top: 120px; padding-bottom: 100px; min-height: 70vh;">
		<div class="container" style="max-width: 800px;">
			<div class="title-div text-center" style="margin-bottom: 40px;">
				<h1><span>A</span>ll Notices</h1>
				<div class="tittle-style"></div>
			</div>

			<div class="notices-list">
				<?php 
				$i = 1;
				$result = mysqli_query($db, "SELECT * FROM notice ORDER BY id DESC");
				if (mysqli_num_rows($result) == 0) {
					echo '<div class="text-center" style="color: var(--lab-muted); padding: 40px; font-weight: 600;">No notices available at this time.</div>';
				} else {
					while($row = mysqli_fetch_array($result)){ 
				?>
				<div class="notice-card" style="margin-bottom: 20px;">
					<div class="notice-card-header" style="display: flex; justify-content: space-between; align-items: center; gap: 14px;">
						<div style="display: flex; align-items: center; gap: 10px;">
							<strong style="color: var(--lab-teal-dark); font-size: 16px;"><?php echo $i; ?>.</strong>
							<span class="notice-card-title" style="font-size: 16px; font-weight: 700; color: var(--lab-ink);"><?php echo htmlspecialchars($row['title']); ?></span>
						</div>
						<button class="notice-toggle-btn readMore">Read</button>
					</div>
					<div class="notice-card-body desc" style="display: none; margin-top: 14px; border-top: 1px dashed var(--lab-line); padding-top: 12px;">
						<p style="font-size: 15px; color: var(--lab-muted); white-space: pre-line; line-height: 1.6; text-align: justify; margin: 0;">
							<?php echo htmlspecialchars($row['description']); ?>
						</p>        
					</div>
				</div>
				<?php $i++; } } ?>
			</div>
		</div>
	</section>

	<?php include('footer.php'); ?>

	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".readMore").click(function() {
				var $this = $(this);
				var $body = $this.closest('.notice-card').find('.notice-card-body');
				$body.slideToggle(200, function() {
					if ($body.is(':visible')) {
						$this.text("Hide");
					} else {
						$this.text("Read");
					}
				});
			});
		});
	</script>
</body>
</html>
