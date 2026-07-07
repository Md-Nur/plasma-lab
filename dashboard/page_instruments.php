<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

// Initializing variables
$name = "";
$description = "";
$specifications = "";
$status = "active";
$id = 0;
$edit_state = false;
$image = 'demo_image.png';

$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';

// Connect to database

function uploadInstrumentImage($fileInputName, &$errorMessage) {
	if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
		$errorMessage = 'Please choose an instrument photo.';
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

	$uploadDir = __DIR__ . '/../images/instruments/';
	if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
		$errorMessage = 'Instrument photo folder is missing and could not be created.';
		return false;
	}

	$new_name = time() . '_' . mt_rand(1000, 9999) . '.' . $allowedTypes[$imageInfo[2]];
	if (!move_uploaded_file($tmp_name, $uploadDir . $new_name)) {
		$errorMessage = 'Could not save the uploaded photo.';
		return false;
	}

	return $new_name;
}

function deleteInstrumentImage($imageName) {
	if (empty($imageName) || $imageName === 'demo_image.png') {
		return;
	}

	$imagePath = __DIR__ . '/../images/instruments/' . basename($imageName);
	if (is_file($imagePath)) {
		unlink($imagePath);
	}
}

// If save btn is clicked
if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$description = mysqli_real_escape_string($db, $_POST['description']);
	$specifications = mysqli_real_escape_string($db, $_POST['specifications']);
	$status = mysqli_real_escape_string($db, $_POST['status']);

	$new_name = uploadInstrumentImage('image', $msg);
	
	if ($new_name !== false) {
		$query = "INSERT INTO instruments (image, name, description, specifications, status) VALUES ('$new_name', '$name', '$description', '$specifications', '$status')";

		if ($db->query($query) === TRUE) {
			$msg = 'Instrument Added successfully.';
			$alert_success = '';
			// Reset fields
			$name = "";
			$description = "";
			$specifications = "";
			$status = "active";
		} else {
			$msg = 'Failed to add instrument. Database error.';
			deleteInstrumentImage($new_name);
			$alert_failed = '';
		}
	} else {
		$alert_failed = '';
	}
}

// Update data
if(isset($_POST['update'])){
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$description = mysqli_real_escape_string($db, $_POST['description']);
	$specifications = mysqli_real_escape_string($db, $_POST['specifications']);
	$status = mysqli_real_escape_string($db, $_POST['status']);
	$id = (int) $_POST['id'];

	$fileName = basename($_FILES['image']['name']);

	if (empty($fileName)) {
		$sql_update = mysqli_query($db, "UPDATE instruments SET name='$name', description='$description', specifications='$specifications', status='$status' WHERE id = $id");

		if ($sql_update === TRUE) {
			$rec = mysqli_query($db, "SELECT * FROM instruments WHERE id=$id");
			$record = mysqli_fetch_array($rec);
			$image = $record['image'];
			$edit_state = false; // Reset edit state to go back to "Add" mode after successful update
			$msg = 'Instrument updated successfully.';
			$alert_success = '';
			
			// Reset fields
			$name = "";
			$description = "";
			$specifications = "";
			$status = "active";
			$id = 0;
			$image = 'demo_image.png';
		} else {
			$msg = 'Failed to update instrument.';
			$alert_failed = '';
			$edit_state = true;
		}
	} else {
		$new_name = uploadInstrumentImage('image', $msg);

		$result = mysqli_query($db, "SELECT * FROM instruments WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$old_image = $row['image'];

		if ($new_name !== false) {
			$sql_update = mysqli_query($db, "UPDATE instruments SET image='$new_name', name='$name', description='$description', specifications='$specifications', status='$status' WHERE id = $id");

			if ($sql_update === TRUE) {
				deleteInstrumentImage($old_image);
				$msg = 'Instrument updated successfully.';
				$edit_state = false;
				$alert_success = '';
				
				// Reset fields
				$name = "";
				$description = "";
				$specifications = "";
				$status = "active";
				$id = 0;
				$image = 'demo_image.png';
			} else {
				$msg = 'Failed to update instrument.';
				deleteInstrumentImage($new_name);
				$alert_failed = '';
				$edit_state = true;
			}
		} else {
			$alert_failed = '';
			$edit_state = true;
		}
	}
}

// Delete data
if(isset($_GET['del'])){
	$del_id = (int) $_GET['del'];
	$rec = mysqli_query($db, "SELECT image FROM instruments WHERE id=$del_id");
	$record = mysqli_fetch_array($rec);
	if (mysqli_query($db, "DELETE FROM instruments WHERE id=$del_id")) {
		if ($record) {
			deleteInstrumentImage($record['image']);
		}
		$msg = 'Instrument Deleted successfully.';
		$alert_success = '';
	} else {
		$msg = 'Failed to delete instrument.';
		$alert_failed = '';
	}
}

// Fetch the record to be updated
if(isset($_GET['edit'])) {
	$id = (int) $_GET['edit'];
	$edit_state = true;
	
	$rec = mysqli_query($db, "SELECT * FROM instruments WHERE id=$id");
	if ($rec && mysqli_num_rows($rec) > 0) {
		$record = mysqli_fetch_array($rec);
		$image = $record['image'];
		$name = $record['name'];
		$description = $record['description'];
		$specifications = $record['specifications'];
		$status = $record['status'];
		$id = $record['id'];
	}
}

?>

<style>
.instrument-preview-image {
  aspect-ratio: 4 / 3 !important;
  background: #f4f7fb !important;
  border: 1px solid rgba(15, 23, 42, 0.12) !important;
  border-radius: 8px !important;
  box-shadow: 0 14px 28px rgba(15, 23, 42, 0.12) !important;
  height: auto !important;
  max-height: 280px !important;
  object-fit: cover !important;
  width: 100% !important;
}

.instrument-admin-card {
  border-radius: 12px !important;
  overflow: hidden !important;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  border: 1px solid var(--border-color, #e2e8f0);
  background: #ffffff;
  margin-bottom: 30px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.instrument-admin-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

.instrument-admin-card .service-icon {
  aspect-ratio: 16 / 10 !important;
  height: auto !important;
  overflow: hidden !important;
  position: relative;
}

.instrument-admin-image {
  display: block !important;
  height: 100% !important;
  object-fit: cover !important;
  width: 100% !important;
  transition: transform 0.3s ease;
}

.instrument-admin-card:hover .instrument-admin-image {
  transform: scale(1.05);
}

.status-badge-overlay {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #fff;
  z-index: 2;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.status-active {
  background: linear-gradient(135deg, #10b981, #059669);
}

.status-maintenance {
  background: linear-gradient(135deg, #f59e0b, #d97706);
}

.status-retired {
  background: linear-gradient(135deg, #ef4444, #dc2626);
}

.card-details-wrapper {
  padding: 16px 20px 20px;
}

.card-details-wrapper h3 {
  font-size: 18px;
  font-weight: 700;
  margin: 0 0 10px 0;
  color: var(--text-color, #1e293b);
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.card-details-wrapper p {
  font-size: 13px;
  color: var(--text-muted, #64748b);
  line-height: 1.6;
  height: 60px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  margin-bottom: 15px;
}

.card-details-wrapper .specs-block {
  background: #f8fafc;
  padding: 8px 12px;
  border-radius: 6px;
  font-family: monospace;
  font-size: 11px;
  color: #475569;
  height: 60px;
  overflow: hidden;
  margin-bottom: 15px;
  border: 1px dashed #e2e8f0;
}

.instrument-card-actions {
  display: flex;
  gap: 10px;
  border-top: 1px solid #f1f5f9;
  padding-top: 15px;
}

.instrument-card-actions a {
  flex: 1;
  text-align: center;
}

@media (max-width: 767px) {
  .instrument-preview-image {
    max-height: none !important;
  }
}
</style>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title"><?php echo $edit_state ? 'Edit Instrument' : 'Add New Lab Instrument'; ?></h3>
	   </div>
	   <div class="panel-body">
             
             <div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle"></i> <?php echo $msg; ?></strong>
             </div>
             <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-exclamation-triangle"></i> <?php echo $msg; ?></strong>
             </div>
             
		  <div class="row">

			<div class="col-md-12">
				<div class="alert alert-info" style="margin-bottom:20px;">
					<strong><i class="fa fa-info-circle"></i> Dynamic Instruments Menu</strong><br>
					The instruments added here will be rendered dynamically in the public "Instruments" page, complete with filtering tabs and specifications modals.
				</div>
			</div>

            <div class="col-md-4">
                <h5 style="font-weight: 700; margin-bottom: 10px; color: #475569;">Instrument Image Preview</h5>
                <?php
                $preview_src = '../images/instruments/' . htmlspecialchars($image);
                if (empty($image) || $image === 'demo_image.png') {
                    $preview_src = '../images/activities/demo_image.png'; // Fallback to activities demo image
                }
                ?>
                <img id="output" class="img-responsive instrument-preview-image" src="<?php echo $preview_src; ?>" alt="Instrument photo preview" onerror="this.src='../images/activities/demo_image.png'">
            </div>

            <div class="col-md-8">
                <form method="post" action="page_instruments.php<?php if(isset($_GET['edit'])) echo '?edit='.$id; ?>" enctype="multipart/form-data">
                
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="photo_post">
                        <input name="image" id="f02" type="file" accept="image/jpeg,image/png,image/gif,image/webp" placeholder="Add instrument photo" onchange="loadFile(event)"/>
                        <label for="f02"><i class="fa fa-upload"></i> Upload Instrument Photo</label>
                        <span>Only JPG, PNG, GIF, and WEBP supported.</span>
                    </div>
                    <div class="clearfix" style="margin-bottom:15px;"></div>
                    
                    <fieldset class="form-group">
                        <label style="font-weight:600; margin-bottom:5px;">Instrument Name <span style="color:red;">*</span></label>
                        <input class="form-control" type="text" name="name" placeholder="Enter instrument name (e.g. Plasma Sputtering System)" value="<?php echo htmlspecialchars($name); ?>" required>
                    </fieldset>
                    
                    <fieldset class="form-group">
                        <label style="font-weight:600; margin-bottom:5px;">Operational Status</label>
                        <select class="form-control" name="status">
                            <option value="active" <?php if($status == 'active') echo 'selected'; ?>>Active / Operational</option>
                            <option value="maintenance" <?php if($status == 'maintenance') echo 'selected'; ?>>Under Maintenance</option>
                            <option value="retired" <?php if($status == 'retired') echo 'selected'; ?>>Retired / Decommissioned</option>
                        </select>
                    </fieldset>
                    
                    <fieldset class="form-group">
                        <label style="font-weight:600; margin-bottom:5px;">Description / Overview <span style="color:red;">*</span></label>
                        <textarea class="form-control" name="description" placeholder="Write a brief overview of the instrument and its research applications..." rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
                    </fieldset>

                    <fieldset class="form-group">
                        <label style="font-weight:600; margin-bottom:5px;">Technical Specifications</label>
                        <textarea class="form-control" name="specifications" placeholder="List technical specifications (e.g. Chamber size: 300mm, Power Supply: 13.56 MHz RF, Gas inputs: Ar, O2, N2)..." rows="4"><?php echo htmlspecialchars($specifications); ?></textarea>
                        <small class="text-muted">Tip: You can use HTML tags like &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt; for clean rendering.</small>
                    </fieldset>
                    
                    <fieldset class="file-input" style="margin-top:20px;">
                        <?php if ($edit_state == false): ?>
                        <button name="submit" type="submit" class="btn btn-primary" style="padding: 8px 24px;"><i class="fa fa-plus-circle"></i> Add Instrument</button>
                        <?php else: ?>
                            <div class="edit_state">
                                <button type="submit" name="update" class="btn btn-info" style="padding: 8px 24px;"><i class="fa fa-save"></i> Update Instrument</button>
                                <a href="page_instruments.php" class="btn btn-default" style="padding: 8px 24px;">Cancel / Reset</a>
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
		  <h3 class="panel-title">Instruments Inventory</h3>
	   </div>
	   <div class="panel-body">
     
		  <div class="row">
			 
            <?php 
                $result_instruments = mysqli_query($db, "SELECT * FROM instruments ORDER BY id DESC"); 
                if (mysqli_num_rows($result_instruments) == 0) {
                    echo '<div class="col-md-12 text-center text-muted" style="padding: 40px 0;"><i class="fa fa-cogs fa-3x" style="margin-bottom:15px;"></i><br>No instruments found in database. Add some using the form above.</div>';
                }
            ?>
            <?php while($row_inst = mysqli_fetch_array($result_instruments)){ 
                $badge_class = 'status-active';
                $badge_label = 'Active';
                if ($row_inst['status'] == 'maintenance') {
                    $badge_class = 'status-maintenance';
                    $badge_label = 'Maintenance';
                } elseif ($row_inst['status'] == 'retired') {
                    $badge_class = 'status-retired';
                    $badge_label = 'Retired';
                }
            ?>

                <div class="col-md-4 col-lg-4 col-sm-6">
                    <div class="instrument-admin-card">
                        <div class="service-icon">
                            <span class="status-badge-overlay <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span>
                            <img src="../images/instruments/<?php echo htmlspecialchars($row_inst['image']); ?>" alt="<?php echo htmlspecialchars($row_inst['name']); ?>" class="instrument-admin-image" onerror="this.src='../images/activities/demo_image.png'">
                        </div>
                        <div class="card-details-wrapper">
                            <h3><?php echo htmlspecialchars($row_inst['name']); ?></h3>
                            <p><?php echo htmlspecialchars($row_inst['description']); ?></p>
                            
                            <h5 style="font-weight: 700; margin-bottom: 5px; font-size:11px; text-transform:uppercase; color:#94a3b8;">Specs Summary</h5>
                            <div class="specs-block">
                                <?php echo !empty($row_inst['specifications']) ? nl2br(htmlspecialchars($row_inst['specifications'])) : '<span class="text-muted">No specifications listed.</span>'; ?>
                            </div>
                            
                            <div class="instrument-card-actions">
                                <a class="btn btn-info btn-sm" href="page_instruments.php?edit=<?php echo $row_inst['id']; ?>"><i class="fa fa-edit"></i> Edit</a> 
                                <a class="btn btn-danger btn-sm" href="page_instruments.php?del=<?php echo $row_inst['id']; ?>" onclick="return deleteConfirm()"><i class="fa fa-trash"></i> Delete</a>
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
      output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
  };

  function deleteConfirm(){
      var del = confirm("Are you sure you want to delete this instrument? This action cannot be undone.");
      if (del == true){
         alert("Record deleted successfully.");
      }
      return del;
  }
</script>

<?php include('bottom.php'); ?>
