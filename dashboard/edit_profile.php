<?php
include('head.php');
include ('redirect.php');
include('navigation.php');

$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';
//update data
if (isset($_POST['update'])) {
     
     if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])){
          
          $firstname = $_POST['firstname'];
          $lastname = $_POST['lastname'];
          $phone = $_POST['phone'];
          $id =$_POST['id'];

          $sql_update = mysqli_query($db, "UPDATE admin_login SET firstname='$firstname', lastname='$lastname', phone='$phone' WHERE id=$admin_id");
          if ($sql_update === TRUE) {
               
               $alert_success = '';
               $msg = "Profile Updated";
               $admin_firstname = $firstname;
               $admin_lastname = $lastname;
               $admin_phone = $phone;

          } else {
               
               $alert_failed = "";
               $msg = "Update Failed. Try again";

          }
          
     }   
     else {
          
          $tmp_name = $_FILES['image']['tmp_name'];
          $new_name = time().".jpg";
          
          if (move_uploaded_file($tmp_name, "assets/images/admin/".$new_name)){
          	$firstname = $_POST['firstname'];
          	$lastname = $_POST['lastname'];
               $phone = $_POST['phone'];
          	$id =$_POST['id'];

          	$sql_update = mysqli_query($db, "UPDATE admin_login SET firstname='$firstname', lastname='$lastname', phone='$phone', image='$new_name' WHERE id=$id");
               if ($sql_update === TRUE) {
                    
                    unlink("assets/images/admin/".$admin_image);
                    $alert_success = '';
               	$msg = "Profile Updated";
                    $admin_image = $new_name;
                    $admin_firstname = $firstname;
                    $admin_lastname = $lastname;
                    $admin_phone = $phone;

               } else {
                    
                    $alert_failed = "";
               	$msg = "Update Failed. Try again";

               }
          }
          
     }
     
     
     
          
     
}





?>


<style type="text/css">

[type=file] {
   position: absolute;
   filter: alpha(opacity=0);
   opacity: 0;
}
input,
[type=file] + label {
border: 1px solid #CCC;
border-radius: 3px;
text-align: left;
position: relative;
}
[type=file] + label {
text-align: center;
/* Decorative */
background: #6D6E6A;
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






<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Admin's information</h3>
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
			 <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
				<img id="output"  class="img-responsive" src="assets/images/admin/<?php echo $admin_image; ?>" alt="Profile Picture">
			 </div>
			 <div class="col-xs-12 col-sm-2 hidden-md hidden-lg">
				<img id="output"  class="img-responsive" src="assets/images/admin/<?php echo $admin_image; ?>" alt="Profile Picture">
			 </div>

			 <div class=" col-md-9 col-lg-9">
                     <form id="profile_form" method="post" action="edit_profile.php" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $admin_id; ?>">
                          
                          <div class="photo_post">
                               <input class=" btn btn-info" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
                               <label class=" btn btn-info" for="f02">Change Profile Picture</label>
                          </div>
      
                          <div class="clearfix"></div>
      
                          <fieldset  class="form-group">
                               <label class="">Firstname: </label>
                               <input class="form-control" placeholder="Firstname ...." type="text" name="firstname"  value="<?php echo $admin_firstname; ?>" required>
                          </fieldset>
      
                          <fieldset  class="form-group">
                               <label class="">Lastname: </label>
                               <input class="form-control" placeholder="Lastname ...." type="text" name="lastname" value="<?php echo $admin_lastname; ?>" required>
                          </fieldset>
                          
                          <fieldset  class="form-group">
                               <label class="">Contact No: </label>
                               <input class="form-control" placeholder="Contact No. ...." type="text" name="phone" value="<?php echo $admin_phone; ?>" required>
                          </fieldset>
      
 
                          <fieldset class="form-group">
                              <input type="submit" name="update" id="update" class="form-control btn btn-info" value="Update"/>
                          </fieldset>
      
      
                     </form>
               </div>
               
		  </div>
	   </div>
	   <div class="panel-footer">
             <span class="pull-right">
 			 <a href="profile.php" class="btn btn-warning" type="button"><i class="glyphicon glyphicon-arrow-left"></i> Go Back To Profile</a>
 		  </span>
            <div class="clearfix"></div>
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


<?php include('bottom.php');?>
