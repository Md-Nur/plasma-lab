<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 
	//im=nitializing variable
	$name = "";
	$info = "";
	$image = "demo_image.png";
	$position = "";
	$work_text = "";
	$work_img = "";
	$id = 0;
	
	$alert_failed = 'display : none';
	$alert_success = 'display : none';
	$msg = '';
	//connect to database
	
	
	//if save btn is clicked
	if(isset($_POST['insert'])){
		
		$name = $_POST['name'];
		$designation = $_POST['designation'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$link = $_POST['link'];
		$info = addslashes($_POST['info']);
		
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";


		if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {

			if ($link=='' || $link == null) {
				$sql = "INSERT INTO members(image , name , info , designation, phone, email) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email')";

				if ($db->query($sql) === TRUE) {

					$msg = 'Member Added..';

				$alert_success = '';

				} else {

					 $msg = 'Failed to add..';

				$alert_failed = '';

				}

			}else {

				$sql = "INSERT INTO members(image , name , info , designation, phone, email, link) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$link')";

				if ($db->query($sql) === TRUE) {

					$msg = 'Member Added..';

				$alert_success = '';

				} else {

					 $msg = 'Failed to add..';

				$alert_failed = '';

				}

			}

				

		}
	
	}


	
	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		
	
		$result = mysqli_query($db, "SELECT * FROM members WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];
		unlink("../images/member/members/".$image);
		mysqli_query($db, "DELETE FROM members WHERE id=$id");
		
		$msg = 'Member Deleted..';

		$alert_success = '';
	}
	
	$result = mysqli_query($db, "SELECT * FROM members");
?>




<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title pull-left">Members</h3>
			<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#insert_teacher">Add Member</button>
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

				<?php while($row = mysqli_fetch_array($result)){ ?>
				<div class="col-md-2 well" style="padding:10px;">
					<img src="../images/member/members/<?php echo $row['image']; ?>" class="img-responsive" style="height:200px; width:100%;" alt="">

					<div class="slider_caption">
						<h4 style="color:green;font-weight:700;font-size:20px;">
							<?php echo $row['name']; ?>
						</h4>
					</div>
					<div class="col-md-6">
						<a href="edit_members.php?id=<?php echo $row['id']; ?>" class="btn btn-success" style="width: 100%;">Edit</a>
					</div>

					<div class="col-md-6">
						<a href="page_members.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" class="btn btn-danger" style="width: 100%;">Delete</a>
					</div>
				</div>
				<?php } ?>

			</div>
		</div>
	</div>
</div>







<div id="insert_teacher" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 60%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Member</h4>

			</div>
			<div class="modal-body">
				<div class="clearfix"></div>
				<div class="alert alert-info" style="margin-bottom:15px;">
					<strong><i class="fa fa-info-circle"></i> Where does this image appear?</strong><br>
					Uploaded photos will appear on the public <strong>Members</strong> page of the website.
				</div>
				<div class="col-md-4">
					<img id="output" class="img-responsive" src="../images/member/members/<?php echo $image; ?>" style="width:100%;height: 300px;" onerror="this.style.display='none'">
				</div>

				<div class="col-md-8">
					<form id="member_t" method="post" action="page_members.php" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $id; ?>" required>

						<div class="photo_post form-group">
							<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)" />
							<label for="f02">Upload Photo</label><span>Image must be Square Sized (eg. 300*300)</span>
						</div>

						<fieldset class="form-group">
							<label for="name">Full Name:</label>
							<input class="form-control" placeholder="Full Name ...." type="text" name="name" tabindex="1" required>
						</fieldset>

						<fieldset class="form-group">
							<label for="designation">Designation:</label>
							<input class="form-control" placeholder="Member Designation...." type="text" name="designation" tabindex="1">
						</fieldset>

						<fieldset class="form-group">
							<label for="phone">Phone No:</label>
							<input class="form-control" placeholder="01XXX-XXXXXX" type="text" name="phone" tabindex="1">
						</fieldset>

						<fieldset class="form-group">
							<label for="email">Email address:</label>
							<input class="form-control" placeholder="example@domain.com" type="text" name="email" tabindex="1">
						</fieldset>

						<fieldset class="form-group">
							<label for="email">External Link: (if Exist)</label>
							<input class="form-control" placeholder="http://example.domain?id=something" type="text" name="link" tabindex="1">
						</fieldset>

						<fieldset class="form-group">
							<label for="info">Member Info:</label>
							<textarea class="form-control" placeholder="" name="info" rows="10"></textarea>
						</fieldset>

						<fieldset class="form-group">
							<input onclick="return validateform()" type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
						</fieldset>
					</form>

				</div>

				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<div class="clearfix"></div>
				<span id="result" class="pull-left" style="color: red; font-size: 18px;"></span>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

		var image = document.forms["member_t"]["image"].value;
		if (image == null || image == "") {
			document.getElementById("result").innerHTML = " Error : Insert a Photo...";
			return false;
		}

		var name = document.forms["member_t"]["name"].value;
		if (name == null || name == "") {
			document.getElementById("result").innerHTML = " Error : Name field must not Empty...";
			return false;
		}

		// var designation = document.forms["member_t"]["designation"].value;
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

		var x = document.forms["member_t"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");


		var b = document.forms["member_t"]["email"].value;
		if (b == null || b == "") {
			//			document.getElementById("result").innerHTML = " Error : Email field must be filled...";
			//			return false;
		} else {
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
				document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
				return false;
			}
		}



		// var info = document.forms["member_t"]["info"].value;
		// if (info == null || info == "") {
		// document.getElementById("result").innerHTML = " Error : Write some info about the member...";
		// return false;
		// }

		return (true);
	}

</script>


<script>
	function deleletconfig() {

		var del = confirm("Are you sure you want to delete this record?");
		if (del == true) {
			alert("record deleted")
		}
		return del;
	}

</script>




<?php include('bottom.php'); ?>
