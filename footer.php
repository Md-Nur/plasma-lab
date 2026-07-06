<button class="btn-back-to-top" id="myBtn" aria-label="Back to top">
	<i class="fa fa-angle-double-up" aria-hidden="true"></i>
</button>

<a href="/dashboard/" class="btn-dashboard-link" id="dashboardBtn" aria-label="Go to Dashboard" title="Admin Dashboard">
	<i class="fa fa-tachometer" aria-hidden="true"></i>
</a>

<section class="footer">
	<div class="copyright text-center">
		<p style="text-align: center; color: rgba(255,255,255,0.85); font-size: 14px; margin: 0;">
			&copy; <?php echo date('Y'); ?> <?php echo $site_row['sitename']; ?>. All rights reserved. | Designed by
			<a href="http://www.codencognition.com" target="_blank" style="color: #fff; font-weight: 700;">Code & Cognition</a>
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
