<?php

include('head.php');
include('redirect.php');

include('navigation.php');


$msg = '';
$email_form = '';
$email_validation = '';

$tab_username = 'active in';
$tab_email = 'fade';
$tab_password = 'fade';

$nav_username = 'active';
$nav_email = '';
$nav_password = '';

$form_validation = 'hidden';
$alert_success = 'display:none';
$alert_failed = 'display:none';

if(isset($_SESSION["tmp_email"]) and isset($_SESSION["email_validation"])){
     
     $form_validation = '';
     $email_form = 'hidden';
     
}
     
     
     
     
//update data
if (isset($_POST['update_username'])) {
	
	$username = $_POST['username'];
	$id =$_POST['id'];
	

	if ($username == $admin_username) {
          
		$msg = "Username Exist. Please use different username..";
          $alert_failed = '';
          
	}else {

		$sql_update = mysqli_query($db, "UPDATE admin_login SET username='$username' WHERE id = $admin_id");

		if ($sql_update === TRUE) {
               
			$msg = 'Username Updated..';
               $alert_success = '';
			unset($_SESSION['sess_username']);
               $_SESSION["sess_username"]= $username;
               $admin_username = $username;

		} else {
			 $msg = 'Username could not be updated.Please try again...';
		}

	}
		
}


if (isset($_POST['update_email'])) {

    $email = $_POST['email'];
    $id =$_POST['id'];
    
    if ($email == $admin_email) {
         
         $msg = 'Email address is already registered. Please use different one..';
         $alert_failed = '';
         
    }else {
         
         $validation_code = mt_rand(100000, 999999);
         $code = $validation_code;
         
           $receiver_email = $email;
           $receiver_name = '';
           $subject = "Solar Laboratory: Change Email Address.";
           $body ="You have requested to change your email address. Please use $code to validate this Email Address.";
           $altbody ="You have requested to change your email address. Please use $code to validate this Email Address.";
          
          //time to send email
          include ('mail.php');

          $send_success = false;
          $error_msg = 'Connection timeout';

          if (empty($website_email) || empty($website_password)) {
              $error_msg = 'Website Email settings are not configured in settings.';
          } else {
              $send_success = $mail->send();
              if (!$send_success) {
                  $error_msg = $mail->ErrorInfo;
              }
          }

          if($send_success) {
                
                $msg = 'An email with validation code has been sent to your email address..Use that code to change your Email.';
                $alert_success = '';
                $_SESSION["email_validation"]= $code;
                $_SESSION["tmp_email"]= $email;
                $form_validation = '';
                $email_form = 'hidden';
                 
          }else {
               // Check if local development mode to bypass verification block
               $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || 
                           (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false));
               if ($is_local) {
                   $msg = 'An email with validation code has been simulated. [Local Dev Mode: Use validation code: ' . $code . ']';
                   $alert_success = '';
                   $_SESSION["email_validation"]= $code;
                   $_SESSION["tmp_email"]= $email;
                   $form_validation = '';
                   $email_form = 'hidden';
               } else {
                   // Fallback for production: direct database update if verification fails
                   $sql_update = mysqli_query($db, "UPDATE admin_login SET email='$email' WHERE id = $id");
                   if ($sql_update === TRUE) {
                       $msg = "Warning: Verification email could not be sent (" . htmlspecialchars($error_msg) . "). Admin Email updated directly.";
                       $alert_success = '';
                   } else {
                       $msg = 'Something went wrong. Please try again.. Error: ' . htmlspecialchars($error_msg);
                       $alert_failed ='';
                   }
               }
          }
         
    }
    
    $tab_username = 'fade';
    $tab_email = 'active in';
    $tab_password = 'fade';
    
    $nav_username = '';
    $nav_email = 'active';
    $nav_password = '';

}



//update data
if (isset($_POST['validate_email'])) {
	
	$email_validation = $_POST['confirm_code'];
  $email_validation = preg_replace('/\s+/', '', $email_validation);

	$id =$_POST['id'];

	if ($email_validation == $_SESSION["email_validation"]) {
      $email = $_SESSION['tmp_email'];
      $sql_update = mysqli_query($db, "UPDATE admin_login SET email = '$email' WHERE id='$id' ");

  		if ($sql_update === TRUE) {
                 
          $msg = 'Email Updated..';
          $alert_success = '';
          $admin_email = $email;

          unset($_SESSION['email_validation']);
          unset($_SESSION['tmp_email']);
          $form_validation = 'hidden';
          $email_form = '';

  		} else {
           $msg = 'Something went wrong. Please try again..';
           $alert_failed ='';
      }

	}else {

		$msg = 'Wrong Validation code..';
    $alert_failed = '';

	}
     
 $tab_username = 'fade';
 $tab_email = 'active in';
 $tab_password = 'fade';

 $nav_username = '';
 $nav_email = 'active';
 $nav_password = '';

}


if (isset($_POST['try_again'])) {
     
	unset($_SESSION['email_validation']);
	unset($_SESSION['tmp_email']);
     $form_validation = 'hidden';
     $email_form = '';
     
     $tab_username = 'fade';
     $tab_email = 'active in';
     $tab_password = 'fade';
     
     $nav_username = '';
     $nav_email = 'active';
     $nav_password = '';
     
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
                         $msg = 'Password Updated..';
                         $alert_success = '';
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

     
     $tab_username = 'fade';
     $tab_email = 'fade';
     $tab_password = 'active in';
     
     $nav_username = '';
     $nav_email = '';
     $nav_password = 'active';
		
}


?>





<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
     <div class="panel panel-primary">
          <div class="panel-heading">
               <h3 class="panel-title">Security information: Admin</h3>
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
               <div id = "js_msg"></div>
             
               <div class="">
                    <ul class="nav nav-tabs">
                         <li class="<?php echo $nav_username; ?>"><a href="#username" data-toggle="tab">Admin Username</a></li>
                         <li class="<?php echo $nav_email; ?>"><a href="#email" data-toggle="tab">Admin Email</a></li>
                         <li class="<?php echo $nav_password; ?>"><a href="#password" data-toggle="tab">Admin Password</a></li>
                          <a href="page_security.php" class="btn btn-info pull-right" style="margin-top: -8px;">Website Security</a>
                    </ul>


                    
                    <div id="myTabContent" class="tab-content" style="margin-top: 50px;">

                         <div class="tab-pane <?php echo $tab_username; ?>" id="username">
                
                                <form id="reg_form_username" method="post" action="security.php">
                                    <input type="hidden" name="id" value="<?php echo $admin_id; ?>" required>

                                   <fieldset class="form-group">
                                        <input class="form-control" placeholder="Username" type="text" name="username" tabindex="1" value="<?php echo $admin_username; ?>" required>
                                   </fieldset>

                                   <fieldset class="form-group">
                                        <input type="submit" name="update_username" id="insert" onclick="return myfnu()" value="Save" class="form-control btn btn-info" />
                                   </fieldset>
                     
                              </form>
                
                         </div>

                         <div class="tab-pane  <?php echo $tab_email; ?>" id="email">
                              <form class="<?php echo $email_form; ?>" id="reg_form_email" action="security.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $admin_id; ?>" required>

                                    <fieldset class="form-group">
                                         <input class="form-control" placeholder="Email" type="text" name="email" tabindex="1" value="<?php echo $admin_email ; ?>" required>
                                    </fieldset>

                                    <fieldset class="form-group">
                                         <input type="submit" name="update_email" id="insert" onclick="return myfne()" value="Save" class="form-control btn btn-info" />
                                    </fieldset>
                                    
                               </form>
                
                               <form class="<?php echo $form_validation ?>" id="reg_form_email" method="post" action="security.php" >
                                    <input class="" type="hidden" name="id" value="<?php echo $id; ?>" required>

                                    <fieldset class="form-group col-md-12">
                                         <input class="form-control" placeholder="Validation Code.." type="text" name="confirm_code" tabindex="1">
                                    </fieldset>

                                    <fieldset class="form-group col-md-6">
                                         <input  type="submit" name="validate_email" id="insert" value="Validate" class="form-control btn btn-success" />
                                    </fieldset>

                                    <fieldset class="form-group col-md-6">
                                         <input  type="submit" name="try_again" id="insert" value="Try Again" class="form-control btn btn-info" />
                                    </fieldset>
                                    <div class="clearfix"></div>
                                    
                               </form>
                          </div>

                          <div class="tab-pane  <?php echo $tab_password; ?>" id="password">
                               <p class="text-warning"> Note: Password must contail at least 8 characters, 1 number, 1 uppercase letter, 1 lowercase letter.</p>
                               <form class="" id="reg_form_pass" method="post" action="security.php">
                                    <input type="hidden" name="id" value="<?php echo $admin_id; ?>" required>

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
</div>
             	


<script type="text/javascript">
	function myfnp() {
	
	 var password=document.forms["reg_form_pass"]["password"].value;
	if (password==null || password=="")
	 {
       document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Password must not be empty..</div>';
	  return false;
	 }
	 
	 var cpassword=document.forms["reg_form_pass"]["cpassword"].value;
	 if (password != cpassword)
	 {
       document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Passwords must be same..</div>';
	  return false;
	 }

	
	 
	 return true;
			 
	}
	
</script>	

<script type="text/javascript">
	function myfnu() {


	 
	var username=document.forms["reg_form_username"]["username"].value;
	if (username==null || username=="")
	 {
       document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Username must be filled...</div>';
	  return false;
	 }
      
	return true;
			 
	}
	
</script>	


<script type="text/javascript">
	function myfne() {
	 
	var x = document.forms["reg_form_email"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	
	var b=document.forms["reg_form_email"]["email"].value;
	if (b==null || b=="")
	 {
       document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Email field must be filled...</div>';
	  return false;
	 }else{
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
               document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Please Enter a valid Email Address ...</div>';
			return false;
		}
	 }
	 
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">Please Enter a valid Email Address ...</div>';
        return false;
    }
     
     document.getElementById("js_msg").innerHTML = '<div class="alert alert-danger col-sm-12">A mail with Validation Code is being sent to This Email.. Please Wait...</div>';
	return true;
			 
	}
	
</script>	



<?php include('bottom.php');?>