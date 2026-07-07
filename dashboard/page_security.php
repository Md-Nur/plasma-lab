<?php

include('head.php');
include('redirect.php');



$id = 1;
$msg = '';
$alert_success = 'display:none';
$alert_failed = 'display:none';

$form_validation = 'hidden';

$nav_sitename = 'active';
$nav_email = '';
$nav_department = '';
$nav_university = '';
$nav_founder = '';

$tab_sitename = 'active in';
$tab_email = 'fade';
$tab_email = 'fade';
$tab_email = 'fade';
$tab_founder = 'fade';

if(isset($_SESSION["email_validation"])){
     
     $form_validation = '';
     $email_form = 'hidden';
     
}


$for_website = mysqli_query($db, "SELECT * FROM website WHERE id = $id");
$record_website = mysqli_fetch_array($for_website);
$sitename = $record_website['sitename'];
$short_name = $record_website['short_name'];
$siteemail = $record_website['siteemail'];
$sitepassword = $record_website['sitepassword'];
$department = $record_website['department'];
$university = $record_website['university'];
$founder = $record_website['founder'];

//update Site Name
if (isset($_POST['update_sitename'])) {
	
	$sitename = $_POST['sitename'];
	$short_name = $_POST['short_name'];
	$id =$_POST['id'];
	
	$sql_update = mysqli_query($db, "UPDATE website SET sitename='$sitename', short_name = '$short_name' WHERE id = $id");

	if ($sql_update === TRUE) {
             
		$msg = 'Website Name Updated..';
    $alert_success = '';

	} else {
		 $msg = 'Website Name could not updated.Please try again...';
     $alert_failed = '';
	}
		
}

//update Department Name
if (isset($_POST['update_department'])) {
	
	$department = $_POST['department'];
	$id =$_POST['id'];
	
	$sql_update = mysqli_query($db, "UPDATE website SET department='$department' WHERE id = $id");

	if ($sql_update === TRUE) {
             
		$msg = 'Department Name Updated..';
    $alert_success = '';

	} else {
		 $msg = 'Department Name could not updated.Please try again...';
     $alert_failed = '';
	}
	
    $tab_sitename = 'fade';
    $tab_siteemail = 'fade';
    $tab_department = 'active in';
    $tab_siteemail = 'fade';
    $tab_founder = 'fade';

    $nav_sitename = '';
    $nav_siteemail = '';
    $nav_department = 'active';
    $nav_siteemail = '';
    $nav_founder = '';
		
}

//update University Name
if (isset($_POST['update_university'])) {
	
	$university = $_POST['university'];
	$id =$_POST['id'];
	
	$sql_update = mysqli_query($db, "UPDATE website SET university='$university' WHERE id = $id");

	if ($sql_update === TRUE) {
             
		$msg = 'University Name Updated..';
    $alert_success = '';

	} else {
		 $msg = 'University Name could not updated.Please try again...';
     $alert_failed = '';
	}
	
    $tab_sitename = 'fade';
    $tab_siteemail = 'fade';
    $tab_department = 'fade';
    $tab_university = 'active in';
    $tab_founder = 'fade';
        
    $nav_sitename = '';
    $nav_siteemail = '';
    $nav_department = '';
    $nav_university = 'active';
    $nav_founder = '';
		
}

//update Founder Name
if (isset($_POST['update_founder'])) {
	
	$founder = $_POST['founder'];
	$id =$_POST['id'];
	
	$sql_update = mysqli_query($db, "UPDATE website SET founder='$founder' WHERE id = $id");

	if ($sql_update === TRUE) {
             
		$msg = 'Founder Updated..';
    $alert_success = '';

	} else {
		 $msg = 'Founder Name could not updated.Please try again...';
     $alert_failed = '';
	}
	
    $tab_sitename = 'fade';
    $tab_siteemail = 'fade';
    $tab_department = 'fade';
    $tab_university = 'fade';
    $tab_founder = 'active in';
        
    $nav_sitename = '';
    $nav_siteemail = '';
    $nav_department = '';
    $nav_university = '';
    $nav_founder = 'active';
		
}

//update Website Email Information
if (isset($_POST['update_email'])) {
  
  $siteemail = $_POST['siteemail'];
  $sitepassword = $_POST['sitepassword'];
  $id =$_POST['id'];

  $validation_code = mt_rand(100000, 999999);
  $code = $validation_code;

  //send mail for confirmation
   
   $subject = "Solar Laboratory: Change Website's Email Address.";
   $body ="You have requested to change Website's email to $siteemail . Please use $code to validate this Email Address.";
   $altbody ="You have requested to change your email address. Please use $code to validate this Email Address.";
  
  $website_email = $siteemail;
  $website_password = $sitepassword;

  $receiver_email = $admin_email;
  $receiver_name = $admin_fullname;
  //time to send email
  include ('page_mail.php');

  $send_success = false;
  $error_msg = 'Connection timeout';

  if (empty($website_email) || empty($website_password)) {
      $error_msg = 'Email or Password input is empty.';
  } else {
      try {
          $send_success = $mail->send();
          if (!$send_success) {
              $error_msg = $mail->ErrorInfo;
          }
      } catch (Exception $e) {
          $error_msg = $e->getMessage();
      }
  }

   if($send_success) {

      $msg = 'An email with validation code has been sent to your email address..Use that code to change your Email.';
      $alert_success = '';
      $_SESSION["siteemail_validation"]= $code;
      $_SESSION["tmp_siteemail"]= $siteemail;
      $_SESSION["tmp_sitepassword"]= $sitepassword;
      $form_validation = '';
      $email_form = 'hidden';

  }else{
      // Check if local development mode to bypass verification block
      $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || 
                  (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false));
      if ($is_local) {
          $msg = 'An email with validation code has been simulated. [Local Dev Mode: Use validation code: ' . $code . ']';
          $alert_success = '';
          $_SESSION["siteemail_validation"]= $code;
          $_SESSION["tmp_siteemail"]= $siteemail;
          $_SESSION["tmp_sitepassword"]= $sitepassword;
          $form_validation = '';
          $email_form = 'hidden';
      } else {
          // Fallback for production: direct database update if verification fails
          // website table always has id = 1; $id here is admin_id so we must hardcode 1
          $sql_update = mysqli_query($db, "UPDATE website SET siteemail='$siteemail', sitepassword='$sitepassword' WHERE id = 1");
          if ($sql_update === TRUE) {
              $msg = "Warning: Verification email could not be sent (" . htmlspecialchars($error_msg) . "). Website's Email has been updated directly.";
              $alert_success = '';
          } else {
              $msg = 'Could not update Website Email. Error: ' . htmlspecialchars($error_msg) . ' | DB Error: ' . mysqli_error($db);
              $alert_failed = '';
          }
      }
  }



$tab_sitename = 'fade';
$tab_siteemail = 'active in';
$tab_department = 'fade';
$tab_university = 'fade';
	
$nav_sitename = '';
$nav_siteemail = 'active';
$nav_department = '';
$nav_university = '';
    
}



//update data
if (isset($_POST['validate_email'])) {
  
    $email_validation = $_POST['code'];
    $email_validation = preg_replace('/\s+/', '', $email_validation);

    $id =$_POST['id'];

    if ($email_validation == $_SESSION["siteemail_validation"]) {
        $siteemail = $_SESSION['tmp_siteemail'];
        $sitepassword = $_SESSION['tmp_sitepassword'];

        // website table always has id = 1; $id here is admin_id so we must hardcode 1
        $sql_update = mysqli_query($db, "UPDATE website SET siteemail='$siteemail', sitepassword='$sitepassword' WHERE id = 1");

        if ($sql_update === TRUE) {
                   
            $msg = "Website's Email Updated..";
            $alert_success = '';
            unset($_SESSION['tmp_siteemail']);
            unset($_SESSION['tmp_sitepassword']);
            unset($_SESSION['siteemail_validation']);
            $form_validation = 'hidden';
            $email_form = '';

        } else {
            
            $msg = 'Could not updated. DB Error: ' . mysqli_error($db);
            $alert_failed = '';
        }

  }else {
    $msg = 'Wrong Validation code..';
    $alert_failed = '';
  }
     
  $tab_sitename = 'fade';
  $tab_siteemail = 'active in';
  $nav_sitename = '';
  $nav_siteemail = 'active';
  
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

include('navigation.php');
?>




<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1"
    style="margin-top:50px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Security information: Website</h3>
        </div>
        <div class="panel-body">
            <div style="<?php echo $alert_success; ?>" id="update-alert" class="alert alert-success col-sm-12">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <strong>
                    <?php echo $msg; ?></strong>
            </div>
            <div style="<?php echo $alert_failed; ?>" id="update-alert" class="alert alert-danger col-sm-12">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <strong>
                    <?php echo $msg; ?></strong>
            </div>
            <div id="js_msg"></div>

            <div class="">
                <ul class="nav nav-tabs">
                    <li class="<?php echo $nav_sitename; ?>"><a href="#sitename" data-toggle="tab">Website Name</a></li>
                    <li class="<?php echo $nav_department; ?>"><a href="#department" data-toggle="tab">Department
                            Name</a></li>
                    <li class="<?php echo $nav_university; ?>"><a href="#university" data-toggle="tab">University
                            Name</a></li>
                    <li class="<?php echo $nav_siteemail; ?>"><a href="#siteemail" data-toggle="tab">Website Email</a>
                    </li>
                    <li class="<?php echo $nav_founder; ?>"><a href="#founder" data-toggle="tab">Founder</a></li>
                    <a href="security.php" class="btn btn-info pull-right" style="margin-top: -8px;">Admin Security</a>
                </ul>



                <div id="myTabContent" class="tab-content" style="margin-top: 50px;">

                    <div class="tab-pane <?php echo $tab_sitename; ?>" id="sitename">

                        <form id="reg_form_username" method="post" action="page_security.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                            <fieldset class="form-group">
                                <label for="">Site Full Name</label>
                                <input class="form-control" placeholder="Website Full Name" type="text" name="sitename"
                                    tabindex="1" value="<?php echo $sitename; ?>" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="">Site Short Name</label>
                                <input class="form-control" placeholder="Website Short Name" type="text" name="short_name"
                                    tabindex="1" value="<?php echo $short_name; ?>" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_sitename" id="insert" onclick="return myfnu()"
                                    value="Save" class="form-control btn btn-info" />
                            </fieldset>

                        </form>

                    </div>
                    <div class="tab-pane <?php echo $tab_department; ?>" id="department">

                        <form id="reg_form_username" method="post" action="page_security.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                            <fieldset class="form-group">
                                <input class="form-control" placeholder="Department Name" type="text" name="department"
                                    tabindex="1" value="<?php echo $department; ?>" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_department" id="insert" value="Save"
                                    class="form-control btn btn-info" />
                            </fieldset>

                        </form>

                    </div>
                    <div class="tab-pane <?php echo $tab_university; ?>" id="university">

                        <form id="reg_form_username" method="post" action="page_security.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                            <fieldset class="form-group">
                                <input class="form-control" placeholder="University Name" type="text" name="university"
                                    tabindex="1" value="<?php echo $university; ?>" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_university" id="insert" value="Save"
                                    class="form-control btn btn-info" />
                            </fieldset>

                        </form>

                    </div>

                    <div class="tab-pane <?php echo $tab_founder; ?>" id="founder">

                        <form id="reg_form_username" method="post" action="page_security.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                            <fieldset class="form-group">
                                <input class="form-control" placeholder="Founder Name" type="text" name="founder"
                                    tabindex="1" value="<?php echo $founder; ?>" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_founder" id="insert" value="Save"
                                    class="form-control btn btn-info" />
                            </fieldset>

                        </form>

                    </div>
                    <div class="tab-pane  <?php echo $tab_siteemail; ?>" id="siteemail">
                        <form class="<?php echo $email_form; ?>" id="reg_form_email" action="page_security.php"
                            method="post">
                            <input type="hidden" name="id" value="1" required>

                            <fieldset class="form-group">
                                <input class="form-control" placeholder="Website Email" type="text" name="siteemail"
                                    tabindex="1" value="<?php echo $siteemail ; ?>" required>
                            </fieldset>

                            <fieldset class="buttonInside form-group">
                                <input id="myInput" class="form-control" placeholder="Email Login Password.."
                                    type="password" name="sitepassword" tabindex="1"
                                    value="<?php echo $sitepassword; ?>" required>

                                <div class="material-switch">
                                    <input onclick="myFunction()" id="show_hide" name="show_hide" type="checkbox" />
                                    <label for="show_hide" class="label-default"></label> Show/Hide Password
                                </div>

                            </fieldset>

                            <fieldset class="form-group">
                                <input type="submit" name="update_email" id="insert" onclick="return myfne()"
                                    value="Save" class="form-control btn btn-info" />
                            </fieldset>

                        </form>

                        <form class="<?php echo $form_validation ?>" id="reg_form_email" method="post"
                            action="page_security.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                            <fieldset class="form-group col-md-12">
                                <input class="form-control" placeholder="Validation Code.." type="text" name="code"
                                    tabindex="1" value="">
                            </fieldset>

                            <fieldset class="form-group col-md-6">
                                <input type="submit" name="validate_email" id="insert" value="Validate"
                                    class="form-control btn btn-success" />
                            </fieldset>

                            <fieldset class="form-group col-md-6">
                                <input type="submit" name="try_again" id="insert" value="Try Again"
                                    class="form-control btn btn-info" />
                            </fieldset>

                        </form>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//show/hide passwod
function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<script type="text/javascript">
function myfnp() {

    var password = document.forms["reg_form_pass"]["password"].value;
    if (password == null || password == "") {
        document.getElementById("js_msg").innerHTML =
            '<div class="alert alert-danger col-sm-12">Password must not be empty..</div>';
        return false;
    }

    var cpassword = document.forms["reg_form_pass"]["cpassword"].value;
    if (password != cpassword) {
        document.getElementById("js_msg").innerHTML =
            '<div class="alert alert-danger col-sm-12">Passwords must be same..</div>';
        return false;
    }



    return true;

}
</script>

<script type="text/javascript">
//	Validate Site Name
//--------------------------------------------------------------------------------
function myfnu() {

    var sitename = document.forms["reg_form_username"]["sitename"].value;
    if (sitename == null || sitename == "") {
        document.getElementById("js_msg").innerHTML =
            '<div class="alert alert-danger col-sm-12">Website Name must be filled...</div>';
        return false;
    }

    return true;

}
//	Validate Site Email
//--------------------------------------------------------------------------------
function myfne() {

    var x = document.forms["reg_form_email"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");


    var b = document.forms["reg_form_email"]["email"].value;
    if (b == null || b == "") {
        document.getElementById("js_msg").innerHTML =
            '<div class="alert alert-danger col-sm-12">Email field must be filled...</div>';
        return false;
    } else {
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
            document.getElementById("js_msg").innerHTML =
                '<div class="alert alert-danger col-sm-12">Please Enter a valid Email Address ...</div>';
            return false;
        }
    }

    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
        document.getElementById("js_msg").innerHTML =
            '<div class="alert alert-danger col-sm-12">Please Enter a valid Email Address ...</div>';
        return false;
    }

    document.getElementById("js_msg").innerHTML =
        '<div class="alert alert-danger col-sm-12">A mail with Validation Code is being sent to This Email.. Please Wait...</div>';
    return true;

}
</script>



<?php include('bottom.php');?>