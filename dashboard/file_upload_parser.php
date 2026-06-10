<?php
	
include('server.php'); 

$filename = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$fileSize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];

$target_dir = "../images/gallary/video/";
$target_file = $target_dir . basename($_FILES["file1"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$video_id = time();

$video_name = $video_id.".".$imageFileType;


if ($imageFileType == 'mp4' || $imageFileType == 'ogv' || $imageFileType == 'webm' || $imageFileType == 'MP4' || $imageFileType == 'OGV' || $imageFileType == 'WEBM') {

	if ($fileSize > 1000000 && $fileSize <100000000) {


		if (move_uploaded_file($fileTmpLoc, "../images/gallary/video/".$video_name)) {

			$sql = "INSERT INTO videos (video , video_id) VALUES ('$video_name', '$video_id')";

			if ($db->query($sql) === TRUE) {
				$image = "demo_image.png";

				echo '<div class="col-md-4">
				        <img id="output" class="img-responsive" src="../images/gallary/video/tmp/'.$image.'" style="width:100%;height: 300px;" >
				    </div>

					<div class="col-md-8">
						<form id="upload_video" method="post" action="page_videos.php" enctype="multipart/form-data">

							<input type="hidden" name="video_id" value="'.$video_id.'">
							
							<div class="photo_post form-group col-md-6">
								<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
								<label for="f02">Choose a Thumb Image</label>
							</div>

							<div class="clearfix"></div>

							<fieldset class="form-group">
								<label for="title">Video Title:</label>
								<input class="form-control" placeholder="Video Title ...." type="text" name="title" tabindex="1" required>
							</fieldset>

							<fieldset class="form-group">
								<label for="info">Video Description:</label>
								<textarea class="form-control" placeholder="Video Description..." type="text" name="info" tabindex="1" rows="5" required></textarea>
							</fieldset>

							<fieldset class="form-group">
								<input onclick="return validateform()" type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
							</fieldset>
						</form>

					</div>';

			}else {
			    echo "Error: " . $sql . "<br>" . $db->error;
			}

		}else {
				echo "move_uploaded_file function failed";
		}





	}else{

		echo "Video size must be between 1MB to 100MB";

	}

	

}else {

	echo "Only mp4 / webm / ogv videos are supported";

}






		




?>