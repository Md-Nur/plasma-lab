
<?php
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
	
	//if save btn is clicked
	if(isset($_POST['insert'])){

		$name = $_POST['name'];
		$session = $_POST['session'];
		$email = $_POST['email'];
		
		$tmp_name = $_FILES['image']['tmp_name'];
		$new_name = time().".jpg";

		if (move_uploaded_file($tmp_name, "../images/member/students/".$new_name)) {

			$sql = "INSERT INTO students(image , name, session, email) VALUES ('$new_name', '$name', '$session', '$email')";

			if ($db->query($sql) === TRUE) {

				$msg = 'Member Added..';

				$alert_success = '';

			} else {

				 $msg = 'Failed to add..';

				$alert_failed = '';


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
	$result = mysqli_query($db, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/style.css" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

	<script src="assets/js/jquery.js"></script>

</head>

<body>



<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title pull-left">Members: Students</h3>
		  <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#insert_student">Insert Student</button>
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
             
		  <div class="row">
			 
	<?php while($row = mysqli_fetch_array($result)){ ?>
	<div class="col-md-2 well action" style="padding:10px;">
		<img src="../images/member/students/<?php echo $row['image']; ?>" class="img-responsive" style="width:100%;height: 300px;" alt="">
		<hr >
		<div class="slider_caption">
			<h4 style="color:green;font-weight:700;font-size:20px;"><?php echo $row['name']; ?></h4>
		</div>
		<div class="col-md-6">
			<a href="edit_student.php?id=<?php echo $row['id']; ?>"  class="btn btn-success" style="width: 100%;">Edit</a>
		</div>

		<div class="col-md-6">
			<a type="button" class="btn btn-danger" href="page_students.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()"> Delete</a>
		</div>
		
	</div>
	<?php } ?>
               
		  </div>
	   </div>
    </div>
</div>




<style type="text/css">




.photo_post{
    display: inline-block;
}

.photo_post span{
	margin-left: 20px;
}


/* Hide the file input using
opacity */
[type=file] {
    position: absolute;
    filter: alpha(opacity=0);
    opacity: 0;
}

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


<div id="insert_student" class="modal fade" role="dialog">
  <div class="modal-dialog"  style="width: 60%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Insert Student</h4>
      </div>
      <div class="modal-body">

      	<div class="col-md-4">
	        <img id="output" class="img-responsive" src="../images/member/students/<?php echo $image; ?>" style="width:100%;height: 300px;" >
	    </div>

		<div class="col-md-8">
			<form id="member_s" method="post" action="page_students.php" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" required>

				<div class="photo_post form-group">
					<input class="form-control" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
					<label for="f02">Upload Photo</label><span>Image must be Square Sized (eg. 300*300)</span>
				</div>

				<fieldset class="form-group">
					<label for="name">Full Name:</label>
					<input class="form-control" placeholder="Full Name ...." type="text" name="name" tabindex="1" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="session">Session:</label>
					<input class="form-control" placeholder="Session...." type="text" name="session" tabindex="1" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="email">Email address:</label>
					<input class="form-control" placeholder="example@domain.com" type="text" name="email" tabindex="1" required>
				</fieldset>

				<fieldset class="form-group">
					<input onclick="return validateform()" type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
				</fieldset>
			</form>

		</div>

		<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      	<div class="clearfix"></div>
      	<span id="result" class="pull-left" style="color: red"></span>
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



<script>
	function deleletconfig(){

	var del=confirm("Are you sure you want to delete this record?");
	if (del==true){
	   alert ("record deleted")
	}
	return del;
	}
</script>


<script type="text/javascript">
	function validateform() {

	var image=document.forms["member_s"]["image"].value;
	if (image==null || image==""){
	  document.getElementById("result").innerHTML = " Error : Insert a Photo...";
	  return false;
	}

	var name=document.forms["member_s"]["name"].value;
	if (name==null || name==""){
	  document.getElementById("result").innerHTML = " Error : Name field must not Empty...";
	  return false;
	}

	var session=document.forms["member_s"]["session"].value;
	if (session==null || session==""){
	  document.getElementById("result").innerHTML = " Error : Session field must not Empty...";
	  return false;
	}
	 
	var x = document.forms["member_s"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	
	var b=document.forms["member_s"]["email"].value;
	if (b==null || b=="")
	 {
	  document.getElementById("result").innerHTML = " Error : Email field must be filled...";
	  return false;
	 }else{
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
			return false;
		}
	 }

	return( true );
	}
	
</script>	
	

<?php include('bottom.php'); ?>