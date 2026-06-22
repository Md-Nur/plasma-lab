<header class="navbar navbar-default navbar-trans navbar-fixed-top">
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
				<div class="logo-container">
					<img src="images/ru_logo.png" alt="RU Logo" class="brand-logo">
					<div class="brand-text">
						<span class="brand-title"><?php echo $site_row['sitename']; ?></span>
						<span class="brand-sub"><?php echo $site_row['university']; ?> • <?php echo $site_row['department']; ?></span>
					</div>
				</div>
			</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="about.php">Lab Members</a>
				</li>
				<li>
					<a href="research.php">Research</a>
				</li>
				<li>
					<a href="publication.php">Publications</a>
				</li>
				<li>
					<a href="gallary.php">Gallery</a>
				</li>
				<li>
					<a href="#" onclick="document.getElementById('contact-dialog').showModal(); return false;">Contact Us</a>
				</li>
			</ul>
		</div>
	</div>
</header>

<?php include('message.php'); ?>

