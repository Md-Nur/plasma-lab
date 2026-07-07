<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';
$image = "demo_image.png";

	if(isset($_POST['update'])){

		$name = $_POST['name'];
		$session = $_POST['session'];
		$email = $_POST['email'];
		$id = $_POST['id'];
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';

		$result = mysqli_query($db, "SELECT * FROM students WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];

		$fileName = basename($_FILES['image']['name']);



		if (empty($fileName)) {

			$sql_update = mysqli_query($db, "UPDATE students SET name='$name',session='$session',email='$email',status='$status' WHERE id = $id ");

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

			$result = mysqli_query($db, "SELECT * FROM students WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image = $row['image'];
			unlink("../images/member/students/".$image);

			if (move_uploaded_file($tmp_name, "../images/member/students/".$new_name)) {

				$sql_update = mysqli_query($db, "UPDATE students SET image='$new_name',name='$name',session='$session',email='$email',status='$status' WHERE id = $id ");

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

	$result = mysqli_query($db, "SELECT * FROM students WHERE id=$id");
	$row = mysqli_fetch_array($result);
	$image=$row['image'];
	$name=$row['name'];
	$session=$row['session'];
	$email=$row['email'];
	$status=$row['status'] ?? 'current';
}

?>




	


<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title pull-left"><?php echo $name; ?></h3>
		  <a href="page_students.php" class="btn btn-danger pull-right">Go Back</a>
		  <div class="clearfix"></div>
	   </div>
	   <div class="panel-body">
     		<div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><?php echo $msg; ?></strong>
             </div>
             <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><?php echo $msg; ?></strong>
             </div>
             
		  <div class="row">

		<div class="col-md-12">
			<div class="alert alert-info" style="margin-bottom:15px;">
				<strong><i class="fa fa-info-circle"></i> Where does this image appear?</strong><br>
				Updated photos will appear on the public <strong>Members &rarr; Students</strong> page of the website.
			</div>
		</div>

		<div class="col-md-4">
	        <img id="output" class="img-responsive" src="../images/member/students/<?php echo $image; ?>" style="width:100%;" >
	    </div>

		<div class="col-md-8">
			<form id="member_t" method="post" action="edit_student.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" required>

				<div class="photo_post form-group">
					<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
					<label for="f02">Upload Photo</label><span>Image must be Square Sized (eg. 300*300)</span>
				</div>

				<fieldset class="form-group">
					<label for="name">Full Name:</label>
					<input class="form-control" placeholder="Full Name ...." type="text" name="name" tabindex="1" value="<?php echo $name; ?>" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="session">Session:</label>
					<input class="form-control" placeholder="Enter Session...." type="text" name="session" tabindex="1" value="<?php echo $session; ?>"  required>
				</fieldset>

				<fieldset class="form-group">
					<label for="student-status">Student Status:</label>
					<select class="form-control" id="student-status" name="status">
						<option value="current" <?php echo ($status == 'current') ? 'selected' : ''; ?>>Current Student</option>
						<option value="alumni"  <?php echo ($status == 'alumni')  ? 'selected' : ''; ?>>Alumni</option>
					</select>
				</fieldset>

				<fieldset class="form-group">
					<label for="email">Email address:</label>
					<input class="form-control" placeholder="example@domain.com" type="text" name="email" tabindex="1" value="<?php echo $email; ?>"  required>
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
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>


<script type="text/javascript">
	function validateform() {

	var name=document.forms["member_t"]["name"].value;
	if (name==null || name==""){
	  document.getElementById("result").innerHTML = " Error : Name field must not Empty...";
	  return false;
	}

	var session=document.forms["member_t"]["session"].value;
	if (session==null || session==""){
	  document.getElementById("result").innerHTML = " Error : Session field must not Empty...";
	  return false;
	}
	 
	var x = document.forms["member_t"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	
	var b=document.forms["member_t"]["email"].value;
	if (b==null || b=="")
	 {
	  document.getElementById("result").innerHTML = " Error : Email field must be filled...";
	  return false;
	 }else{
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
			return false;
		}
	 }

	return( true );
	}
	
</script>	

<?php include('bottom.php'); ?>