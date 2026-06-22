<?php

$notice_num = mysqli_query($db, "SELECT * FROM notice");
$num_rows = mysqli_num_rows($notice_num);
$notice_menu = ($num_rows == 0) ? 'display:none;' : '';

?>

<div>
	<nav class="social" style="<?php echo $notice_menu; ?>">
		<ul>
			<li><a href="#" onclick="document.getElementById('notice-dialog').showModal(); return false;">Notices <i class="fa fa-bell"></i></a></li>
		</ul>
	</nav>
</div>

<!-- Dialog -->
<dialog id="notice-dialog" closedby="any" class="modern-dialog">
	<div class="dialog-header notice-header">
		<h3 class="dialog-title">Recent Notices</h3>
		<button class="dialog-close-btn" onclick="document.getElementById('notice-dialog').close();" aria-label="Close dialog">&times;</button>
	</div>
	<div class="dialog-body">
		<?php 
		$i = 1;
		$result = mysqli_query($db, "SELECT * FROM notice ORDER BY id DESC LIMIT 5");
		while($row = mysqli_fetch_array($result)){ 
		?>
		<div class="notice-card">
			<div class="notice-card-header">
				<strong><?php echo $i; ?>.</strong>
				<span class="notice-card-title"><?php echo htmlspecialchars($row['title']); ?></span>
				<button class="notice-toggle-btn readMore">Read</button>
			</div>
			<div class="notice-card-body desc" style="display: none;">
				<p><?php echo htmlspecialchars($row['description']); ?></p>
			</div>
		</div>
		<?php $i++; } ?>
	</div>
	<div class="dialog-footer notice-footer">
		<a href="all_notices.php" class="btn btn-primary">View All</a>
		<button class="btn btn-danger" onclick="document.getElementById('notice-dialog').close();">Close</button>
	</div>
</dialog>

<script type="text/javascript">
	$(document).ready(function() {
		// Fallback for browsers without closedby support
		const dialog = document.getElementById('notice-dialog');
		if (dialog && !('closedBy' in HTMLDialogElement.prototype)) {
			dialog.addEventListener('click', (event) => {
				if (event.target !== dialog) return;
				const rect = dialog.getBoundingClientRect();
				const isInside = (
					rect.top <= event.clientY &&
					event.clientY <= rect.top + rect.height &&
					rect.left <= event.clientX &&
					event.clientX <= rect.left + rect.width
				);
				if (!isInside) dialog.close();
			});
		}

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
