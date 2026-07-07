<?php
// session_start() MUST come before any output
session_start();
include('head.php');

$pass_retrive = '';
$pass_validation = 'hidden';
$alert_failed = 'display : none';
$alert_success = 'display : none';
$visibility = '';
$msg = '';

if(isset($_SESSION["pass_validate"]) && isset($_SESSION["retrive_id"])){
     
     $pass_validation = '';
     $pass_retrive = 'hidden';
     
}


if(isset($_POST['submit'])){

    $email_tmp =$_POST['email'];
       
    $sql = "SELECT * FROM admin_login WHERE email = '$email_tmp';";
    $result = mysqli_query($db,$sql);
    $rowcount = mysqli_num_rows($result);
     
    if ($rowcount == 1){
          
        $rec = mysqli_query($db, $sql);
    		$row = mysqli_fetch_array($rec);
              
    		$firstname =  $row['firstname'];
    		$lastname =  $row['lastname'];
        $receiver_name = $firstname.' '.$lastname ;
    		$username =  $row['username'];
    		$receiver_email =  $row['email'];
    		$id =  $row['id'];
              
    		$tmp_password = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));
        $subject = 'Retrive Password';
    

        //body table
        $message = '<html><body>';
        $message .= '<h3>Solar Energy Laboratory: Retrive Password</h3>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Username: </strong> </td><td>" .$username. "</td></tr>";
        $message .= "<tr style=''><td><strong>Validation Code: </strong> </td><td>" .$tmp_password. "</td></tr>";
        $message .= "</table>";
        $message .= '<p>Use this validation code to change password.</p>';
        $message .= "</body></html>";

        $body = $message;
        $altbody = 'Use '.$tmp_password.' to change your password.';


        //time to send email
        include ('../mail.php');

        //after mail sent condition
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
                     
      			$msg = "An email with validation code has been sent to this email.";
             $alert_success = '';
             $visibility = 'hidden';
             $pass_retrive = 'hidden';
             $pass_validation= '';
                     
             $_SESSION["pass_validate"]= $tmp_password;
             $_SESSION["retrive_id"]= $id;
                     
      		}else{
      			$msg =  "Sorry !! Message not sent. Error: " . htmlspecialchars($error_msg);
            
            // Check if local development mode to bypass verification block
            $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || 
                        (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false));
            if ($is_local) {
                $msg .= " [Local Dev Mode: Use validation code: " . $tmp_password . "]";
                $_SESSION["pass_validate"]= $tmp_password;
                $_SESSION["retrive_id"]= $id;
                $visibility = 'hidden';
                $pass_retrive = 'hidden';
                $pass_validation= '';
                $alert_success = ''; // Change alert format to success to display the code cleanly
            } else {
                $alert_failed = '';
            }
      		}

	}else{

      $msg =  "Incorrect Email. This Email is not registered.";
      $alert_failed = '';

  }
		
}

//update data
if (isset($_POST['validate_pass'])) {
	
	$pass_validation = $_POST['code'];

	$id =$_POST['id'];

	if ($pass_validation == $_SESSION["pass_validate"]) {
          
          $_SESSION["change_permitted_password"]= $id;
          header('location: change_password.php');

	}else {
		$msg = 'Wrong Validation code..';
          $alert_failed = '';
	}

	
}

if (isset($_POST['try_again'])) {
     
     session_unset();
     session_destroy();
     $pass_validation = 'hidden';
     $pass_retrive = '';
     
     
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
                   <form id="" class="<?php echo $pass_retrive ?>" method="post" action="forgot_pass.php">
      
                       <fieldset  class="form-group">
                            <input type="email" class="form-control"  name="email" id="email" placeholder="Your Email" data-rule="email" required/>
                       </fieldset>
                       
                       <fieldset class="form-group">
                              <input onclick="myfn()"  name="submit" type="submit" id="" class="btn btn-success" value="Retrive Password">
                       </fieldset>
     
                  </form>   
                  
                  <form class="<?php echo $pass_validation ?>" id="" method="post" action="forgot_pass.php" >
                       <input type="hidden" name="id" value="<?php echo $_SESSION["retrive_id"]; ?>" required>

                       <fieldset class="form-group col-md-12">
                            <input class="form-control" placeholder="Validation Code.." type="text" name="code" tabindex="1" value="">
                       </fieldset>

                       <fieldset class="form-group col-md-6">
                           <input  type="submit" name="validate_pass" id="insert" value="Validate" class="form-control btn btn-success" />
                       </fieldset>
                       
                       <fieldset class="form-group col-md-6">
                           <input  type="submit" name="try_again" id="insert" value="Try Again" class="form-control btn btn-info" />
                       </fieldset>
                       
                  </form>

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
     document.getElementById("result").innerHTML = '<div id="update-alert" class="alert alert-success col-sm-12"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>An email with validation code is sending..</strong></div>';
	return( true );
	}
	
</script>	


<?php include('bottom.php');?>