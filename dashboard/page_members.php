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
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {
			if ($link == '' || $link == null) {
				$sql = "INSERT INTO members(image, name, info, designation, phone, email, status) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$status')";
			} else {
				$sql = "INSERT INTO members(image, name, info, designation, phone, email, link, status) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$link', '$status')";
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
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';
		
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";


		if (move_uploaded_file($tmp_name, "../images/member/members/".$new_name)) {

			if ($link=='' || $link == null) {
				$sql = "INSERT INTO members(image, name, info, designation, phone, email, status) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$status')";

				if ($db->query($sql) === TRUE) {

					$msg = 'Member Added..';

				$alert_success = '';

				} else {

					 $msg = 'Failed to add..';

				$alert_failed = '';

				}

			}else {

				$sql = "INSERT INTO members(image, name, info, designation, phone, email, link, status) VALUES ('$new_name', '$name', '$info', '$designation', '$phone', '$email', '$link', '$status')";

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
		$id = (int)$_GET['del'];
		
		$result = mysqli_query($db, "SELECT * FROM members WHERE id=$id");
		if ($result && $row = mysqli_fetch_array($result)) {
			$del_image = $row['image'];
			$img_path = "../images/member/members/" . $del_image;
			if ($del_image && is_file($img_path)) {
				unlink($img_path);
			}
			mysqli_query($db, "DELETE FROM members WHERE id=$id");
		}
		// Redirect to clear the ?del= from URL and prevent double-delete on refresh
		header('Location: page_members.php?deleted=1');
		exit;
	}

	if (isset($_GET['deleted'])) {
		$msg = 'Member deleted successfully.';
		$alert_success = '';
	}
	
	$result_current = mysqli_query($db, "SELECT * FROM members WHERE status='current' OR status IS NULL OR status='' ORDER BY id DESC");
	$result_alumni  = mysqli_query($db, "SELECT * FROM members WHERE status='alumni' ORDER BY id DESC");
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

			<!-- Current Members -->
			<h5 style="margin: 10px 0 8px; color: #a5b4fc; font-size:13px; text-transform:uppercase; letter-spacing:.08em;"><i class="fa fa-user" style="margin-right:6px;"></i>Current Members</h5>
			<div class="members-grid" id="grid-current">
				<?php while($row = mysqli_fetch_array($result_current)){ ?>
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

			<!-- Alumni Members -->
			<h5 style="margin: 24px 0 8px; color: #c4b5fd; font-size:13px; text-transform:uppercase; letter-spacing:.08em;"><i class="fa fa-graduation-cap" style="margin-right:6px;"></i>Alumni Members</h5>
			<div class="members-grid" id="grid-alumni" style="opacity:0.8;">
				<?php
				$alumni_count = 0;
				while($row = mysqli_fetch_array($result_alumni)){
					$alumni_count++;
				?>
				<div class="member-card" style="border-color:rgba(167,139,250,0.25);">
					<img src="../images/member/members/<?php echo $row['image']; ?>" class="member-card__img" alt="<?php echo htmlspecialchars($row['name']); ?>" style="filter:grayscale(30%);">
					<div class="member-card__body">
						<p class="member-card__name"><?php echo htmlspecialchars($row['name']); ?></p>
						<div class="member-card__actions">
							<a href="edit_members.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
							<a href="page_members.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" class="btn btn-danger">Delete</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if ($alumni_count === 0): ?>
				<p style="color:rgba(255,255,255,0.35); font-size:13px; padding:10px 0;">No alumni members yet.</p>
				<?php endif; ?>
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
		<div class="dlg-body" style="display:block; padding:24px;">
			<div class="info-banner" style="margin-bottom:16px;">
				<i class="fa fa-info-circle"></i>
				<span>Uploaded photos will appear on the public <strong>Members</strong> page.</span>
			</div>

			<input type="hidden" name="id" value="<?php echo $id; ?>">

			<!-- Inline photo upload + preview -->
			<div class="form-group" style="margin-bottom:16px;">
				<label style="display:block; margin-bottom:8px; font-size:13px; font-weight:600; color:rgba(255,255,255,0.7);">Member Photo <span style="color:#ef4444;">*</span></label>
				<div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
					<!-- Compact square preview -->
					<div style="position:relative; width:72px; height:72px; border-radius:12px; overflow:hidden; border:1px dashed rgba(255,255,255,0.2); background:rgba(255,255,255,0.03); flex-shrink:0;">
						<img id="output" src="" alt="Preview" style="width:100%; height:100%; object-fit:cover; display:none;">
						<div id="previewPlaceholder" style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:rgba(255,255,255,0.3);">
							<i class="fa fa-user fa-lg"></i>
						</div>
					</div>
					<!-- File picker -->
					<div style="flex:1; min-width:0;">
						<div class="photo_post" style="margin-bottom:6px;">
							<input type="file" name="image" id="f02" accept="image/*">
							<label for="f02"><i class="fa fa-upload" style="margin-right:5px;"></i>Choose Photo</label>
						</div>
						<span id="fileNameDisplay" style="display:block; color:#cbd5e1; font-size:12px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">No file selected</span>
						<span style="display:block; color:rgba(255,255,255,0.35); font-size:11px; margin-top:3px;">Square image recommended (e.g. 300×300)</span>
					</div>
				</div>
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
				<label for="member-status">Member Status:</label>
				<select class="form-control" id="member-status" name="status" tabindex="6">
					<option value="current" selected>Current Member</option>
					<option value="alumni">Alumni</option>
				</select>
			</fieldset>

			<fieldset class="form-group" style="margin-bottom:0;">
				<label for="member-info">Member Info:</label>
				<textarea class="form-control" id="member-info" placeholder="Short bio..." name="info" rows="4" tabindex="7"></textarea>
			</fieldset>
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
