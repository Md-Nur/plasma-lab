<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="zxx">

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

	<section class="publications">
		<div class="container" style="margin-top: 85px;">

			<ul class="nav nav-tabs">
				<li > <a href="https://scholar.google.com/citations?hl=en&user=0RI4jGUAAAAJ&view_op=list_works&sortby=pubdate" target="_blank" >Publications (Journal)</a></li>
				<li><a data-toggle="tab" href="#menu1">Publications (Conference)</a></li>
			</ul>

			<div class="tab-content" style="margin-top: 30px;">
				<div id="home" class="tab-pane fade in active">
					<?php
				$i=1;
				$result_jur = mysqli_query($db, "SELECT * FROM journal ORDER BY id DESC");
			?>
					<div class="container top-bottom">
							<!-- Bootstrap <table class="table table-hover">
							<?php while($row_jur = mysqli_fetch_array($result_jur)){ ?>
							<tr>
								<td>
									<?php echo $i; ?>
								</td>
								<td style=text-align: justify;">
									<?php echo $row_jur['journal'] ?>
								</td>
							</tr>
							<?php $i++; } ?>
						</table>
					</div>
					 -->
				</div>
				<div id="menu1" class="tab-pane fade">
					<?php
	      	 	$j=1;
				$result_con = mysqli_query($db, "SELECT * FROM conference ORDER BY id DESC");
			?>
					<div class="container top-bottom">
						<table class="table table-hover">
							<?php while($row_con = mysqli_fetch_array($result_con)){ ?>
							<tr>
								<td>
									<?php echo $j; ?>
								</td>
								<td style="text-align: justify;">
									<?php echo $row_con['conference'] ?>
								</td>
							</tr>
							<?php $j++; } ?>
						</table>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php include('notice.php'); ?>

	<?php include('footer.php'); ?>

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.flexisel.js"></script>
	<script src="js/easing.js"></script>
</body>

</html>
