<?php

// Check if this is an AJAX insert request first
if(isset($_POST['insert']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	include_once('server.php');

	$upload_ok = false;
	if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] === 0) {
		$msg = 'No file uploaded or upload error. Please try again.';
	} else {
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$session = mysqli_real_escape_string($db, $_POST['session']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';

		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		if (move_uploaded_file($tmp_name, "../images/member/students/".$new_name)) {
			$sql = "INSERT INTO students(image, name, session, email, status) VALUES ('$new_name', '$name', '$session', '$email', '$status')";
			if ($db->query($sql) === TRUE) {
				$msg = 'Student added successfully.';
				$upload_ok = true;
			} else {
				$sql_fallback = "INSERT INTO students(image, name, session, email) VALUES ('$new_name', '$name', '$session', '$email')";
				if ($db->query($sql_fallback) === TRUE) {
					$msg = 'Student added successfully.';
					$upload_ok = true;
				} else {
					$msg = 'Failed to save to database. Try again.';
					if (is_file("../images/member/students/".$new_name)) {
						unlink("../images/member/students/".$new_name);
					}
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
	$batch = "";
	$session = "";
	$image = "demo_image.png";
	$id = 0;
	$alert_failed = 'display : none';
	$alert_success = 'display : none';
	$msg = '';	 
	//connect to database
	include('server.php'); 
	
	//if save btn is clicked (fallback for non-AJAX POST)
	if(isset($_POST['insert'])){

		$name = $_POST['name'];
		$session = $_POST['session'];
		$email = $_POST['email'];
		$status = in_array($_POST['status'] ?? '', ['current','alumni']) ? $_POST['status'] : 'current';
		
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		if (move_uploaded_file($tmp_name, "../images/member/students/".$new_name)) {

			$sql = "INSERT INTO students(image, name, session, email, status) VALUES ('$new_name', '$name', '$session', '$email', '$status')";

			if ($db->query($sql) === TRUE) {

				$msg = 'Member Added..';

				$alert_success = '';

			} else {

				$sql_fallback = "INSERT INTO students(image, name, session, email) VALUES ('$new_name', '$name', '$session', '$email')";

				if ($db->query($sql_fallback) === TRUE) {

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
		
	
		$result = mysqli_query($db, "SELECT * FROM students WHERE id=$id");
		$row = mysqli_fetch_array($result);
		$image=$row['image'];
		unlink("../images/member/students/".$image);
		mysqli_query($db, "DELETE FROM students WHERE id=$id");
		
		$msg = 'Member Deleted..';

		$alert_success = '';
	}
	
	
		
		
	//retrive records
	$result_current = mysqli_query($db, "SELECT * FROM students WHERE status='current' OR status IS NULL OR status='' ORDER BY id DESC");
	if (!$result_current) {
		$result_current = mysqli_query($db, "SELECT * FROM students ORDER BY id DESC");
	}
	$result_alumni  = mysqli_query($db, "SELECT * FROM students WHERE status='alumni' ORDER BY id DESC");
	if (!$result_alumni) {
		$result_alumni = mysqli_query($db, "SELECT * FROM students WHERE 1=0");
	}
?>

<style>
	/* ── Student Cards Grid ── */
	.students-grid {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		padding: 10px 0;
	}

	.student-card {
		flex: 1 1 180px;
		max-width: 220px;
		min-width: 150px;
		background: rgba(30, 41, 59, 0.55);
		border: 1px solid rgba(255,255,255,0.09);
		border-radius: 14px;
		padding: 14px;
		transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
		backdrop-filter: blur(10px);
		-webkit-backdrop-filter: blur(10px);
	}

	.student-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 14px 32px rgba(0,0,0,0.35);
		border-color: rgba(99,102,241,0.4);
	}

	.student-card img {
		width: 100%;
		height: 180px;
		object-fit: cover;
		border-radius: 10px;
		display: block;
	}

	.student-card .card-name {
		color: #a5b4fc;
		font-weight: 700;
		font-size: 15px;
		margin: 10px 0 12px;
		text-align: center;
		word-break: break-word;
	}

	.student-card .card-actions {
		display: flex;
		gap: 8px;
	}

	.student-card .card-actions a {
		flex: 1;
		text-align: center;
		padding: 6px 4px;
		font-size: 13px;
	}
</style>



<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title pull-left">Members: Students</h3>
		  <button type="button" class="btn btn-info pull-right" id="openStudentModal"><i class="fa fa-plus" style="margin-right:5px;"></i>Insert Student</button>
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
             
		  <!-- Current Students -->
		  <h5 style="margin: 10px 0 8px; color: #a5b4fc; font-size:13px; text-transform:uppercase; letter-spacing:.08em;"><i class="fa fa-user" style="margin-right:6px;"></i>Current Students</h5>
		  <div class="students-grid" id="grid-current">
			 
	<?php while($row = mysqli_fetch_array($result_current)){ ?>
	<div class="student-card">
		<img src="../images/member/students/<?php echo $row['image']; ?>" class="img-responsive" alt="<?php echo htmlspecialchars($row['name']); ?>">
		<div class="card-name"><?php echo htmlspecialchars($row['name']); ?></div>
		<div class="card-actions">
			<a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
			<a class="btn btn-danger" href="page_students.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()">Delete</a>
		</div>
	</div>
	<?php } ?>
               
		  </div>

		  <!-- Alumni Students -->
		  <h5 style="margin: 24px 0 8px; color: #c4b5fd; font-size:13px; text-transform:uppercase; letter-spacing:.08em;"><i class="fa fa-graduation-cap" style="margin-right:6px;"></i>Alumni Students</h5>
		  <div class="students-grid" id="grid-alumni" style="opacity:0.8;">
		  <?php
		  $alumni_count = 0;
		  while($row = mysqli_fetch_array($result_alumni)){
			  $alumni_count++;
		  ?>
	<div class="student-card" style="border-color:rgba(167,139,250,0.25);">
		<img src="../images/member/students/<?php echo $row['image']; ?>" class="img-responsive" alt="<?php echo htmlspecialchars($row['name']); ?>" style="filter:grayscale(30%);">
		<div class="card-name"><?php echo htmlspecialchars($row['name']); ?></div>
		<div class="card-actions">
			<a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
			<a class="btn btn-danger" href="page_students.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()">Delete</a>
		</div>
	</div>
	<?php } ?>
	<?php if ($alumni_count === 0): ?>
	<p style="color:rgba(255,255,255,0.35); font-size:13px; padding:10px 0;">No alumni students yet.</p>
	<?php endif; ?>
		  </div>
	   </div>
    </div>
</div>




	


<!-- Native dialog for Insert Student -->
<dialog id="insert_student_overlay" class="dashboard-dialog" aria-labelledby="studentModalTitle" closedby="any">
  <div class="dlg-header">
    <h4 class="dlg-title" id="studentModalTitle">
      <i class="fa fa-user-plus" style="margin-right:8px;"></i> Insert Student
    </h4>
    <button type="button" class="dlg-close-btn" data-dismiss="modal" aria-label="Close">&times;</button>
  </div>

  <form id="member_s" method="post" action="page_students.php" enctype="multipart/form-data">
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
          <span>Uploaded photos will appear on the public <strong>Members &rarr; Students</strong> page of the website.</span>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="photo_post form-group" style="margin-bottom:14px;">
          <input type="file" name="image" id="f02" accept="image/*">
          <label for="f02"><i class="fa fa-upload" style="margin-right:5px;"></i>Choose Photo</label>
          <span id="fileNameDisplay" style="display:inline-block; margin-left:10px; color:#cbd5e1; font-size:13px; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; vertical-align:middle;">No file selected</span>
          <span style="display:block;color:var(--text-muted);font-size:11px;margin-top:4px;">Image must be Square Sized (e.g. 300×300)</span>
        </div>

        <fieldset class="form-group" style="margin-bottom:14px;">
          <label for="student_name">Full Name</label>
          <input class="form-control" id="student_name" placeholder="Full Name..." type="text" name="name" tabindex="1" required>
        </fieldset>

        <fieldset class="form-group" style="margin-bottom:14px;">
          <label for="student_session">Session</label>
          <input class="form-control" id="student_session" placeholder="e.g. 2021–2022" type="text" name="session" tabindex="2" required>
        </fieldset>

        <fieldset class="form-group" style="margin-bottom:14px;">
          <label for="student_status">Student Status</label>
          <select class="form-control" id="student_status" name="status" tabindex="4">
            <option value="current" selected>Current Student</option>
            <option value="alumni">Alumni</option>
          </select>
        </fieldset>

        <fieldset class="form-group" style="margin-bottom:14px;">
          <label for="student_email">Email Address</label>
          <input class="form-control" id="student_email" placeholder="example@domain.com" type="email" name="email" tabindex="5" required>
        </fieldset>
      </div>
    </div>

    <div class="dlg-footer">
      <span class="dlg-result" id="result"></span>
      <div style="display:flex; gap:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info" id="insertStudentBtn">
          <i class="fa fa-plus" style="margin-right:5px;"></i>Insert Student
        </button>
      </div>
    </div>
  </form>
</dialog>

<script src="assets/js/dashboard-dialogs.js"></script>
<script>
  // Initialize native dialog
  Dashboard.initDashboardDialog({
    dialogId: 'insert_student_overlay',
    openBtnId: 'openStudentModal'
  });

  // Initialize image preview
  Dashboard.initImagePreview('f02', 'output', 'previewPlaceholder', 'fileNameDisplay');

  // Setup AJAX upload and form submission
  Dashboard.setupAjaxForm({
    formId: 'member_s',
    dialogId: 'insert_student_overlay',
    submitParamName: 'insert',
    validate: function(form) {
      var file = form.querySelector('#f02').files[0];
      if (!file) {
        return 'Please select a photo before uploading.';
      }
      var name = form.querySelector('#student_name').value.trim();
      if (!name) {
        return 'Full Name is required.';
      }
      var session = form.querySelector('#student_session').value.trim();
      if (!session) {
        return 'Session is required.';
      }
      var email = form.querySelector('#student_email').value.trim();
      if (!email) {
        return 'Email Address is required.';
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

<?php include('bottom.php'); ?>