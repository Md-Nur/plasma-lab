<?php
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
	
	
	//if save btn is clicked
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

/* ── Add Member Dialog ──────────────────────────────────── */
#add-member-dialog {
  border: none;
  border-radius: 20px;
  padding: 0;
  width: min(680px, 95vw);
  max-height: 90vh;
  overflow-y: auto;
  background: #111827;
  color: #f3f4f6;
  box-shadow: 0 30px 80px -10px rgba(0,0,0,0.85);
  /* Centering via margin auto in top layer */
  margin: auto;
}

#add-member-dialog::backdrop {
  background: rgba(0,0,0,0.65);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

.dlg-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  position: sticky;
  top: 0;
  background: #111827;
  z-index: 5;
}

.dlg-title {
  font-size: 20px;
  font-weight: 700;
  background: linear-gradient(135deg,#fff 0%,#cbd5e1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 0;
}

.dlg-close-btn {
  background: transparent;
  border: none;
  color: rgba(255,255,255,0.5);
  font-size: 22px;
  line-height: 1;
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 8px;
  transition: color 0.2s, background 0.2s;
}

.dlg-close-btn:hover {
  color: #fff;
  background: rgba(255,255,255,0.08);
}

.dlg-body {
  padding: 24px;
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.dlg-preview {
  flex: 0 0 160px;
  display: flex;
  align-items: flex-start;
  justify-content: center;
}

.dlg-preview img {
  width: 160px;
  height: 180px;
  object-fit: cover;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.1);
  display: block;
}

.dlg-form-col {
  flex: 1 1 280px;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.dlg-footer {
  padding: 16px 24px;
  border-top: 1px solid rgba(255,255,255,0.08);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
}

#dlg-result {
  color: #f87171;
  font-size: 14px;
  flex: 1;
}

@media (max-width: 520px) {
  .dlg-body { flex-direction: column; }
  .dlg-preview { flex: none; width: 100%; }
  .dlg-preview img { width: 100%; height: 200px; }
  .members-grid { gap: 14px; }
  .member-card { flex: 1 1 140px; min-width: 130px; }
}
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
<dialog id="add-member-dialog" aria-labelledby="dlg-title-id" closedby="any">
	<div class="dlg-header">
		<h4 class="dlg-title" id="dlg-title-id">Add Member</h4>
		<button type="button" class="dlg-close-btn" id="closeDlgBtn" aria-label="Close dialog">&times;</button>
	</div>

	<div class="dlg-body">
		<div class="dlg-preview">
			<img id="output" src="../images/member/members/<?php echo $image; ?>" alt="Member preview" onerror="this.style.display='none'">
		</div>

		<div class="dlg-form-col">
			<div class="alert alert-info" style="margin-bottom:0;">
				<strong><i class="fa fa-info-circle"></i> Where does this image appear?</strong><br>
				Uploaded photos will appear on the public <strong>Members</strong> page.
			</div>

			<form id="member_t" method="post" action="page_members.php" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>">

				<div class="photo_post form-group">
					<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)" />
					<label for="f02">Upload Photo</label>
					<span>Image must be Square Sized (eg. 300×300)</span>
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
			</form>
		</div>
	</div>

	<div class="dlg-footer">
		<span id="result" id="dlg-result"></span>
		<div style="display:flex;gap:10px;margin-left:auto;">
			<button type="button" class="btn btn-default" id="closeDlgFooterBtn">Close</button>
			<button type="submit" form="member_t" onclick="return validateform()" name="insert" class="btn btn-info">Add Member</button>
		</div>
	</div>
</dialog>


<script>
	// ── File preview ──────────────────────────────────────
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function() {
			var output = document.getElementById('output');
			output.src = reader.result;
			output.style.display = 'block';
		};
		reader.readAsDataURL(event.target.files[0]);
	};

	// ── Dialog open / close ───────────────────────────────
	var dialog = document.getElementById('add-member-dialog');

	document.getElementById('openAddMemberBtn').addEventListener('click', function() {
		dialog.showModal();
	});

	document.getElementById('closeDlgBtn').addEventListener('click', function() {
		dialog.close();
	});

	document.getElementById('closeDlgFooterBtn').addEventListener('click', function() {
		dialog.close();
	});

	// Light-dismiss fallback for browsers without closedby support (e.g. Safari)
	if (!('closedBy' in HTMLDialogElement.prototype)) {
		dialog.addEventListener('click', function(event) {
			if (event.target !== dialog) return;
			var rect = dialog.getBoundingClientRect();
			var isContent = (
				rect.top    <= event.clientY && event.clientY <= rect.top    + rect.height &&
				rect.left   <= event.clientX && event.clientX <= rect.left   + rect.width
			);
			if (!isContent) dialog.close();
		});
	}
</script>

<script type="text/javascript">
	function validateform() {

		var image = document.forms["member_t"]["image"].value;
		if (image == null || image == "") {
			document.getElementById("result").innerHTML = " Error : Insert a Photo...";
			return false;
		}

		var name = document.forms["member_t"]["name"].value;
		if (name == null || name == "") {
			document.getElementById("result").innerHTML = " Error : Name field must not Empty...";
			return false;
		}

		// var designation = document.forms["member_t"]["designation"].value;
		// if (designation == null || designation == "") {
		// document.getElementById("result").innerHTML = " Error : Designation field must not Empty...";
		// return false;
		// }
		//
		// var phone = document.forms["member_t"]["phone"].value;
		// if (phone == null || phone == "") {
		// document.getElementById("result").innerHTML = " Error : phone field must not Empty...";
		// return false;
		// }

		var x = document.forms["member_t"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");


		var b = document.forms["member_t"]["email"].value;
		if (b == null || b == "") {
			//			document.getElementById("result").innerHTML = " Error : Email field must be filled...";
			//			return false;
		} else {
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
				document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
				return false;
			}
		}



		// var info = document.forms["member_t"]["info"].value;
		// if (info == null || info == "") {
		// document.getElementById("result").innerHTML = " Error : Write some info about the member...";
		// return false;
		// }

		return (true);
	}

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
