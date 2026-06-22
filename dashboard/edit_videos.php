<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

	$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';

$image = "demo_image.png";


$id = $_GET['id'];

$result = mysqli_query($db, "SELECT * FROM videos WHERE id=$id");
$row = mysqli_fetch_array($result);
$image=$row['image'];
$video=$row['video'];
$title=$row['title'];
$info=$row['info'];
$id=$row['id'];


if(isset($_POST['update'])){

	$title = $_POST['title'];
	$info = $_POST['info'];
	$id = $_POST['id'];

	$fileName = basename($_FILES['image']['name']);



	if (empty($fileName)) {

		$sql_update = mysqli_query($db, "UPDATE videos SET title='$title', info = '$info' WHERE id = $id ");

		if ($sql_update === TRUE) {

			$msg = 'Video Updated';
				$alert_success = '';

		} else {

			$msg = 'Failed to update';
				$alert_failed = '';

		}

	}else {
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		$result = mysqli_query($db, "SELECT * FROM videos WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image = $row['image'];
		unlink("../images/gallary/video/tmp/".$image);

		if (move_uploaded_file($tmp_name, "../images/gallary/video/tmp/".$new_name)) {

			$sql_update = mysqli_query($db, "UPDATE videos SET image='$new_name', title='$title', info = '$info' WHERE id = $id ");

			if ($sql_update === TRUE) {

				$msg = 'Video Updated';
				$alert_success = '';

			} else {

				 $msg = 'Failed to update';
				$alert_failed = '';

			}

		}else {

			$msg = 'Failed to update';
				$alert_failed = '';

		}

	}

}

?>




	


<div style="width: 60%;margin: 50px auto;">
	

<div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $msg; ?></strong>
 </div>
 <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $msg; ?></strong>
 </div>

<div class="col-md-12">
	<div class="alert alert-info" style="margin-bottom:15px;">
		<strong><i class="fa fa-info-circle"></i> Where does this thumbnail appear?</strong><br>
		Updated thumbnails will appear alongside the video on the public <strong>Gallery &rarr; Videos</strong> page of the website.
	</div>
</div>

<div class="col-md-4">
    <img id="output" class="img-responsive" src="../images/gallary/video/tmp/<?php echo $image; ?>" style="width:100%;height: 300px;" onerror="this.style.display='none'">
    <button class="btn btn-success" style="width: 100%;" data-toggle="modal" data-target="#myVideo" >Show video</button>
</div>

<div id="myVideo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <video width="100%" height="" controls>
			<source src="../images/gallary/video/<?php echo $video; ?>" type="video/mp4">
		</video> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div class="col-md-8">
	<form id="upload_video" method="post" action="edit_videos.php?id=<?php echo $id; ?>" enctype="multipart/form-data">

		<input type="hidden" name="id" value="<?php echo $id; ?>">
		
		<div class="photo_post form-group col-md-6">
			<input class="form-control" name="image" id="f02" type="file" value="<?php echo $image; ?>" placeholder="Add profile picture" onchange="loadFile(event)"/>
			<label for="f02">Choose a Thumb Image</label>
		</div>

		<div class="clearfix"></div>

		<fieldset class="form-group">
			<label for="title">Video Title:</label>
			<input class="form-control" placeholder="Video Title ...." type="text" name="title" tabindex="1" value="<?php echo $title; ?>" required>
		</fieldset>

		<fieldset class="form-group">
			<label for="info">Video Description:</label>
			<textarea class="form-control" placeholder="Video Description..." type="text" name="info" tabindex="1" rows="5" required><?php echo $info; ?></textarea>
		</fieldset>

		<fieldset class="form-group">
			<input onclick="return validateform()" type="submit" name="update" id="insert" value="Update Video Information" class="btn btn-info" />
		</fieldset>
		<span id="result"></span>
	</form>

</div>';

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

	var title=document.forms["upload_video"]["title"].value;
	if (title==null || title==""){

	  document.getElementById("result").innerHTML = " Error : Video Title Empty...";
	  return false;

	}

	var info=document.forms["upload_video"]["info"].value;
	if (info==null || info==""){

	  document.getElementById("result").innerHTML = " Error : Video Information required...";
	  return false;

	}


	return( true );
	}
	
</script>	




<?php include('bottom.php');?>