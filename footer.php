<button class="btn-back-to-top" id="myBtn" aria-label="Back to top">
	<i class="fa fa-angle-double-up" aria-hidden="true"></i>
</button>

<section class="footer">
	<div class="copyright text-center">
		<p style="text-align: center; color: rgba(255,255,255,0.85); font-size: 14px; margin: 0;">
			&copy; <?php echo date('Y'); ?> <?php echo $site_row['sitename']; ?>. All rights reserved. | Designed by
			<a href="http://www.facebook.com/adntechbd" target="_blank" style="color: #fff; font-weight: 700;">Ad&Tech <small style="font-size:10px; opacity: 0.8;">MULTIMEDIA</small></a>
		</p>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		var windowH = $(window).height() / 2;

		$(window).on('scroll', function() {
			if ($(this).scrollTop() > windowH) {
				$("#myBtn").css('display', 'flex');
			} else {
				$("#myBtn").css('display', 'none');
			}
		});

		$('#myBtn').on("click", function() {
			$('html, body').animate({
				scrollTop: 0
			}, 300);
		});
	});
</script>
