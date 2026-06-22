
<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

//im=nitializing variable
$title = "";
$info = "";
$video = "";
$image = "demo_image.png";
$id = 0;
	$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';


//if save btn is clicked
if(isset($_POST['insert'])){
	//path to store

	$target_dir = "../images/gallary/video/tmp/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	$title = $_POST['title'];
	$info = $_POST['info'];
	$video_id = $_POST['video_id'];
	

	$tmp_name_i = $_FILES['image']['tmp_name'];
    $new_name = time().".".$imageFileType;


    if ($imageFileType == 'jpg' | $imageFileType == 'jpeg' | $imageFileType == 'gif'| $imageFileType == 'png') {
    	
    	if (move_uploaded_file($tmp_name_i, "../images/gallary/video/tmp/".$new_name)) {

	    	$sql_update = mysqli_query($db, "UPDATE videos SET title='$title', info = '$info', image = '$new_name' WHERE video_id = $video_id ");

			if ($sql_update === TRUE) {

				$msg = 'Video Uploaded';
				$alert_success = '';

			} else {

				$msg = 'Failed to Upload';
				$alert_failed = '';
			}
	    }else{
	    	$msg = 'Failed to Upload';
			$alert_failed = '';
	    }


    }else{

    	
    	$msg = 'Please select an image of jpeg/jpg/png/gif formate.';
		$alert_failed = '';

    }


}

//delete data
if(isset($_GET['del'])){
	$id = $_GET['del'];
	

	$result = mysqli_query($db, "SELECT * FROM videos WHERE id=$id");
	$row = mysqli_fetch_array($result);
	$video=$row['video'];
	$image=$row['image'];
	unlink("../images/gallary/video/".$video);
	unlink("../images/gallary/video/tmp/".$image);
	mysqli_query($db, "DELETE FROM videos WHERE id=$id");
	
	$msg = "Video deleted" ;
	$alert_success = '';
}


		
	
?>




<script type="text/javascript">
	function _(el) {
          return document.getElementById(el);
     }

     function uploadFile() {

     	

     	var file = _("file1").files[0];
     	// alert(file.name+" | "+file.size+" | "+file.type);
     	var formdata = new FormData();
     	formdata.append("file1", file);
     	var ajax = new XMLHttpRequest();
     	ajax.upload.addEventListener("progress", progressHandler, false);
     	ajax.addEventListener("load", completeHandler, false);
     	ajax.addEventListener("error", errorHandler, false);
     	ajax.addEventListener("abort", abortHandler, false);
     	ajax.open("POST", "file_upload_parser.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
     	//use file_upload_parser.php from above url
     	ajax.send(formdata);
     }

     function progressHandler(event) {
     var uploaded = event.loaded / 1000000;
     var file_size = event.total / 1000000;

       _("loaded_n_total").innerHTML = "Uploaded " + uploaded.toFixed(2) + "Mb/" + file_size.toFixed(2) + "Mb";
       var percent = (event.loaded / event.total) * 100;
       _("progressBar").value = Math.round(percent);
       _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
     }

     function completeHandler(event) {
       _("status").innerHTML = event.target.responseText;
       _("progressBar").value = 100; //wil clear progress bar after successful upload
     }

     function errorHandler(event) {
       _("status").innerHTML = "Upload Failed";
     }

     function abortHandler(event) {
       _("status").innerHTML = "Upload Aborted";
     }
</script>




<div class="">
	<h1>
		Gallary
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Videos
		</small>
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#insert_videos">Insert Videos</button>
		</small>
	</h1>
	<hr><br>
</div><!-- /.page-header -->
<div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $msg; ?></strong>
 </div>
 <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $msg; ?></strong>
 </div>

<section class="Recent-Vodeos col-md-12">
	<?php $result_video = mysqli_query($db, "SELECT * FROM videos"); ?>
	<?php while($row_video = mysqli_fetch_array($result_video)){ ?>
	<div class="col-lg-2">
		<div style="width: 100%;background: #EBEDEF;margin: 10px; border-radius: 10px;">
			<img class="img-responsive" src="../images/gallary/video/tmp/<?php echo $row_video['image']; ?>" title="<?php echo $row_video['title']; ?>" data-toggle="modal" data-target="#myModal<?php echo $row_video['id']; ?>" />

			<div style="color: black;width:100%;padding: 10px;">
				<span style="color:#6FA2E2;"><?php echo $row_video['title']; ?></span>
				<p><?php echo $row_video['info']; ?></p>
				<br>
				<div class="col-md-6">
					<a class="btn btn-info" style="width: 100%;" href="edit_videos.php?id=<?php echo $row_video['id']; ?>" width="100%">Edit</a>
				</div>

				<div class="col-md-6">
					<a class="btn btn-danger" style="width: 100%;" href="page_videos.php?del=<?php echo $row_video['id']; ?>" onclick="return deleletconfig()" width="100%">Delete</a>
				</div>
				<div class="clearfix"></div>
				
			</div>
			
		</div>
		
	</div>
	


	<div id="myModal<?php echo $row_video['id']; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <video width="100%" height="" controls>
				<source src="../images/gallary/video/<?php echo $row_video['video']; ?>" type="video/mp4">
			</video> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<?php } ?>
</section>



	

<div id="insert_videos" class="modal fade" role="dialog">
     <div class="modal-dialog"  style="width: 60%;">

    <!-- Modal content-->
          <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Insert Videos</h4>
                </div>
                <div class="modal-body">

                	<div class="alert alert-info" style="margin-bottom:15px;">
                		<strong><i class="fa fa-info-circle"></i> Where does this video appear?</strong><br>
                		Uploaded videos will appear in the public <strong>Gallery &rarr; Videos</strong> section of the website.
                	</div>

                	<div id="status">
                         
                		<form id="upload_form" enctype="multipart/form-data" method="post" style="width: 200px;margin:0 auto;">
          				<fieldset class="form-group">
          					<input class="form-control" type="file" name="file1" id="file1" onchange="uploadFile()"/>
          					<label for="file1">Select Video File</label>
          				</fieldset>
          			</form>
          	      	
          	      	<div id=""></div>

                	</div>

          		<progress id='progressBar' class='progressBar' value='0' max='100'></progress>
          		<span id="loaded_n_total"></span>
                	<div class="clearfix"></div>
                    
                </div>
                     
                <div class="modal-footer">
                	<span id="result"></span>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

	var image=document.forms["upload_video"]["image"].value;
	if (image==null || image==""){

	  document.getElementById("result").innerHTML = " Error : Insert a Thumb image...";
	  return false;
	  
	}

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







<script>
	function deleletconfig(){

	var del=confirm("Are you sure you want to delete this record?");
	if (del==true){
	   alert ("record deleted")
	}
	return del;
	}
</script>



<?php include('bottom.php');?>