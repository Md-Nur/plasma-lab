<div class="btn-back-to-top bg0-hov" id="myBtn">
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<span class="symbol-btn-back-to-top">
		<i class="fa fa-angle-double-up" aria-hidden="true"></i>
	</span>
</div>

<script type="text/javascript">
	/*[ Back to top ]
    ===========================================================*/
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

</script>



<section class="footer">
	<div class="copyright text-center">
		<p style="text-align: center;">
			<?php  echo $site_row['sitename']; ?>. All rights reserved | Designed by
			<a href="http://www.facebook.com/adntechbd" target="_blank">© Ad&Tech <small style="font-size:10px;">MULTIMEDIA</small></a>
		</p>
	</div>

</section>
