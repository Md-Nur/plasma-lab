<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$alert_failed  = 'display:none';
$alert_success = 'display:none';
$msg = '';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: page_videos.php'); exit; }

$result = mysqli_query($db, "SELECT * FROM videos WHERE id=$id");
$row    = mysqli_fetch_array($result);
if (!$row) { header('Location: page_videos.php'); exit; }

$youtube_url = $row['youtube_url'] ?? '';
$title       = $row['title'];
$info        = $row['info'];

// ── Handle Update ─────────────────────────────────────────────────────────────
if (isset($_POST['update'])) {
	$new_title       = trim($_POST['title']);
	$new_info        = trim($_POST['info']);
	$new_youtube_url = trim($_POST['youtube_url']);

	if (empty($new_title)) {
		$msg = 'Error: Video title is required.';
		$alert_failed = '';
	} elseif (empty($new_youtube_url)) {
		$msg = 'Error: YouTube link is required.';
		$alert_failed = '';
	} elseif (!preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $new_youtube_url)) {
		$msg = 'Error: Please enter a valid YouTube URL.';
		$alert_failed = '';
	} else {
		$title_e       = mysqli_real_escape_string($db, $new_title);
		$info_e        = mysqli_real_escape_string($db, $new_info);
		$youtube_url_e = mysqli_real_escape_string($db, $new_youtube_url);

		$sql = mysqli_query($db, "UPDATE videos SET title='$title_e', info='$info_e', youtube_url='$youtube_url_e' WHERE id=$id");
		if ($sql) {
			$msg = 'Video updated successfully!';
			$alert_success = '';
			// Refresh local variables
			$title       = $new_title;
			$info        = $new_info;
			$youtube_url = $new_youtube_url;
		} else {
			$msg = 'Database error: ' . mysqli_error($db);
			$alert_failed = '';
		}
	}
}

// Extract YouTube ID for preview
$yt_id = '';
if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $youtube_url, $m)) {
	$yt_id = $m[1];
}

?>


<div style="max-width: 860px; margin: 50px auto; padding: 0 15px;">

	<!-- Alerts -->
	<div style="<?php echo $alert_success; ?>" class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<strong><?php echo htmlspecialchars($msg); ?></strong>
	</div>
	<div style="<?php echo $alert_failed; ?>" class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<strong><?php echo htmlspecialchars($msg); ?></strong>
	</div>

	<!-- Page card -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa fa-pencil" style="margin-right:6px;"></i> Edit Video
			</h3>
		</div>
		<div class="panel-body">

			<div class="alert alert-info">
				<i class="fa fa-info-circle"></i>
				<strong>Tip:</strong> Update the YouTube link below. The embedded player and thumbnail will update automatically everywhere on the site.
			</div>

			<div class="edit-video-layout">

				<!-- Left: Preview -->
				<div class="edit-video-preview">
					<label style="font-weight:700; margin-bottom:8px; display:block;">
						<i class="fa fa-youtube-play" style="color:#FF0000;margin-right:5px;"></i> Current Video
					</label>
					<?php if ($yt_id): ?>
					<div class="edit-video-embed">
						<iframe id="edit_preview_frame"
						        src="https://www.youtube.com/embed/<?php echo htmlspecialchars($yt_id); ?>?rel=0"
						        frameborder="0"
						        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						        allowfullscreen></iframe>
					</div>
					<a href="https://www.youtube.com/watch?v=<?php echo htmlspecialchars($yt_id); ?>"
					   target="_blank"
					   rel="noopener noreferrer"
					   class="btn btn-default btn-block"
					   style="margin-top:10px; text-align:center;">
						<i class="fa fa-external-link" style="margin-right:5px;"></i> Open on YouTube
					</a>
					<?php else: ?>
					<div style="background:#111; border-radius:8px; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; color:#888;">
						<div style="text-align:center;">
							<i class="fa fa-youtube-play" style="font-size:48px; display:block; margin-bottom:12px;"></i>
							No valid YouTube URL set
						</div>
					</div>
					<?php endif; ?>
				</div>

				<!-- Right: Form -->
				<div class="edit-video-form">
					<form id="edit_video_form"
					      method="post"
					      action="edit_videos.php?id=<?php echo $id; ?>"
					      onsubmit="return validateEditForm()">

						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="form-group">
							<label for="edit_youtube_url">
								<i class="fa fa-youtube-play" style="color:#FF0000;margin-right:4px;"></i>
								YouTube Video URL <span style="color:#e84b3a;">*</span>
							</label>
							<input type="url"
							       class="form-control"
							       id="edit_youtube_url"
							       name="youtube_url"
							       value="<?php echo htmlspecialchars($youtube_url); ?>"
							       placeholder="https://www.youtube.com/watch?v=..."
							       required>
							<span class="help-block">Accepted: youtube.com/watch?v=... or youtu.be/...</span>
						</div>

						<div class="form-group">
							<label for="edit_title">Video Title <span style="color:#e84b3a;">*</span></label>
							<input type="text"
							       class="form-control"
							       id="edit_title"
							       name="title"
							       value="<?php echo htmlspecialchars($title); ?>"
							       placeholder="Enter a descriptive title..."
							       required>
						</div>

						<div class="form-group">
							<label for="edit_info">Description</label>
							<textarea class="form-control"
							          id="edit_info"
							          name="info"
							          rows="4"
							          placeholder="Brief description of the video (optional)..."><?php echo htmlspecialchars($info); ?></textarea>
						</div>

						<span id="edit_result" style="color:#e84b3a; font-size:13px; display:block; margin-bottom:10px;"></span>

						<div style="display:flex; gap:10px; flex-wrap:wrap;">
							<button type="submit" name="update" class="btn btn-success">
								<i class="fa fa-save" style="margin-right:5px;"></i> Update Video
							</button>
							<a href="page_videos.php" class="btn btn-default">
								<i class="fa fa-arrow-left" style="margin-right:5px;"></i> Back to Videos
							</a>
						</div>
					</form>
				</div>

			</div><!-- /.edit-video-layout -->
		</div>
	</div>
</div>


<style>
.edit-video-layout {
	display: flex;
	gap: 28px;
	flex-wrap: wrap;
}

.edit-video-preview {
	flex: 1 1 300px;
	min-width: 260px;
}

.edit-video-form {
	flex: 2 1 380px;
	min-width: 280px;
}

.edit-video-embed {
	position: relative;
	width: 100%;
	padding-bottom: 56.25%;
	height: 0;
	background: #000;
	border-radius: 8px;
	overflow: hidden;
}

.edit-video-embed iframe {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
	border: 0;
}

@media (max-width: 600px) {
	.edit-video-layout { flex-direction: column; gap: 18px; }
	.edit-video-preview,
	.edit-video-form    { min-width: 0; flex: 1 1 100%; }
}
</style>


<script>
// Live URL → preview update
(function() {
	var urlInput = document.getElementById('edit_youtube_url');
	var frame    = document.getElementById('edit_preview_frame');
	if (!urlInput || !frame) return;

	function extractYtId(url) {
		var m = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/);
		return m ? m[1] : null;
	}

	var timer;
	urlInput.addEventListener('input', function() {
		clearTimeout(timer);
		timer = setTimeout(function() {
			var id = extractYtId(urlInput.value.trim());
			if (id) {
				frame.src = 'https://www.youtube.com/embed/' + id + '?rel=0';
			}
		}, 700);
	});
})();

function validateEditForm() {
	var url   = document.getElementById('edit_youtube_url').value.trim();
	var title = document.getElementById('edit_title').value.trim();
	var res   = document.getElementById('edit_result');

	if (!url) { res.textContent = 'Please enter a YouTube URL.'; return false; }
	if (!url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/)) {
		res.textContent = 'Please enter a valid YouTube URL.'; return false;
	}
	if (!title) { res.textContent = 'Please enter a video title.'; return false; }
	res.textContent = '';
	return true;
}
</script>

<?php include('bottom.php'); ?>