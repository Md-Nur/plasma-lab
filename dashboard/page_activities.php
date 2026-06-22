<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 
	//im=nitializing variable
	$title = "";
	$info = "";
	$id = 0;
	$edit_state = false;
	$image = 'demo_image.png';

	$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';
	//connect to database

	function uploadActivityImage($fileInputName, &$errorMessage) {
		if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
			$errorMessage = 'Please choose an activity photo.';
			return false;
		}

		if ($_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
			$errorMessage = 'Photo upload failed. Please try again.';
			return false;
		}

		$tmp_name = $_FILES[$fileInputName]['tmp_name'];
		$imageInfo = getimagesize($tmp_name);
		if ($imageInfo === false) {
			$errorMessage = 'Only image files are allowed.';
			return false;
		}

		$allowedTypes = array(
			IMAGETYPE_JPEG => 'jpg',
			IMAGETYPE_PNG => 'png',
			IMAGETYPE_GIF => 'gif'
		);

		if (defined('IMAGETYPE_WEBP')) {
			$allowedTypes[IMAGETYPE_WEBP] = 'webp';
		}

		if (!isset($allowedTypes[$imageInfo[2]])) {
			$errorMessage = 'Only JPG, PNG, GIF, and WEBP photos are supported.';
			return false;
		}

		$uploadDir = __DIR__ . '/../images/activities/';
		if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
			$errorMessage = 'Activity photo folder is missing and could not be created.';
			return false;
		}

		$new_name = time() . '_' . mt_rand(1000, 9999) . '.' . $allowedTypes[$imageInfo[2]];
		if (!move_uploaded_file($tmp_name, $uploadDir . $new_name)) {
			$errorMessage = 'Could not save the uploaded photo.';
			return false;
		}

		return $new_name;
	}

	function deleteActivityImage($imageName) {
		if (empty($imageName) || $imageName === 'demo_image.png') {
			return;
		}

		$imagePath = __DIR__ . '/../images/activities/' . basename($imageName);
		if (is_file($imagePath)) {
			unlink($imagePath);
		}
	}
	
	
	//if save btn is clicked
	if(isset($_POST['submit'])){
		$title = mysqli_real_escape_string($db, $_POST['title']);
		$info = mysqli_real_escape_string($db, $_POST['info']);

		$new_name = uploadActivityImage('image', $msg);
		
		if ($new_name !== false) {
			$query = "INSERT INTO activities (image, title, info) VALUES ('$new_name','$title', '$info')";

			if ($db->query($query) === TRUE) {
				$msg = 'Activity Added..';

				$alert_success = '';
			} else {
				$msg = 'Failed to add..';
				deleteActivityImage($new_name);

				$alert_failed = '';
			}

		}
		else {
			$alert_failed = '';
		}
	}
	
	//update data
	if(isset($_POST['update'])){

		$title = mysqli_real_escape_string($db, $_POST['title']);
		$info = mysqli_real_escape_string($db, $_POST['info']);
		$id = (int) $_POST['id'];

		$fileName = basename($_FILES['image']['name']);



		if (empty($fileName)) {

			$sql_update = mysqli_query($db, "UPDATE activities SET title='$title', info = '$info' WHERE id = $id ");

			if ($sql_update === TRUE) {
				$rec = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
				$record = mysqli_fetch_array($rec);
				$image = $record['image'];
				$edit_state = true;
				$msg = 'Updated..';

				$alert_success = '';

			} else {

				 $msg = 'Failed to update..';

				$alert_failed = '';

			}

		}else {
			$new_name = uploadActivityImage('image', $msg);

			$result = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image = $row['image'];

			if ($new_name !== false) {

				$sql_update = mysqli_query($db, "UPDATE activities SET image='$new_name', title='$title', info = '$info' WHERE id = $id ");

				if ($sql_update === TRUE) {
					deleteActivityImage($image);

					$msg = 'Updated..';
					$edit_state = true;
				$alert_success = '';

				} else {

					 $msg = 'Failed to update..';
					deleteActivityImage($new_name);

				$alert_failed = '';

				}

			}else {

				$alert_failed = '';

			}

		}

	}

	
	

	
	//delete data
	if(isset($_GET['del'])){
		$id = (int) $_GET['del'];
		$rec = mysqli_query($db, "SELECT image FROM activities WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		if (mysqli_query($db, "DELETE FROM activities WHERE id=$id")) {
			if ($record) {
				deleteActivityImage($record['image']);
			}
			$msg = 'Activity Deleted..';

			$alert_success = '';
		} else {
			$msg = 'Failed to delete..';
			$alert_failed = '';
		}
	}
	
	
		
		
	//retrive records
	
	$result = mysqli_query($db, "SELECT * FROM activities");
	
		//fetch the record to be updated
	if(isset($_GET['edit'])) {
		$id = (int) $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$image = $record['image'];
		$title = $record['title'];
		$info = $record['info'];
		$id = $record['id'];
	}

?>



	



<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Add/Edit Activity</h3>
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
					Uploaded photos will appear on the public <strong>Activities</strong> section of the website.
				</div>
			</div>

<div class="col-md-4">
    <img id="output" class="img-responsive activity-preview-image" src="../images/activities/<?php echo htmlspecialchars($image); ?>" alt="Activity photo preview" onerror="this.style.display='none'">
</div>

<div class="col-md-8">
	<form  method="post" action="page_activities.php" enctype="multipart/form-data">
	
		<input type="hidden" name="id" value="<?php echo $id; ?>">

		<div class="photo_post">
			<input name="image" id="f02" type="file" accept="image/jpeg,image/png,image/gif,image/webp" placeholder="Add activity photo" onchange="loadFile(event)"/>
			<label for="f02">Upload Photo</label>
		</div>
		<div class="clearfix"></div>
		<fieldset class="form-group">
			<input class="form-control" type="text" name="title" placeholder=" title..." value="<?php echo $title; ?>">
		</fieldset>
		
		<fieldset class="form-group">
			<textarea class="form-control" name="info" placeholder=" info..." rows="6"><?php echo $info; ?></textarea>
		</fieldset>
		
		<fieldset class="file-input">
			<?php if ($edit_state == false): ?>
			<button name="submit" type="submit" class="btn btn-primary">Add</button>
			<?php else: ?>
				<div class="edit_state">
					<button type="submit" name="update" class="btn btn-info">Update</button>
					<a href="page_activities.php" class="btn btn-default">Reset</a>
				</div>
			<?php endif ?>
		</fieldset>
	</form>
</div>	



			</div>	
               
	   </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Activities</h3>
	   </div>
	   <div class="panel-body">
     
             
		  <div class="row">
			 
<?php 
	$result_activities = mysqli_query($db, "SELECT * FROM activities"); 
	
?>
<?php while($row_activities = mysqli_fetch_array($result_activities)){ ?>

	        <div class="col-md-4 col-lg-4 col-sm-6 ">
	            <div class="service-box activity-admin-card">
	                <div class="service-icon ">
	                    <img src="../images/activities/<?php echo htmlspecialchars($row_activities['image']); ?>" alt="<?php echo htmlspecialchars($row_activities['title']); ?>" class="activity-admin-image">
	                </div>
	                <div class="service-content" style="background-image:url(../images/back4.jpg);">
	                    <h3><?php echo htmlspecialchars($row_activities['title']); ?></h3>
	                    <p><?php echo htmlspecialchars($row_activities['info']); ?></p>
	                    <hr>
	                    <a type="button" class="btn btn-info" href="page_activities.php?edit=<?php echo $row_activities['id']; ?>">Edit </a> 
						<a type="button" class="btn btn-danger" href = "page_activities.php?del=<?php echo $row_activities['id']; ?>" onclick="return deleletconfig()"> Delete</a>
	                </div>
	            </div>
	        </div>

<?php } ?>
               
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
      output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>





<script>
	function deleletconfig(){

	var del=confirm("Are you sure you want to delete this record?");
	if (del==true){
	   alert ("record deleted")
	}
	return del;
	}
</script>

<?php include('bottom.php'); ?>
