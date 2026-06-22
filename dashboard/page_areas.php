<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 
	//im=nitializing variable
	$title = "";
	$info = "";
	$image = "demo_image.png";
	$id = 0;
	$edit_state = false;

	
$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';	
	//connect to database

	
	//if save btn is clicked
	if(isset($_POST['submit'])){
		$title = addslashes($_POST['title']);
		$info = addslashes($_POST['info']);

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";
		
		if (move_uploaded_file($tmp_name, "../images/areas/".$new_name)) {
			$query = "INSERT INTO areas (image, title, info) VALUES ('$new_name','$title', '$info')";

			if ($db->query($query) === TRUE) {

				$msg = 'Inserted..';

				$alert_success = '';
				
			} else {
				 $msg = 'Failed..';

				$alert_failed = '';
			}

		}
	}



	if(isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM areas WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$image = $record['image']; 
		$title = $record['title'];
		$info = $record['info'];
		$id = $record['id'];
	}
	
	//update data
	if(isset($_POST['update'])){

		$title = addslashes($_POST['title']);
		$info = addslashes($_POST['info']);
		$id = $_POST['id'];

		$fileName = basename($_FILES['image']['name']);



		if (empty($fileName)) {

			$sql_update = mysqli_query($db, "UPDATE areas SET title='$title', info = '$info' WHERE id = $id ");

			if ($sql_update === TRUE) {
				$rec = mysqli_query($db, "SELECT * FROM areas WHERE id=$id");
				$record = mysqli_fetch_array($rec);
				$image = $record['image'];
				$msg = 'Updated..';
				$edit_state = true;
				$alert_success = '';

			} else {

				$msg = 'Failed..';

				$alert_failed = '';

			}

		}else {
			$tmp_name = $_FILES['image']['tmp_name'];
			$new_name = time().".jpg";

			$result = mysqli_query($db, "SELECT * FROM areas WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image=$row['image'];
			unlink("../images/areas/".$image);

			if (move_uploaded_file($tmp_name, "../images/areas/".$new_name)) {

				$sql_update = mysqli_query($db, "UPDATE areas SET image='$new_name', title='$title', info = '$info' WHERE id = $id ");

				if ($sql_update === TRUE) {

					$msg = 'Updated..';
					$image = $new_name;
					$alert_success = '';
					$edit_state = true;

				} else {

					 $msg = 'Failed..';

				$alert_failed = '';

				}

			}else {

				$msg = 'Failed..';

				$alert_failed = '';

			}

		}

	}


	
	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM areas WHERE id=$id");
		$msg = 'Deletet..';
		$alert_success = '';
	}
	
	
		
		
	//retrive records
	
	$result = mysqli_query($db, "SELECT * FROM areas");
	
		//fetch the record to be updated
	if(isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM areas WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$title = $record['title'];
		$info = $record['info'];
		$id = $record['id'];
	}

?>



	


<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Add/Edit Areas</h3>
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
					Uploaded photos will appear in the <strong>Research Areas</strong> section of the website.
				</div>
			</div>

	<form  method="post" action="page_areas.php" enctype="multipart/form-data">
		
		<div class="col-md-4">
	        <img id="output" class="img-responsive" src="../images/areas/<?php echo $image; ?>" style="width:100%;height: 300px;" onerror="this.style.display='none'">
	    </div>

	    <div class="col-md-8">
			
			
			<input type="hidden" name="id" value="<?php echo $id; ?>">

			<div class="photo_post">
				<input name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
				<label for="f02">Upload Photo</label>
			</div>
			<div class="clearfix"></div>
			<fieldset class="form-group">
				<input class="form-control" type="text" name="title" placeholder=" title..." value="<?php echo $title; ?>">
			</fieldset>
			
			<fieldset class="form-group">
				<textarea class="form-control" name="info" placeholder=" info..."><?php echo $info; ?></textarea>
			</fieldset>
			
			<fieldset class="file-input">
				<?php if ($edit_state == false): ?>
				<button name="submit" type="submit" class="btn btn-primary">Add</button>
				<?php else: ?>
					<div class="edit_state">
						<button type="submit" name="update" class="btn btn-info">Update</button>
						<a href="page_areas.php" name="reset" class="btn btn-default">Reset</a>
					</div>
				<?php endif ?>
			</fieldset>
			
		</div>
	</form>


			</div>	
               
	   </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Areas</h3>
	   </div>
	   <div class="panel-body">
     
             
		  <div class="row">
			 
	<?php 
		$result_areas = mysqli_query($db, "SELECT * FROM areas"); 
	?>
	<?php while($row_areas = mysqli_fetch_array($result_areas)){ ?>
		<div class="col-md-4 col-sm-6 ">
            <div class="service-box">
                <div class="service-icon">
                    <img src="../images/areas/<?php echo $row_areas['image'] ;?>" style="width: 100%;height: 100%;">
                </div>
                <div class="service-content">
                    <h3 style="color: red;"><?php echo $row_areas['title'] ;?></h3>
                    <hr>
                    <p style="color: #fff; text-align: center;"><?php echo $row_areas['info']; ?></p>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
						<a href="page_areas.php?edit=<?php echo $row_areas['id']; ?>"  class="btn btn-success" style="width: 100%;">Edit</a>
					</div>

					<div class="col-md-6">
						<a href="page_areas.php?del=<?php echo $row_areas['id']; ?>" onclick="return deleletconfig()" class="btn btn-danger" style="width: 100%;">Delete</a>
					</div>
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