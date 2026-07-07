
<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

//initializing variables
$title = "";
$info  = "";
$youtube_url = "";
$image = "demo_image.png";
$id    = 0;
$alert_failed  = 'display:none';
$alert_success = 'display:none';
$msg = '';

// ── Insert new video ─────────────────────────────────────────────────────────
if (isset($_POST['insert'])) {
	$title       = trim($_POST['title']);
	$info        = trim($_POST['info']);
	$youtube_url = trim($_POST['youtube_url']);

	if (empty($title)) {
		$msg = 'Error: Video title is required.';
		$alert_failed = '';
	} elseif (empty($youtube_url)) {
		$msg = 'Error: YouTube link is required.';
		$alert_failed = '';
	} elseif (!preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $youtube_url)) {
		$msg = 'Error: Please enter a valid YouTube URL (e.g. https://www.youtube.com/watch?v=XXXXXXXXXXX).';
		$alert_failed = '';
	} else {
		$title_e       = mysqli_real_escape_string($db, $title);
		$info_e        = mysqli_real_escape_string($db, $info);
		$youtube_url_e = mysqli_real_escape_string($db, $youtube_url);

		$sql = mysqli_query($db, "INSERT INTO videos (title, info, youtube_url, image) VALUES ('$title_e', '$info_e', '$youtube_url_e', 'demo_image.png')");
		if ($sql) {
			$msg = 'Video added successfully!';
			$alert_success = '';
			$title = $info = $youtube_url = '';
		} else {
			$msg = 'Database error: ' . mysqli_error($db);
			$alert_failed = '';
		}
	}
}

// ── Delete video ─────────────────────────────────────────────────────────────
if (isset($_GET['del'])) {
	$del_id = (int)$_GET['del'];
	mysqli_query($db, "DELETE FROM videos WHERE id=$del_id");
	$msg = 'Video deleted.';
	$alert_success = '';
}

?>

<!-- ── Page content ──────────────────────────────────────────────────────── -->
<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title pull-left"><i class="fa fa-youtube-play" style="margin-right:6px;color:#FF0000;"></i> Gallery: Videos</h3>
			<button type="button" class="pull-right btn btn-info" data-toggle="modal" data-target="#insert_videos_modal">
				<i class="fa fa-plus" style="margin-right:5px;"></i> Add Video
			</button>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">

			<!-- Alerts -->
			<div style="<?php echo $alert_success; ?>" class="alert alert-success col-sm-12">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
				<strong><?php echo htmlspecialchars($msg); ?></strong>
			</div>
			<div style="<?php echo $alert_failed; ?>" class="alert alert-danger col-sm-12">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
				<strong><?php echo htmlspecialchars($msg); ?></strong>
			</div>

			<!-- Video Cards Grid -->
			<div class="videos-grid">
				<?php
				$result_video = mysqli_query($db, "SELECT * FROM videos ORDER BY id DESC");
				while ($row_video = mysqli_fetch_array($result_video)):
					// Auto-generate YouTube thumbnail
					$yt_id = '';
					if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([A-Za-z0-9_\-]{11})/', $row_video['youtube_url'] ?? '', $m)) {
						$yt_id = $m[1];
					}
					$thumb = $yt_id
						? "https://img.youtube.com/vi/{$yt_id}/hqdefault.jpg"
						: ("../images/gallary/video/tmp/" . htmlspecialchars($row_video['image'] ?? 'demo_image.png'));
				?>
				<div class="video-card">
					<!-- Thumbnail / Preview trigger -->
					<a href="<?php echo $yt_id ? 'https://www.youtube.com/watch?v='.$yt_id : '#'; ?>"
					   target="_blank" rel="noopener noreferrer"
					   style="display:block; position:relative; line-height:0; text-decoration:none;">
						<img src="<?php echo $thumb; ?>"
						     alt="<?php echo htmlspecialchars($row_video['title']); ?>"
						     onerror="this.src='../images/gallary/video/tmp/demo_image.png'">
						<span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
						             background:rgba(0,0,0,0.3); opacity:0; transition:opacity .2s;"
						      class="vid-thumb-overlay">
							<i class="fa fa-youtube-play" style="font-size:40px;color:#fff;"></i>
						</span>
					</a>
					<div class="video-card__body">
						<div class="video-card__title"><?php echo htmlspecialchars($row_video['title']); ?></div>
						<p class="video-card__info"><?php echo htmlspecialchars($row_video['info']); ?></p>
						<?php if (!empty($row_video['youtube_url'])): ?>
						<p style="font-size:11px;margin:0 0 8px;word-break:break-all;opacity:0.6;">
							<i class="fa fa-link" style="margin-right:4px;"></i>
							<?php echo htmlspecialchars($row_video['youtube_url']); ?>
						</p>
						<?php endif; ?>
						<div class="video-card__actions">
							<a class="btn btn-info" href="edit_videos.php?id=<?php echo (int)$row_video['id']; ?>">
								<i class="fa fa-pencil"></i> Edit
							</a>
							<a class="btn btn-danger"
							   href="page_videos.php?del=<?php echo (int)$row_video['id']; ?>"
							   onclick="return confirm('Delete this video?')">
								<i class="fa fa-trash"></i> Delete
							</a>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div><!-- /.videos-grid -->

		</div>
	</div>
</div>


<!-- ── Insert Modal ───────────────────────────────────────────────────────── -->
<div id="insert_videos_modal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="max-width:580px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<i class="fa fa-youtube-play" style="color:#FF0000;margin-right:8px;"></i>
					Add YouTube Video
				</h4>
			</div>
			<form id="insert_video_form" method="post" action="page_videos.php" onsubmit="return validateInsertForm()">
				<div class="modal-body">

					<div class="alert alert-info">
						<i class="fa fa-info-circle"></i>
						<strong>How it works:</strong> Paste a YouTube video link below. The video thumbnail and embed will be automatically generated from the link. Videos appear in the public <strong>Gallery &rarr; Videos</strong> section and on the home page.
					</div>

					<div class="form-group">
						<label for="ins_youtube_url">
							<i class="fa fa-youtube-play" style="color:#FF0000;margin-right:4px;"></i>
							YouTube Video URL <span style="color:#e84b3a;">*</span>
						</label>
						<input type="url"
						       class="form-control"
						       id="ins_youtube_url"
						       name="youtube_url"
						       placeholder="https://www.youtube.com/watch?v=..."
						       required>
						<span class="help-block">Accepted formats: youtube.com/watch?v=... or youtu.be/...</span>
					</div>

					<!-- Live Preview -->
					<div id="yt_preview_wrap" style="display:none; margin-bottom:16px;">
						<label>Preview</label>
						<div style="position:relative;width:100%;padding-bottom:56.25%;height:0;background:#000;border-radius:6px;overflow:hidden;">
							<iframe id="yt_preview_frame"
							        src=""
							        frameborder="0"
							        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
							        allowfullscreen
							        style="position:absolute;inset:0;width:100%;height:100%;"></iframe>
						</div>
					</div>

					<div class="form-group">
						<label for="ins_title">Video Title <span style="color:#e84b3a;">*</span></label>
						<input type="text"
						       class="form-control"
						       id="ins_title"
						       name="title"
						       placeholder="Enter a descriptive title..."
						       required>
					</div>

					<div class="form-group">
						<label for="ins_info">Description</label>
						<textarea class="form-control"
						          id="ins_info"
						          name="info"
						          rows="3"
						          placeholder="Brief description of the video (optional)..."></textarea>
					</div>

					<span id="insert_result" style="color:#e84b3a;font-size:13px;"></span>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="insert" class="btn btn-success">
						<i class="fa fa-plus" style="margin-right:5px;"></i> Add Video
					</button>
				</div>
			</form>
		</div>
	</div>
</div>


<style>
.vid-thumb-overlay { cursor: pointer; }
.video-card:hover .vid-thumb-overlay { opacity: 1 !important; }
</style>

<script>
// Live YouTube preview inside the insert modal
(function() {
	var urlInput = document.getElementById('ins_youtube_url');
	var previewWrap = document.getElementById('yt_preview_wrap');
	var previewFrame = document.getElementById('yt_preview_frame');

	if (!urlInput) return;

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
				previewFrame.src = 'https://www.youtube.com/embed/' + id + '?rel=0';
				previewWrap.style.display = 'block';
			} else {
				previewFrame.src = '';
				previewWrap.style.display = 'none';
			}
		}, 600);
	});
})();

function validateInsertForm() {
	var url   = document.getElementById('ins_youtube_url').value.trim();
	var title = document.getElementById('ins_title').value.trim();
	var res   = document.getElementById('insert_result');

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