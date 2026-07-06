<?php

// Check if this is an AJAX insert request first (runs before any HTML output or navigation warnings)
if(isset($_POST['insert']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	include_once('server.php');

	$upload_ok = false;
	if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] === 0) {
		$msg = 'No file uploaded or upload error. Please try again.';
	} else {
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";
		if (move_uploaded_file($tmp_name, "../images/gallary/photos/".$new_name)) {
			$sql = "INSERT INTO photos(image) VALUES ('$new_name')";
			if ($db->query($sql) === TRUE) {
				$msg = 'Image uploaded successfully.';
				$upload_ok = true;
			} else {
				$msg = 'Could not save to database. Please try again.';
			}
		} else {
			$msg = 'Could not upload file. Please try again.';
		}
	}

	header('Content-Type: application/json');
	echo json_encode(['success' => $upload_ok, 'message' => $msg]);
	exit;
}

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$image = 'demo_image.png';
//im=nitializing variable

$alert_failed = 'display : none';
$alert_success = 'display : none';
$image = "demo_image.png";
$id = 0;

// Helper: safely delete a photo file from the server
function deletePhotoFile($imageName) {
	if (empty($imageName) || $imageName === 'demo_image.png') {
		return;
	}
	$imagePath = __DIR__ . '/../images/gallary/photos/' . basename($imageName);
	if (is_file($imagePath)) {
		unlink($imagePath);
	}
}

//if save btn is clicked
if(isset($_POST['insert'])){
	$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

	$upload_ok = false;
	if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] === 0) {
		$msg = 'No file uploaded or upload error. Please try again.';
		$alert_failed = '';
	} else {
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";
		if (move_uploaded_file($tmp_name, "../images/gallary/photos/".$new_name)) {
			$sql = "INSERT INTO photos(image) VALUES ('$new_name')";
			if ($db->query($sql) === TRUE) {
				$msg = 'Image uploaded successfully.';
				$alert_success = '';
				$upload_ok = true;
			} else {
				$msg = 'Could not save to database. Please try again.';
				$alert_failed = '';
			}
		} else {
			$msg = 'Could not upload file. Please try again.';
			$alert_failed = '';
		}
	}

	if ($isAjax) {
		header('Content-Type: application/json');
		echo json_encode(['success' => $upload_ok, 'message' => $msg]);
		exit;
	}
}

//delete data
if(isset($_GET['del'])){
	$id = (int) $_GET['del'];

	$rec = mysqli_query($db, "SELECT * FROM photos WHERE id=$id");
	if ($rec && mysqli_num_rows($rec) == 1) {
		$row = mysqli_fetch_array($rec);
		$del_image = $row['image'];

		// Delete the physical file from the server first
		deletePhotoFile($del_image);

		// Then remove the database record
		if (mysqli_query($db, "DELETE FROM photos WHERE id=$id")) {
			$msg = 'Photo deleted successfully.';
			$alert_success = '';
		} else {
			$msg = 'Could not delete record. Please try again.';
			$alert_failed = '';
		}
	} else {
		$msg = 'Photo not found.';
		$alert_failed = '';
	}
}


//retrive records
$result = mysqli_query($db, "SELECT * FROM photos");




?>



<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 " style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
               <h3 class="panel-title pull-left">Gallary: Photos</h3>
               <button type="button" class="pull-right btn btn-info" id="openInsertPhotosBtn">Insert Photos</button>
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
             
             <div class="photos-grid">
             <?php while($row = mysqli_fetch_array($result)){ ?>
             <div class="photo-card">
                  <img src="../images/gallary/photos/<?php echo htmlspecialchars($row['image']); ?>" alt="Gallery photo">
                  <div class="card-actions">
                      <a class="label label-danger" href="page_photos.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" title="Delete">
                        <i class="fa fa-trash-o fa-lg"></i>
                      </a>
                  </div>
             </div>
             <?php } ?>
             </div>
             
             <div class='clearfix'></div>
	   </div>
        
     </div>
 </div>

<!-- Native dialog for Insert Photo -->
<dialog id="insert_photos" class="dashboard-dialog" aria-labelledby="insertPhotosModalTitle" closedby="any">
  <div class="dlg-header">
    <h4 class="dlg-title" id="insertPhotosModalTitle">
      <i class="fa fa-camera" style="margin-right:8px;"></i> Insert Photo
    </h4>
    <button type="button" class="dlg-close-btn" data-dismiss="modal" aria-label="Close">&times;</button>
  </div>

  <form id="upload_photo_form" method="post" action="page_photos.php" enctype="multipart/form-data">
    <div class="dlg-body">
      <!-- Preview column -->
      <div class="dlg-preview">
        <img id="output" alt="Preview" style="display:none;">
        <div class="preview-placeholder" id="previewPlaceholder" style="width:160px; height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center; border:1px dashed rgba(255,255,255,0.15); border-radius:14px; background:rgba(255,255,255,0.02); color:rgba(255,255,255,0.3);">
          <i class="fa fa-image fa-2x" style="margin-bottom:8px;"></i>
          <span style="font-size:12px; text-align:center; padding: 0 10px;">Preview area</span>
        </div>
      </div>

      <!-- Form column -->
      <div class="dlg-form-col">
        <div class="info-banner">
          <i class="fa fa-info-circle"></i>
          <span>Uploaded photos will appear on the public <strong>Gallery &rarr; Photos</strong> page of the website.</span>
        </div>

        <div class="photo_post form-group" style="margin-bottom:0;">
          <input type="file" name="image" id="f02" accept="image/*">
          <label for="f02"><i class="fa fa-folder-open-o" style="margin-right:5px;"></i>Choose Photo</label>
          <span id="fileNameDisplay" style="display:inline-block; margin-left:10px; color:#cbd5e1; font-size:13px; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; vertical-align:middle;">No file selected</span>
        </div>
      </div>
    </div>

    <div class="dlg-footer">
      <span class="dlg-result" id="result"></span>
      <div style="display:flex; gap:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info" id="uploadPhotoBtn">
          <i class="fa fa-upload" style="margin-right:5px;"></i><span id="uploadBtnText">Upload</span>
        </button>
      </div>
    </div>
  </form>
</dialog>

<script src="assets/js/dashboard-dialogs.js"></script>
<script>
  // Initialize native dialog
  Dashboard.initDashboardDialog({
    dialogId: 'insert_photos',
    openBtnId: 'openInsertPhotosBtn'
  });

  // Initialize image preview
  Dashboard.initImagePreview('f02', 'output', 'previewPlaceholder', 'fileNameDisplay');

  // Setup AJAX upload and form submission
  Dashboard.setupAjaxForm({
    formId: 'upload_photo_form',
    dialogId: 'insert_photos',
    submitParamName: 'insert',
    validate: function(form) {
      var file = form.querySelector('#f02').files[0];
      if (!file) {
        return 'Please select a photo before uploading.';
      }
      return null;
    }
  });
</script>

<script>
	function deleletconfig(){
		var del = confirm("Are you sure you want to delete this record?");
		if (del == true) {
			alert("Record deleted");
		}
		return del;
	}
</script>
	
<?php include('bottom.php');?>