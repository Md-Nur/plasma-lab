<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$image = "demo_image.png";

	
$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';



	if(isset($_POST['update'])){

		$name = $_POST['name'];
		$designation = $_POST['designation'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$link = $_POST['link'];
		$info = addslashes($_POST['info']);
		$id = $_POST['id'];
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';

		$result = mysqli_query($db, "SELECT * FROM members WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];

		$fileName = basename($_FILES['image']['name']);



		if (empty($fileName)) {

			$sql_update = mysqli_query($db, "UPDATE members SET name='$name',designation='$designation',phone='$phone',email='$email', info = '$info', link = '$link', status='$status' WHERE id = $id ");

			if ($sql_update === TRUE) {

				$msg = 'Information Updated..';

				$alert_success = '';

			} else {

				 $msg = 'Failed to update..';

				$alert_failed = '';

			}

		}else {
			$tmp_name = $_FILES['image']['tmp_name'];
			$new_name = time().".jpg";

			$result = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image = $row['image'];
			unlink("../images/member/members/".$image);

			if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {

				$sql_update = mysqli_query($db, "UPDATE members SET image='$new_name', name='$name',designation='$designation',phone='$phone',email='$email', info = '$info', link = '$link', status='$status' WHERE id = $id ");

				if ($sql_update === TRUE) {
					$image = $new_name;
					$msg = 'Information Updated..';

				$alert_success = '';


				} else {

					 $msg = 'Failed to update..';

				$alert_failed = '';

				}

			}else {

				$msg = 'Failed to update..';

				$alert_failed = '';

			}

		}

	}
if(isset($_GET['id'])){

	$id = $_GET['id'];
	$result = mysqli_query($db, "SELECT * FROM members WHERE id=$id");
	$row = mysqli_fetch_array($result);
	$image=$row['image'];
	$name=$row['name'];
	$designation=$row['designation'];
	$phone=$row['phone'];
	$email=$row['email'];
	$link=$row['link'];
	$info=$row['info'];
	$status=$row['status'] ?? 'current';
}

?>





<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title pull-left">
				<?php echo $name; ?>
			</h3>
			<a href="page_members.php" class="btn btn-danger pull-right">Go Back</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>
					<?php echo $msg; ?></strong>
			</div>
			<div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>
					<?php echo $msg; ?></strong>
			</div>

			<div class="row">

			<div class="col-md-12">
				<div class="alert alert-info" style="margin-bottom:15px;">
					<strong><i class="fa fa-info-circle"></i> Where does this image appear?</strong><br>
					Updated photos will appear on the public <strong>Members</strong> page of the website.
				</div>
			</div>

			<div class="col-md-4">
					<img id="output" class="img-responsive" src="../images/member/members/<?php echo $image; ?>" style="width:100%;">
				</div>

				<div class="col-md-8">
					<form id="member_t" method="post" action="edit_members.php" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $id; ?>" required>

						<div class="photo_post form-group">
							<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)" />
							<label for="f02">Upload Photo</label><span>Image must be Square Sized (eg. 300*300)</span>
						</div>

						<fieldset class="form-group">
							<label for="name">Full Name:</label>
							<input class="form-control" placeholder="Full Name ...." type="text" name="name" tabindex="1" value="<?php echo $name; ?>" required>
						</fieldset>

						<fieldset class="form-group">
							<label for="designation">Designation:</label>
							<input class="form-control" placeholder="Member Designation...." type="text" name="designation" tabindex="1" value="<?php echo $designation; ?>">
						</fieldset>

						<fieldset class="form-group">
							<label for="phone">Phone No:</label>
							<input class="form-control" placeholder="01XXX-XXXXXX" type="text" name="phone" tabindex="1" value="<?php echo $phone; ?>">
						</fieldset>

						<fieldset class="form-group">
							<label for="email">Email address:</label>
							<input class="form-control" placeholder="example@domain.com" type="text" name="email" tabindex="1" value="<?php echo $email; ?>">
						</fieldset>

						<fieldset class="form-group">
							<label for="member-status">Member Status:</label>
							<select class="form-control" id="member-status" name="status">
								<option value="current" <?php echo ($status == 'current') ? 'selected' : ''; ?>>Current Member</option>
								<option value="alumni"  <?php echo ($status == 'alumni')  ? 'selected' : ''; ?>>Alumni</option>
							</select>
						</fieldset>

						<fieldset class="form-group">
							<label for="email">External Link:</label>
							<input class="form-control" placeholder="http://example.domain?id=something" type="text" name="link" tabindex="1" value="<?php echo $link; ?>">
						</fieldset>

						<fieldset class="form-group">
							<label for="info">Member Info:</label>
							<textarea class="form-control" placeholder="" name="info" rows="10"><?php echo $info; ?></textarea>
						</fieldset>

						<fieldset class="form-group">
							<input onclick="return validateform()" type="submit" name="update" id="update" value="UPDATE" class="btn btn-info" />
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function() {
			var output = document.getElementById('output');
			output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	};

</script>


<script type="text/javascript">
	function validateform() {

		var name = document.forms["member_t"]["name"].value;
		if (name == null || name == "") {
			document.getElementById("result").innerHTML = " Error : Name field must not Empty...";
			return false;
		}

		//		var designation = document.forms["member_t"]["designation"].value;
		// if (designation == null || designation == "") {
		// document.getElementById("result").innerHTML = " Error : Designation field must not Empty...";
		// return false;
		// }
		//
		// var phone = document.forms["member_t"]["phone"].value;
		// if (phone == null || phone == "") {
		// document.getElementById("result").innerHTML = " Error : phone field must not Empty...";
		// return false;
		// }
		//
		// var x = document.forms["member_t"]["email"].value;
		// var atpos = x.indexOf("@");
		// var dotpos = x.lastIndexOf(".");
		//
		//
		// var b = document.forms["member_t"]["email"].value;
		// if (b == null || b == "") {
		// document.getElementById("result").innerHTML = " Error : Email field must be filled...";
		// return false;
		// } else {
		// if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2>= x.length) {
		// document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
		// return false;
		// }
		// }
		//
		// var info = document.forms["member_t"]["info"].value;
		// if (info == null || info == "") {
		// document.getElementById("result").innerHTML = " Error : Write some info about the member...";
		// return false;
		// }

		return (true);
	}

</script>


<?php include('bottom.php'); ?>
