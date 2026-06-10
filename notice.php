<?php

$notice_menu = '';

$notice_num = mysqli_query($db, "SELECT * FROM notice");
$num_rows = mysqli_num_rows($notice_num);

if($num_rows == 0){
    $notice_menu = 'display:none;';
}else{
    $notice_menu = '';
}




?>


<div>
	<nav class="social" style="<?php echo $notice_menu; ?>">
		<ul>
			<li><a href="" data-toggle="modal" data-target="#myModal">Notices <i class="fa fa-bell"></i></a></li>
		</ul>
	</nav>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="background-color: #F44336; color: #fff;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 23px;">Recent Notices</h4>
			</div>
			<div class="modal-body">

				<?php 

    $i = 1;
    $result = mysqli_query($db, "SELECT * FROM notice ORDER BY id DESC limit 5");
    while($row = mysqli_fetch_array($result)){ 

  ?>
				<div class="notice notice-success">

					<strong>
						<?php echo $i; ?> . </strong>

					<span style="padding-right: 100px;">
						<?php echo $row['title']; ?></span>

					<span class="pull-right text-success readMore">Read</span>


					<div class="desc">
						<p style="white-space: pre-line;border-top: 1px solid red;margin: 5px; font-size: 15px;">
							<?php echo $row['description']; ?>
						</p>
					</div>
				</div>
				<?php $i++; } ?>

			</div>
			<div class="modal-footer" style="background-color: #F44336; color: #fff;">
				<a href="all_notices.php" class="btn btn-success">View All</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".readMore").click(function() {
			var This = $(this);
			$(this).next().toggle(function() {
				if (This.text() == "Read") {
					This.text("Hide")
				} else {
					This.text("Read")
				}
			})
		});
	})

</script>
