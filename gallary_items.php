<?php 

	$sql_photo = "SELECT * FROM photos";
	$sql_video = "SELECT * FROM videos";
	$result_photo = mysqli_query($db, $sql_photo);
	$result_video = mysqli_query($db, $sql_video);

?>

<section class="wrap" style="margin-top: 85px;">

	<div class="clear"> </div>
	<div class="content">
		<div class="left-content">
			<div class="searchbar">
				<div class="search-left">
					<p>Latest Photos From Plasma Laboratory</p>
				</div>
				<div class="clear"> </div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<ul class="grid effect" id="grid">
						<?php while($row_photo = mysqli_fetch_array($result_photo)){ ?>
						<li>
							<div style="overflow:hidden;"><a data-fancybox="gallery" href="images/gallary/photos/<?php echo $row_photo['image']; ?>"><img src="images/gallary/photos/<?php echo $row_photo['image']; ?>" alt="<?php echo $row_photo['image']; ?>" /></a></div>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<div class="clear"> </div>
		</div>

		<div class="right-content">
			<div class="clearfix"></div>
			<div class="popular " style="padding: 15px;">
				<p>Laboratory Videos</p>
				<div class="clear"> </div>
			</div>
			<div class="clearfix"></div>


			<div class="clear"> </div>
			<?php 
				$sql = "SELECT * FROM videos";
				$result = mysqli_query($db, $sql);
			?>
			<div class="Recent-Vodeos">

				<?php while($row_video = mysqli_fetch_array($result_video)){ ?>
				<div class="video1" data-toggle="modal" data-target="#myModal<?php echo $row_video['id']; ?>">
					<img src="images/gallary/video/tmp/<?php echo $row_video['image']; ?>" title="video2" />
					<span style="color:#6FA2E2;">
						<?php echo $row_video['title']; ?></span>
					<p>
						<?php echo $row_video['info']; ?>
					</p>
					<div class="clear"> </div>
				</div>


				<div id="myModal<?php echo $row_video['id']; ?>" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<video width="100%" height="" controls>
									<source src="images/gallary/video/<?php echo $row_video['video']; ?>" type="video/mp4">
								</video>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>

			</div>
		</div>
	</div>
	<div class="clear"> </div>
</section>
