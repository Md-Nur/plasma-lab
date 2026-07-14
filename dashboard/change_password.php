<?php
// session_start() MUST come before any output
session_start();
include('head.php');

$admin_password = '';
if (isset($_SESSION["change_permitted_password"])) {
    $cp_id = (int) $_SESSION["change_permitted_password"];
    $cp_res = mysqli_query($db, "SELECT password FROM admin_login WHERE id = $cp_id");
    $cp_row = mysqli_fetch_array($cp_res);
    if ($cp_row) {
        $admin_password = $cp_row['password'];
    }
}

$pass_retrive = '';
$pass_validation = 'hidden';
$alert_failed = 'display : none';
$alert_success = 'display : none';
$visibility = '';
$msg = '';

if(!isset($_SESSION["change_permitted_password"]) ){
     header('Location: /dashboard/login.php');
     exit;
}


//update data
if (isset($_POST['update_password'])) {
	
	$id =$_POST['id'];
     
     if(empty($_POST["password"])) {
          $msg = "Plaese Enter a valid Password.";
          $alert_failed = '';
     }
     elseif(empty($_POST["cpassword"])) {
          $msg = "Plaese confirm your Password.";
          $alert_failed = '';
     }
     elseif($_POST["password"] == $_POST["cpassword"]) {
          $password = $_POST["password"];
          $cpassword = $_POST["cpassword"];
          if (strlen($_POST["password"]) <= '8') {
               $msg = "Your Password Must Contain At Least 8 Characters!";
               $alert_failed = '';
          }
          elseif(!preg_match("#[0-9]+#",$password)) {
               $msg = "Your Password Must Contain At Least 1 Number!";
               $alert_failed = '';
          }
         elseif(!preg_match("#[A-Z]+#",$password)) {
               $msg = "Your Password Must Contain At Least 1 Capital Letter!";
               $alert_failed = '';
          }
         elseif(!preg_match("#[a-z]+#",$password)) {
               $msg = "Your Password Must Contain At Least 1 Lowercase Letter!";
               $alert_failed = '';
         }
         else {
               $password = md5($password);
               if ($password == $admin_password) {
                    $msg = "It looks similar to previous one..Please Use different Password..";
                    $alert_failed = '';
               }
               else {
               	$sql_update = mysqli_query($db, "UPDATE admin_login SET password='$password' WHERE id=$id");
               	if ($sql_update === TRUE) {
                         
                    	unset($_SESSION['pass_validate']);
                    	unset($_SESSION["change_permitted_password"]);
                         
                    	//unset($_SESSION['retrive_id']);
                         
                         
                         header('Location: /dashboard/login.php?change='.$id);
                         exit;
                         
               	} else {
                         $msg = 'Password update error. Please try again..';
                         $alert_failed = '';
               	}
               } 
         }
     }
     else {
          $msg = "Password not matched. please try again ";
          $alert_failed = '';
     }
		
}


?>


<div class="container">    
   <div id="loginbox" style="margin-top:90px;padding:10px;" class="well box-shadow col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
       <div class="panel panel-info" >
               <div class="panel-heading">
                   <div class="panel-title pull-left">Retrive Password</div>
                   <div class="pull-right"><a href="login.php">Login</a></div>
                   <div class="clearfix"></div>
               </div>     

               <div style="padding-top:30px" class="panel-body" >
                    
                    <div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php echo $msg; ?></strong>
                   </div>
                   <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12 <?php echo $visibility; ?>">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php echo $msg; ?></strong>
                   </div>
                   <div id="result"></div>
                  <div class="clearfix"></div>
                  
                  <div class="tab-pane  <?php echo $tab_password; ?>" id="password">
                       <p class="text-warning"> Note: Password must contail at least 8 characters, 1 number, 1 uppercase letter, 1 lowercase letter.</p>
                       <form class="" id="reg_form_pass" method="post" action="change_password.php">
                            <input type="hidden" name="id" value="<?php echo $_SESSION["change_permitted_password"]; ?>">

                            <fieldset class="form-group">
                                <input  class="form-control" placeholder="Password" type="password" name="password">
                            </fieldset>

                            <fieldset class="form-group">
                                <input class="form-control" placeholder="Confirm Password" type="password" name="cpassword">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_password" id="insert" onclick="return myfnp()" value="Save" class="form-control btn btn-info" />
                            </fieldset>
                            
                       </form>
                  </div>

               </div>                     
          </div>  
   </div>

</div>




<script type="text/javascript">
	function myfn() {
	 
	var x = document.forms["myform"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	
	var b=document.forms["myform"]["email"].value;
     if (b==null || b=="")
     {
          document.getElementById("result").innerHTML = '<div id="update-alert" class="alert alert-danger col-sm-12"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Please Enter a valid Email Address..</strong></div>';
            
	  return false;
	 }else{
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			document.getElementById("result").innerHTML = '<div id="update-alert" class="alert alert-danger col-sm-12"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Please Enter a valid Email Address..</strong></div>';
			return false;
		}
	 }
	 
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        document.getElementById("result").innerHTML = '<div id="update-alert" class="alert alert-danger col-sm-12"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Please Enter a valid Email Address..</strong></div>';
        return false;
    }

	return( true );
	}
	
</script>	


<?php include('bottom.php');?>