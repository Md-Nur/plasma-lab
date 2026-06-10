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
	
	
	//if save btn is clicked
	if(isset($_POST['submit'])){
		$title = addslashes($_POST['title']);
		$info = addslashes($_POST['info']);

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";
		
		if (move_uploaded_file($tmp_name, "../images/activities/".$new_name)) {
			$query = "INSERT INTO activities (image, title, info) VALUES ('$new_name','$title', '$info')";

			if ($db->query($query) === TRUE) {
				$msg = 'Activity Added..';

				$alert_success = '';
			} else {
				$msg = 'Failed to add..';

				$alert_failed = '';
			}

		}
	}
	
	//update data
	if(isset($_POST['update'])){

		$title = addslashes($_POST['title']);
		$info = addslashes($_POST['info']);
		$id = $_POST['id'];

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
			$tmp_name = $_FILES['image']['tmp_name'];
			$new_name = time().".jpg";

			$result = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
			$row = mysqli_fetch_array($result);
			$image = $row['image'];
			unlink("../images/activities/".$image);

			if (move_uploaded_file($tmp_name, "../images/activities/".$new_name)) {

				$sql_update = mysqli_query($db, "UPDATE activities SET image='$new_name', title='$title', info = '$info' WHERE id = $id ");

				if ($sql_update === TRUE) {

					$msg = 'Updated..';
					$edit_state = true;
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

	
	

	
	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM activities WHERE id=$id");
		$msg = 'Activity Deleted..';

		$alert_success = '';
	}
	
	
		
		
	//retrive records
	
	$result = mysqli_query($db, "SELECT * FROM activities");
	
		//fetch the record to be updated
	if(isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM activities WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$image = $record['image'];
		$title = $record['title'];
		$info = $record['info'];
		$id = $record['id'];
	}

?>



<style type="text/css">

form input{
	border :1px solid #6C6D69;
}


.photo_post{
    width: 150px;
    display: inline-block;
}

label, input {
  color: #333;
  font: 14px/20px Arial;
}

label {
  display: inline-block;
  width: 5em;
  padding: 0 1em;
  text-align: right;
}

/* Hide the file input using
opacity */
[type=file] {
    position: absolute;
    filter: alpha(opacity=0);
    opacity: 0;
}
input,
[type=file] + label {
  border: 1px solid #CCC;
  border-radius: 3px;
  text-align: left;
  padding: 10px;
  width: 150px;
  position: relative;
}
[type=file] + label {
  text-align: center;
  /* Decorative */
  background: #333;
  color: #fff;
  border: none;
  cursor: pointer;
}
[type=file] + label:hover {
  background: #3399ff;
}
.photo_review{
    display: absolute;

}

</style>	



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


<div class="col-md-4">
    <img id="output" class="img-responsive" src="../images/activities/<?php echo $image; ?>" style="width:100%;height: 300px;" >
</div>

<div class="col-md-8">
	<form  method="post" action="page_activities.php" enctype="multipart/form-data">
	
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
	            <div class="service-box">
	                <div class="service-icon ">
	                    <img src="../images/activities/<?php echo $row_activities['image']; ?>" style="width: 100%;height: 100%;">
	                </div>
	                <div class="service-content" style="background-image:url(../images/back4.jpg);">
	                    <h3><?php echo $row_activities['title']; ?></h3>
	                    <p><?php echo $row_activities['info']; ?></p>
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