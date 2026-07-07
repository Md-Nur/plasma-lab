<?php 
$sql_photo = "SELECT * FROM photos";
$sql_video = "SELECT * FROM videos";
$result_photo = mysqli_query($db, $sql_photo);
$result_video = mysqli_query($db, $sql_video);
?>

<section style="margin-top: 80px; padding: 60px 0; background: var(--lab-soft);">
	<div class="container">

		<!-- ── Photos Section ─────────────────────────────── -->
		<div class="title-div text-center" style="margin-bottom: 16px;">
			<h1><span>L</span>ab <span>P</span>hotos</h1>
			<div class="tittle-style"></div>
		</div>
		<p style="text-align: center; color: var(--lab-muted); margin-bottom: 36px; font-size: 15px;">Latest photos from the Plasma Engineering Laboratory</p>

		<div class="gallery-photos-grid">
			<?php while($row_photo = mysqli_fetch_array($result_photo)){ ?>
			<a href="images/gallary/photos/<?php echo $row_photo['image']; ?>" 
			   class="gallery-photo-item"
			   data-fancybox="gallery">
				<img src="images/gallary/photos/<?php echo $row_photo['image']; ?>" 
				     alt="Lab Photo">
				<div class="gallery-photo-overlay">
					<i class="fa fa-search-plus"></i>
				</div>
			</a>
			<?php } ?>
		</div>

		<!-- ── Videos Section ────────────────────────────── -->
		<?php
		$result_video_check = mysqli_query($db, "SELECT COUNT(*) as cnt FROM videos");
		$video_count_row = mysqli_fetch_array($result_video_check);
		if ($video_count_row['cnt'] > 0):
		?>
		<div class="title-div text-center" style="margin-bottom: 16px; margin-top: 72px;">
			<h1><span>L</span>ab <span>V</span>ideos</h1>
			<div class="tittle-style"></div>
		</div>
		<p style="text-align: center; color: var(--lab-muted); margin-bottom: 36px; font-size: 15px;">Research videos and recordings from the laboratory</p>

		<div class="gallery-videos-grid">
			<?php while($row_video = mysqli_fetch_array($result_video)): 
				// Extract YouTube video ID from URL
				$yt_url   = htmlspecialchars($row_video['youtube_url'] ?? '');
				$yt_id    = '';
				if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $row_video['youtube_url'] ?? '', $m)) {
					$yt_id = $m[1];
				}
				$thumb = $yt_id ? "https://img.youtube.com/vi/{$yt_id}/hqdefault.jpg" : 'images/gallary/video/tmp/' . htmlspecialchars($row_video['image'] ?? 'demo_image.png');
			?>
			<!-- Video Card -->
			<div class="gallery-video-card"
			     onclick="openVideoDialog(<?php echo (int)$row_video['id']; ?>)"
			     role="button"
			     tabindex="0"
			     aria-label="Play <?php echo htmlspecialchars($row_video['title']); ?>">
				<div class="gallery-video-thumb">
					<img src="<?php echo $thumb; ?>" 
					     alt="<?php echo htmlspecialchars($row_video['title']); ?>"
					     loading="lazy"
					     onerror="this.src='images/gallary/video/tmp/demo_image.png'">
					<div class="gallery-video-play">
						<span class="gallery-play-btn">
							<i class="fa fa-play"></i>
						</span>
						<div class="gallery-video-badge">
							<i class="fa fa-youtube-play"></i> YouTube
						</div>
					</div>
				</div>
				<div class="gallery-video-info">
					<h4 class="gallery-video-title"><?php echo htmlspecialchars($row_video['title']); ?></h4>
					<p class="gallery-video-desc"><?php echo htmlspecialchars($row_video['info']); ?></p>
				</div>
			</div>

			<!-- Native <dialog> for this video -->
			<dialog id="video-dialog-<?php echo (int)$row_video['id']; ?>"
			        class="modern-dialog video-play-dialog"
			        closedby="any">
				<div class="dialog-header">
					<h3 class="dialog-title">
						<i class="fa fa-play-circle" style="color: var(--lab-teal-dark); margin-right: 8px;"></i>
						<?php echo htmlspecialchars($row_video['title']); ?>
					</h3>
					<button class="dialog-close-btn"
					        onclick="closeVideoDialog(<?php echo (int)$row_video['id']; ?>)"
					        aria-label="Close">&times;</button>
				</div>
				<div class="dialog-body" style="padding: 0; background: #000; line-height: 0;">
					<?php if ($yt_id): ?>
					<div class="video-embed-wrapper">
						<iframe id="yt-frame-<?php echo (int)$row_video['id']; ?>"
						        src="about:blank"
						        data-src="https://www.youtube.com/embed/<?php echo $yt_id; ?>?autoplay=1&rel=0"
						        title="<?php echo htmlspecialchars($row_video['title']); ?>"
						        frameborder="0"
						        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						        allowfullscreen></iframe>
					</div>
					<?php else: ?>
					<div style="padding: 40px; text-align: center; color: #ccc;">
						<i class="fa fa-exclamation-circle" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
						<p style="color: #ccc; font-size: 15px; margin: 0;">No valid YouTube link found for this video.</p>
					</div>
					<?php endif; ?>
				</div>
				<?php if ($row_video['info']): ?>
				<div class="video-dialog-desc">
					<p><?php echo htmlspecialchars($row_video['info']); ?></p>
				</div>
				<?php endif; ?>
				<div class="dialog-footer">
					<?php if ($yt_id): ?>
					<a href="https://www.youtube.com/watch?v=<?php echo $yt_id; ?>"
					   target="_blank"
					   rel="noopener noreferrer"
					   class="btn btn-default"
					   style="display: inline-flex; align-items: center; gap: 6px;">
						<i class="fa fa-youtube-play" style="color: #FF0000;"></i> Open on YouTube
					</a>
					<?php endif; ?>
					<button class="btn btn-danger"
					        onclick="closeVideoDialog(<?php echo (int)$row_video['id']; ?>)">Close</button>
				</div>
			</dialog>

			<?php endwhile; ?>
		</div>
		<?php endif; ?>

	</div>
</section>

<!-- ── Styles ──────────────────────────────────────────── -->
<style>
/* --- Photo Grid --- */
.gallery-photos-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
	gap: 16px;
	margin-bottom: 12px;
}

.gallery-photo-item {
	display: block;
	border-radius: 10px;
	overflow: hidden;
	box-shadow: 0 6px 20px rgba(23,33,47,0.10);
	transition: transform 0.25s ease, box-shadow 0.25s ease;
	position: relative;
}

.gallery-photo-item img {
	width: 100%;
	aspect-ratio: 4/3;
	object-fit: cover;
	display: block;
	transition: transform 0.4s ease;
}

.gallery-photo-overlay {
	position: absolute;
	inset: 0;
	background: rgba(23,33,47,0);
	display: flex;
	align-items: center;
	justify-content: center;
	transition: background 0.25s ease;
}

.gallery-photo-overlay i {
	color: #fff;
	font-size: 28px;
	opacity: 0;
	transform: scale(0.8);
	transition: opacity 0.25s ease, transform 0.25s ease;
}

.gallery-photo-item:hover {
	transform: translateY(-4px);
	box-shadow: 0 16px 40px rgba(23,33,47,0.18);
}

.gallery-photo-item:hover img {
	transform: scale(1.06);
}

.gallery-photo-item:hover .gallery-photo-overlay {
	background: rgba(23,33,47,0.35);
}

.gallery-photo-item:hover .gallery-photo-overlay i {
	opacity: 1;
	transform: scale(1);
}

/* --- Video Grid --- */
.gallery-videos-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
	gap: 24px;
}

.gallery-video-card {
	background: #fff;
	border-radius: 14px;
	overflow: hidden;
	box-shadow: 0 8px 28px rgba(23,33,47,0.10);
	cursor: pointer;
	transition: transform 0.25s ease, box-shadow 0.25s ease;
	outline: none;
}

.gallery-video-card:hover,
.gallery-video-card:focus-visible {
	transform: translateY(-5px);
	box-shadow: 0 18px 44px rgba(23,33,47,0.17);
}

.gallery-video-thumb {
	position: relative;
	aspect-ratio: 16/9;
	overflow: hidden;
	background: #111;
}

.gallery-video-thumb img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
	transition: transform 0.4s ease;
}

.gallery-video-card:hover .gallery-video-thumb img {
	transform: scale(1.05);
}

.gallery-video-play {
	position: absolute;
	inset: 0;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	gap: 8px;
	background: rgba(23,33,47,0.36);
	transition: background 0.25s ease;
}

.gallery-video-card:hover .gallery-video-play {
	background: rgba(23,33,47,0.52);
}

.gallery-play-btn {
	width: 60px;
	height: 60px;
	background: #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	box-shadow: 0 8px 24px rgba(0,0,0,0.25);
	transition: transform 0.25s ease;
}

.gallery-video-card:hover .gallery-play-btn {
	transform: scale(1.1);
}

.gallery-play-btn i {
	color: var(--lab-teal-dark, #1ca7a8);
	font-size: 22px;
	margin-left: 4px;
}

.gallery-video-badge {
	background: rgba(255,0,0,0.85);
	color: #fff;
	font-size: 11px;
	font-weight: 700;
	padding: 3px 10px;
	border-radius: 20px;
	letter-spacing: 0.5px;
}

.gallery-video-info {
	padding: 18px 20px 20px;
}

.gallery-video-title {
	font-size: 16px;
	font-weight: 800;
	color: var(--lab-ink, #17212f);
	margin: 0 0 6px;
	line-height: 1.3;
}

.gallery-video-desc {
	font-size: 13px;
	color: var(--lab-muted, #6b7280);
	margin: 0;
	line-height: 1.5;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}

/* --- Video Dialog --- */
.video-play-dialog {
	max-width: 860px;
	width: calc(100% - 32px);
}

.video-embed-wrapper {
	position: relative;
	width: 100%;
	padding-bottom: 56.25%; /* 16:9 */
	height: 0;
}

.video-embed-wrapper iframe {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
	border: 0;
}

.video-dialog-desc {
	padding: 16px 24px;
	border-top: 1px solid var(--lab-line, #e5e7eb);
}

.video-dialog-desc p {
	font-size: 14px;
	color: var(--lab-muted, #6b7280);
	margin: 0;
	line-height: 1.6;
	text-align: left;
	white-space: normal;
}

/* --- Responsive --- */
@media (max-width: 600px) {
	.gallery-photos-grid {
		grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
		gap: 10px;
	}

	.gallery-videos-grid {
		grid-template-columns: 1fr;
		gap: 16px;
	}

	.video-play-dialog {
		max-width: 100%;
		width: calc(100% - 16px);
		border-radius: 10px;
	}

	.gallery-play-btn {
		width: 48px;
		height: 48px;
	}

	.gallery-play-btn i {
		font-size: 18px;
	}
}

@media (max-width: 400px) {
	.gallery-photos-grid {
		grid-template-columns: 1fr 1fr;
		gap: 8px;
	}
}
</style>

<!-- ── Scripts ─────────────────────────────────────────── -->
<script>
function openVideoDialog(id) {
	var dialog = document.getElementById('video-dialog-' + id);
	if (!dialog) return;
	// Load the iframe src only when opening (lazy load)
	var frame = document.getElementById('yt-frame-' + id);
	if (frame && frame.getAttribute('data-src') && frame.src === 'about:blank') {
		frame.src = frame.getAttribute('data-src');
	}
	dialog.showModal();
}

function closeVideoDialog(id) {
	var dialog = document.getElementById('video-dialog-' + id);
	if (!dialog) return;
	// Pause playback by resetting iframe src
	var frame = document.getElementById('yt-frame-' + id);
	if (frame) {
		frame.src = 'about:blank';
	}
	dialog.close();
}

document.addEventListener('DOMContentLoaded', function() {

	// Keyboard: allow Enter/Space to open video cards
	document.querySelectorAll('.gallery-video-card').forEach(function(card) {
		card.addEventListener('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				card.click();
			}
		});
	});

	// Light-dismiss fallback (backdrop click) for older browsers
	document.querySelectorAll('dialog.video-play-dialog').forEach(function(dialog) {
		dialog.addEventListener('click', function(e) {
			if (e.target !== dialog) return;
			var rect = dialog.getBoundingClientRect();
			var inside = (
				rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
				rect.left <= e.clientX && e.clientX <= rect.left + rect.width
			);
			if (!inside) {
				// Extract ID from dialog element id
				var parts = dialog.id.split('-');
				var id = parseInt(parts[parts.length - 1]);
				if (!isNaN(id)) closeVideoDialog(id);
				else dialog.close();
			}
		});
	});
});
</script>
