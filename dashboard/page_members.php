<?php

// Check if this is an AJAX insert request first
if(isset($_POST['insert']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	include_once('server.php');

	$upload_ok = false;
	if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] === 0) {
		$msg = 'No file uploaded or upload error. Please try again.';
	} else {
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$designation = mysqli_real_escape_string($db, $_POST['designation']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$link = mysqli_real_escape_string($db, $_POST['link']);
		$info = mysqli_real_escape_string($db, $_POST['info']);

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {
			if ($link == '' || $link == null) {
				$sql = "INSERT INTO members(image, name, info, designation, phone, email) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email')";
			} else {
				$sql = "INSERT INTO members(image, name, info, designation, phone, email, link) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$link')";
			}

			if ($db->query($sql) === TRUE) {
				$msg = 'Member added successfully.';
				$upload_ok = true;
			} else {
				$msg = 'Failed to save member to database. Try again.';
				if (is_file("../images/member/members/".$new_name)) {
					unlink("../images/member/members/".$new_name);
				}
			}
		} else {
			$msg = 'Could not save the uploaded photo.';
		}
	}

	header('Content-Type: application/json');
	echo json_encode(['success' => $upload_ok, 'message' => $msg]);
	exit;
}

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 
	//im=nitializing variable
	$name = "";
	$info = "";
	$image = "demo_image.png";
	$position = "";
	$work_text = "";
	$work_img = "";
	$id = 0;
	
	$alert_failed = 'display : none';
	$alert_success = 'display : none';
	$msg = '';
	//connect to database
	
	
	//if save btn is clicked (fallback for non-AJAX POST)
	if(isset($_POST['insert'])){
		
		$name = $_POST['name'];
		$designation = $_POST['designation'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$link = $_POST['link'];
		$info = addslashes($_POST['info']);
		
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";


		if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {

			if ($link=='' || $link == null) {
				$sql = "INSERT INTO members(image , name , info , designation, phone, email) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email')";

				if ($db->query($sql) === TRUE) {

					$msg = 'Member Added..';

				$alert_success = '';

				} else {

					 $msg = 'Failed to add..';

				$alert_failed = '';

				}

			}else {

				$sql = "INSERT INTO members(image , name , info , designation, phone, email, link) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$link')";

				if ($db->query($sql) === TRUE) {

					$msg = 'Member Added..';

				$alert_success = '';

				} else {

					 $msg = 'Failed to add..';

				$alert_failed = '';

				}

			}

				

		}
	
	}


	
	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		
	
		$result = mysqli_query($db, "SELECT * FROM members WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];
		unlink("../images/member/members/".$image);
		mysqli_query($db, "DELETE FROM members WHERE id=$id");
		
		$msg = 'Member Deleted..';

		$alert_success = '';
	}
	
	$result = mysqli_query($db, "SELECT * FROM members");
?>




<style>
/* ── Member Cards ──────────────────────────────────────── */
.members-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  padding: 10px 0;
}

.member-card {
  flex: 1 1 180px;
  min-width: 160px;
  max-width: 220px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px;
  overflow: hidden;
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  display: flex;
  flex-direction: column;
}

.member-card:hover {
  transform: translateY(-4px);
  border-color: rgba(99,102,241,0.4);
  box-shadow: 0 16px 32px -8px rgba(99,102,241,0.2);
}

.member-card__img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.member-card__body {
  padding: 12px 14px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.member-card__name {
  font-size: 15px;
  font-weight: 700;
  color: #a5b4fc;
  margin: 0;
  line-height: 1.3;
  word-break: break-word;
}

.member-card__actions {
  display: flex;
  gap: 8px;
  margin-top: auto;
}

.member-card__actions .btn {
  flex: 1;
  padding: 7px 6px !important;
  font-size: 13px !important;
  text-align: center;
}

		/* Modal styles migrated globally to modern_dashboard.css */
	</style>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title pull-left">Members</h3>
			<button type="button" class="btn btn-info pull-right" id="openAddMemberBtn">Add Member</button>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div style="<?php echo $alert_success; ?>" id="update-alert-success" class="alert alert-success col-sm-12">
				<button type="button" class="close" onclick="this.parentElement.style.display='none'" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><?php echo $msg; ?></strong>
			</div>
			<div style="<?php echo $alert_failed; ?>" id="update-alert-danger" class="alert alert-danger col-sm-12">
				<button type="button" class="close" onclick="this.parentElement.style.display='none'" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><?php echo $msg; ?></strong>
			</div>

			<div class="members-grid">
				<?php while($row = mysqli_fetch_array($result)){ ?>
				<div class="member-card">
					<img src="../images/member/members/<?php echo $row['image']; ?>" class="member-card__img" alt="<?php echo htmlspecialchars($row['name']); ?>">
					<div class="member-card__body">
						<p class="member-card__name"><?php echo htmlspecialchars($row['name']); ?></p>
						<div class="member-card__actions">
							<a href="edit_members.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
							<a href="page_members.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" class="btn btn-danger">Delete</a>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>







<!-- Native dialog for Add Member -->
<dialog id="add-member-dialog" class="dashboard-dialog" aria-labelledby="dlg-title-id" closedby="any">
	<div class="dlg-header">
		<h4 class="dlg-title" id="dlg-title-id">Add Member</h4>
		<button type="button" class="dlg-close-btn" id="closeDlgBtn" aria-label="Close dialog">&times;</button>
	</div>

	<form id="member_t" method="post" action="page_members.php" enctype="multipart/form-data">
		<div class="dlg-body">
			<div class="dlg-preview">
				<img id="output" src="../images/member/members/<?php echo $image; ?>" alt="Member preview" onerror="this.style.display='none'">
				<div class="preview-placeholder" id="previewPlaceholder" style="width:160px; height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center; border:1px dashed rgba(255,255,255,0.15); border-radius:14px; background:rgba(255,255,255,0.02); color:rgba(255,255,255,0.3); <?php if($image !== 'demo_image.png') echo 'display:none;'; ?>">
					<i class="fa fa-user fa-2x" style="margin-bottom:8px;"></i>
					<span style="font-size:12px; text-align:center; padding: 0 10px;">Preview</span>
				</div>
			</div>

			<div class="dlg-form-col">
				<div class="info-banner">
					<i class="fa fa-info-circle"></i>
					<span>Uploaded photos will appear on the public <strong>Members</strong> page.</span>
				</div>

				<input type="hidden" name="id" value="<?php echo $id; ?>">

				<div class="photo_post form-group" style="margin-bottom:14px;">
					<input type="file" name="image" id="f02" accept="image/*">
					<label for="f02"><i class="fa fa-upload" style="margin-right:5px;"></i>Choose Photo</label>
					<span id="fileNameDisplay" style="display:inline-block; margin-left:10px; color:#cbd5e1; font-size:13px; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; vertical-align:middle;">No file selected</span>
					<span style="display:block;color:var(--text-muted);font-size:11px;margin-top:4px;">Image must be Square Sized (e.g. 300×300)</span>
				</div>

				<fieldset class="form-group">
					<label for="member-name">Full Name:</label>
					<input class="form-control" id="member-name" placeholder="Full Name ...." type="text" name="name" tabindex="1" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="member-designation">Designation:</label>
					<input class="form-control" id="member-designation" placeholder="Member Designation...." type="text" name="designation" tabindex="2">
				</fieldset>

				<fieldset class="form-group">
					<label for="member-phone">Phone No:</label>
					<input class="form-control" id="member-phone" placeholder="01XXX-XXXXXX" type="text" name="phone" tabindex="3">
				</fieldset>

				<fieldset class="form-group">
					<label for="member-email">Email Address:</label>
					<input class="form-control" id="member-email" placeholder="example@domain.com" type="email" name="email" tabindex="4">
				</fieldset>

				<fieldset class="form-group">
					<label for="member-link">External Link: <span style="font-weight:400;text-transform:none;">(if exists)</span></label>
					<input class="form-control" id="member-link" placeholder="https://example.com" type="text" name="link" tabindex="5">
				</fieldset>

				<fieldset class="form-group">
					<label for="member-info">Member Info:</label>
					<textarea class="form-control" id="member-info" placeholder="Short bio..." name="info" rows="4" tabindex="6"></textarea>
				</fieldset>
			</div>
		</div>

		<div class="dlg-footer">
			<span class="dlg-result" id="result"></span>
			<div style="display:flex; gap:10px; margin-left:auto;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info" id="insertMemberBtn">Add Member</button>
			</div>
		</div>
	</form>
</dialog>

<script src="assets/js/dashboard-dialogs.js"></script>
<script>
  // Initialize native dialog
  Dashboard.initDashboardDialog({
    dialogId: 'add-member-dialog',
    openBtnId: 'openAddMemberBtn'
  });

  // Initialize image preview
  Dashboard.initImagePreview('f02', 'output', 'previewPlaceholder', 'fileNameDisplay');

  // Setup AJAX upload and form submission
  Dashboard.setupAjaxForm({
    formId: 'member_t',
    dialogId: 'add-member-dialog',
    submitParamName: 'insert',
    validate: function(form) {
      var file = form.querySelector('#f02').files[0];
      if (!file) {
        return 'Please select a photo before uploading.';
      }
      var name = form.querySelector('#member-name').value.trim();
      if (!name) {
        return 'Full Name is required.';
      }
      
      var email = form.querySelector('#member-email').value.trim();
      if (email) {
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
          return 'Please enter a valid Email Address.';
        }
      }
      return null;
    }
  });
</script>

<script>
	function deleletconfig() {
		var del = confirm("Are you sure you want to delete this record?");
		if (del == true) {
			alert("record deleted")
		}
		return del;
	}
</script>

<?php include('bottom.php'); ?>
