<?php 
$sql_photo = "SELECT * FROM photos";
$sql_video = "SELECT * FROM videos";
$result_photo = mysqli_query($db, $sql_photo);
$result_video = mysqli_query($db, $sql_video);
?>

<section style="margin-top: 80px; padding: 60px 0; background: var(--lab-soft);">
	<div class="container">

		<!-- Photos Section -->
		<div class="title-div text-center" style="margin-bottom: 16px;">
			<h1><span>L</span>ab <span>P</span>hotos</h1>
			<div class="tittle-style"></div>
		</div>
		<p style="text-align: center; color: var(--lab-muted); margin-bottom: 36px; font-size: 15px;">Latest photos from the Plasma Science & Technology Laboratory</p>

		<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; margin-bottom: 72px;">
			<?php while($row_photo = mysqli_fetch_array($result_photo)){ ?>
			<a href="images/gallary/photos/<?php echo $row_photo['image']; ?>" 
			   class="gallery-photo-item"
			   data-fancybox="gallery"
			   style="display: block; border-radius: 10px; overflow: hidden; box-shadow: 0 8px 24px rgba(23,33,47,0.1); transition: transform 0.25s ease, box-shadow 0.25s ease;">
				<img src="images/gallary/photos/<?php echo $row_photo['image']; ?>" 
				     alt="Lab Photo" 
				     style="width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block; transition: transform 0.45s ease;">
			</a>
			<?php } ?>
		</div>

		<!-- Videos Section -->
		<?php
		$result_video_check = mysqli_query($db, "SELECT COUNT(*) as cnt FROM videos");
		$video_count_row = mysqli_fetch_array($result_video_check);
		if ($video_count_row['cnt'] > 0):
		?>
		<div class="title-div text-center" style="margin-bottom: 16px;">
			<h1><span>L</span>ab <span>V</span>ideos</h1>
			<div class="tittle-style"></div>
		</div>
		<p style="text-align: center; color: var(--lab-muted); margin-bottom: 36px; font-size: 15px;">Research videos and recordings from the laboratory</p>

		<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
			<?php while($row_video = mysqli_fetch_array($result_video)){ ?>
			<div class="video-card" 
			     onclick="document.getElementById('video-dialog-<?php echo $row_video['id']; ?>').showModal();"
			     style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 28px rgba(23,33,47,0.1); cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;">
				<div style="position: relative; aspect-ratio: 16/9; overflow: hidden;">
					<img src="images/gallary/video/tmp/<?php echo $row_video['image']; ?>" 
					     alt="Video Thumbnail"
					     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.45s ease;">
					<div style="position: absolute; inset: 0; background: rgba(23,33,47,0.38); display: flex; align-items: center; justify-content: center; transition: background 0.25s ease;">
						<span style="width: 56px; height: 56px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(0,0,0,0.18);">
							<i class="fa fa-play" style="color: var(--lab-teal-dark); font-size: 20px; margin-left: 4px;"></i>
						</span>
					</div>
				</div>
				<div style="padding: 18px;">
					<h4 style="font-size: 16px; font-weight: 800; color: var(--lab-ink); margin: 0 0 8px;"><?php echo htmlspecialchars($row_video['title']); ?></h4>
					<p style="font-size: 13px; color: var(--lab-muted); margin: 0; line-height: 1.5;"><?php echo htmlspecialchars($row_video['info']); ?></p>
				</div>
			</div>

			<!-- Native dialog for video -->
			<dialog id="video-dialog-<?php echo $row_video['id']; ?>" closedby="any" class="modern-dialog" style="max-width: 720px;">
				<div class="dialog-header">
					<h3 class="dialog-title"><?php echo htmlspecialchars($row_video['title']); ?></h3>
					<button class="dialog-close-btn" 
					        onclick="var v = document.getElementById('video-dialog-<?php echo $row_video['id']; ?>'); v.querySelector('video').pause(); v.close();"
					        aria-label="Close">&times;</button>
				</div>
				<div class="dialog-body" style="padding: 0; background: #000;">
					<video width="100%" controls style="display: block; max-height: 480px;">
						<source src="images/gallary/video/<?php echo $row_video['video']; ?>" type="video/mp4">
					</video>
				</div>
				<div class="dialog-footer">
					<button class="btn btn-danger" 
					        onclick="var v = document.getElementById('video-dialog-<?php echo $row_video['id']; ?>'); v.querySelector('video').pause(); v.close();">Close</button>
				</div>
			</dialog>
			<?php } ?>
		</div>
		<?php endif; ?>

	</div>
</section>

<style>
.gallery-photo-item:hover {
	transform: translateY(-4px);
	box-shadow: 0 16px 40px rgba(23,33,47,0.18) !important;
}
.gallery-photo-item:hover img {
	transform: scale(1.05);
}
.video-card:hover {
	transform: translateY(-4px);
	box-shadow: 0 16px 40px rgba(23,33,47,0.18) !important;
}
</style>

<script>
$(document).ready(function() {
	// Light-dismiss fallback for video dialogs
	document.querySelectorAll('dialog[closedby="any"]').forEach(function(dialog) {
		if (!('closedBy' in HTMLDialogElement.prototype)) {
			dialog.addEventListener('click', function(event) {
				if (event.target !== dialog) return;
				var rect = dialog.getBoundingClientRect();
				var isInside = (
					rect.top <= event.clientY &&
					event.clientY <= rect.top + rect.height &&
					rect.left <= event.clientX &&
					event.clientX <= rect.left + rect.width
				);
				if (!isInside) {
					var video = dialog.querySelector('video');
					if (video) video.pause();
					dialog.close();
				}
			});
		}
	});
});
</script>

