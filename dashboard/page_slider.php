
<?php
	include('head.php'); 
	include('redirect.php'); 
	include('navigation.php'); 
	//im=nitializing variable
	$title = "";
	$sub_title = "";
	$image = "demo_image.png";
	$edit_state = false;
	$id = 0;
	
	$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';
	//connect to database
	
	
	//if save btn is clicked
	if(isset($_POST['insert'])){

		$title = $_POST['title'];
		$sub_title = $_POST['sub_title'];

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";
		
		if (move_uploaded_file($tmp_name, "../images/slider/".$new_name)) {
			$sql = "INSERT INTO slider(image , title , sub_title) VALUES ('$new_name', '$title', '$sub_title')";

			if ($db->query($sql) === TRUE) {
				$msg = 'Slider Image Added..';
				$alert_success = '';

			} else {
				 $msg = 'Unable to Insert. Try Again...';
				$alert_failed = '';
			}

		}
	}

	if(isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM slider WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$image = $record['image']; 
		$title = $record['title'];
		$sub_title = $record['sub_title'];
		$id = $record['id'];
	}
	


	if(isset($_POST['update'])){

		$title = $_POST['title'];
		$sub_title = $_POST['sub_title'];
		$id = $_POST['id'];

		$fileName = basename($_FILES['image']['name']);



		if (empty($fileName)) {

			$sql_update = mysqli_query($db, "UPDATE slider SET title='$title', sub_title = '$sub_title' WHERE id = $id ");

			if ($sql_update === TRUE) {
                
             $msg = 'Slider Information Updated.';  
             $alert_success = '';

			} else {

				$msg = 'Unable to Update.';  
             $alert_failed = '';

			}

		}else {
			$tmp_name = $_FILES['image']['tmp_name'];
			$new_name = time().".jpg";

			$result = mysqli_query($db, "SELECT * FROM slider WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image=$row['image'];
			unlink("../images/slider/".$image);

			if (move_uploaded_file($tmp_name, "../images/slider/".$new_name)) {

				$sql_update = mysqli_query($db, "UPDATE slider SET image='$new_name', title='$title', sub_title = '$sub_title' WHERE id = $id ");

				if ($sql_update === TRUE) {

                    $msg = 'Slider Information Updated.';  
             $alert_success = '';
                    
				} else {

					 $msg = 'Unable to Update.';  
             $alert_failed = '';

				}

			}else {

				$msg = 'Unable to Update.';  
             $alert_failed = '';

			}

		}

	}


	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		
	
		$result = mysqli_query($db, "SELECT * FROM slider WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];
		unlink("../images/slider/".$image);
		mysqli_query($db, "DELETE FROM slider WHERE id=$id");
		
		$msg = "Slider Image deleted" ;
		$alert_success = '';
		$image = "demo_image.png";
	}
	
	
		
		
	//retrive records
	$result = mysqli_query($db, "SELECT * FROM slider");
?>


	



<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Add/Edit Slider Images</h3>
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
					Uploaded images will appear in the <strong>Homepage Slider</strong> (the banner at the top of the website).
				</div>
			</div>

<div class="col-md-4">
    <img id="output" class="img-responsive" src="../images/slider/<?php echo $image; ?>" style="width:100%;height: 300px;" onerror="this.style.display='none'">
</div>

<div class="col-md-8">
	<form method="post" action="page_slider.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		
		<div class="photo_post">
			<input name="image" id="f02" type="file" placeholder="Add profile picture" />
			<label for="f02"><i class="fa fa-upload" style="margin-right:5px;"></i>Upload Photo</label>
		</div>

		<div class="clearfix"></div>

		<fieldset  class="form-group">
			<input class="form-control" placeholder="Image Title ...." type="text" name="title" tabindex="1" value="<?php echo $title; ?>" required>
		</fieldset>

		<fieldset  class="form-group">
			<input class="form-control" placeholder="Image Sub-Title ...." type="text" name="sub_title" tabindex="1"  value="<?php echo $sub_title; ?>">
		</fieldset>

		<fieldset class="form-group">
			<?php if ($edit_state == false): ?>
			<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info"  class="btn btn-info" />
			<?php else: ?>
				<div class="edit_state">
					<button type="submit" class="btn btn-success" name="update">Update</button>
					<button type="submit" name="reset" class="btn btn-reset">Reset</button>
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
		  <h3 class="panel-title">Slider Images</h3>
	   </div>
	   <div class="panel-body">
             
		  <div class="row">
			 
			 <section class="">
				<?php while($row = mysqli_fetch_array($result)){ ?>
				<div class="col-md-4" style="margin-bottom: 10px;">
					<div class="col-md-12" style="padding: 10px; background-color: #EBEDEF;">
						<img src="../images/slider/<?php echo $row['image']; ?>" class="img-responsive" alt="" style="width:100%; height: 150px;">
						<div class="clearfix"></div>
						<br>
						<div class="col-md-6">
							<a href="page_slider.php?edit=<?php echo $row['id']; ?>"  class="btn btn-success" style="width: 100%;">Edit</a>
						</div>

						<div class="col-md-6">
							<a href="page_slider.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" class="btn btn-danger" style="width: 100%;">Delete</a>
						</div>
						
						
					</div>
					
				</div>
				<?php } ?>
			</section>
               
		  </div>
	   </div>
    </div>
</div>













<script src="assets/js/dashboard-dialogs.js"></script>
<script>
  // Initialize image preview
  Dashboard.initImagePreview('f02', 'output');
</script>

<script src="assets/js/bootstrap.min.js"></script>

<script>
function deleletconfig(){
  var del = confirm("Are you sure you want to delete this record?");
  if (del == true) {
    alert("Record deleted");
  }
  return del;
}
</script>

<?php	include('bottom.php'); ?>