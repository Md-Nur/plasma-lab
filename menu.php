<header class="navbar navbar-default navbar-doublerow navbar-trans navbar-fixed-top">
	<!-- top nav -->
	<nav class="navbar navbar-top hidden-xs">
		<div class="container-fluid">
			<!-- left nav top -->
			<ul class="nav navbar-nav">
				<li><a href="http://www.ru.ac.bd/" target="_blank"><span class="top_menu_hover"><img src="images/ru_logo.png" style="width: 22px;"> <b>
								<?php echo $site_row['university']; ?>
							</b></span></a></li>
				<li><a href="http://www.ru.ac.bd/eee/" target="_blank"><span class="top_menu_hover"><span class="fa fa-envelope"></span> <b>:
								<?php echo $site_row['department']; ?>
							</b></span></a></li>
			</ul>

		</div>
	</nav>
	<!-- down nav -->
	<nav class="navbar navbar-down">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">
					<?php echo $site_row['sitename']; ?> <br>
					<span>Founded by: <?php echo $site_row['founder']; ?></span>
				</a>

			</div>

			<div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="index.php" class="">Home</a>
					</li>
					<li>
						<a href="about.php" class="e">Lab Members</a>
					</li>
					<li>
						<a href="research.php" class="">Research</a>
					</li>
					<li>
						<a href="publication.php" class="">Publications</a>
					</li>
					<li>
						<a href="gallary.php" class="">Gallary</a>
					</li>
					<li>
						<a href="" data-toggle="modal" data-target="#contact" class="">Contact Us</a>
					</li>
				</ul>

			</div>
		</div>
	</nav>

</header>

<?php include('message.php'); ?>

<script src="js/menu.js"></script>
