<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 


$active_inbox = 'active';
$active_sent = '';
$active_draft = '';
$active_write = '';

$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';

$display_select_in = '';
$display_select_sent = '';
$display_select_draft = '';

if (isset($_GET['red'])) {
	$red = $_GET['red'];

	if ($red == "sent") {

		$active_inbox = '';
		$active_sent = 'active';
		$active_draft = '';

	}else if($red == "draft"){

		$active_inbox = '';
		$active_sent = '';
		$active_draft = 'active';

	}else{
		$active_inbox = 'active';
		$active_sent = '';
		$active_draft = '';
	}


}


//delete data
if(isset($_GET['dell_inbox'])){
	
      $encrypted_id = $_GET['dell_inbox'];
        $salt="How_You_Dare_To_hack";
        $decrypted_id_raw = base64_decode($encrypted_id);
        $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);

	mysqli_query($db, "DELETE FROM message WHERE id=$id");
	$msg = 'Message Deleted from Inbox';
      $alert_success = '';
}

if(isset($_POST['delete_marked_inbox'])){

      $i = 0;
      foreach($_POST['chkbox_in'] as $key => $val){

            $id=$val;

            mysqli_query($db, "DELETE FROM message WHERE id=$id");
            
            $i++;

      }
      if ($i == 1) {
        $msg = $i.' message have been deleted from Inbox';
      }
      else{
        $msg = $i.' messages have been deleted from Inbox';
      }
      
      $alert_success = '';

}


if(isset($_GET['dell_sent'])){
	
      $encrypted_id = $_GET['dell_sent'];
        $salt="How_You_Dare_To_hack";
        $decrypted_id_raw = base64_decode($encrypted_id);
        $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);

	mysqli_query($db, "DELETE FROM sent_msg WHERE id=$id");
	$msg = 'Message Deleted';
      $alert_success = '';
      $active_inbox = '';
      $active_sent = 'active';
      $active_draft = '';
}

if(isset($_POST['delete_marked_sent'])){
      $i=0;
      foreach($_POST['chkbox_sent'] as $key => $val){

            $id=$val;

            mysqli_query($db, "DELETE FROM sent_msg WHERE id=$id");
            $i++;
            $active_inbox = '';
            $active_sent = 'active';
            $active_draft = '';
      }
      if ($i == 1) {
        $msg = $i.' message have been deleted from Sent Messages';
      }
      else{
        $msg = $i.' messages have been deleted from Sent Messages';
      }
      
      $alert_success = '';

}



if(isset($_GET['dell_draft'])){
	
      $encrypted_id = $_GET['dell_draft'];
        $salt="How_You_Dare_To_hack";
        $decrypted_id_raw = base64_decode($encrypted_id);
        $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);

	mysqli_query($db, "DELETE FROM sent_msg WHERE id=$id");
	$msg = 'Message Deleted from Draft';
      $alert_success = '';
      $active_inbox = '';
      $active_sent = '';
      $active_draft = 'active';
}

if(isset($_POST['delete_marked_draft'])){
  $i = 0;
      foreach($_POST['chkbox_draft'] as $key => $val){

            $id=$val;

            mysqli_query($db, "DELETE FROM sent_msg WHERE id=$id");
          
            $active_inbox = '';
            $active_sent = '';
            $active_draft = 'active';
            $i++;

      }
      if ($i == 1) {
        $msg = $i.' message have been deleted from Draft';
      }
      else{
        $msg = $i.' messages have been deleted from Draft';
      }
      
      $alert_success = '';

}

//next-previous

$start_in = 0;
$end_in = 30;

$start_sent = 0;
$end_sent = 30;

$start_draft = 0;
$end_draft = 30;

$next_in = 'visible';
$previous_in = 'hidden';

$next_sent = 'visible';
$previous_sent = 'hidden';

$next_draft = 'visible';
$previous_draft = 'hidden';

//for inbox messages
$count_inbox = mysqli_query($db, "SELECT * FROM message ");
$rowcount_inbox=mysqli_num_rows($count_inbox);

if ($rowcount_inbox == 0) {
  $display_select_in = 'hidden';
}

if ($rowcount_inbox <= $end_in) {
  $previous_in = 'hidden';
  $next_in = 'hidden';
}

if(isset($_POST['previous_in'])){

        $start_in = $_POST['page'];

        if ($start_in == 0) {
          $start_in = 0 ;
        }else{

          $previous_in = 'visible';
          $start_in = $start_in - $end_in;
          if ( $start_in <= 0) {
            $start_in = 0;
            $previous_in = 'hidden';
          }
        }


}else if(isset($_POST['next_in'])){

      $start_in = $_POST['page'];
      $previous_in = 'visible';

      $start_in = $start_in + $end_in ;


      //$compare = $rowcount_inbox - ( $start_in + $end_in);
      $compare = $start_in + $end_in;

      if ($compare >= $rowcount_inbox) {

      $next_in = 'hidden';

      }else {

      $next_in = 'visible';

      }


}


//for sent messages
$count_sent = mysqli_query($db, "SELECT * FROM sent_msg WHERE success= 1");
$rowcount_sent=mysqli_num_rows($count_sent);

if ($rowcount_sent == 0) {
  $display_select_sent = 'hidden';
}

if ($rowcount_sent <= $end_sent) {
  $previous_sent = 'hidden';
  $next_sent = 'hidden';
}

if(isset($_POST['previous_sent'])){

        $start_sent = $_POST['page'];

        if ($start_sent == 0) {
          $start_sent = 0 ;
        }else{

          $previous_sent = 'visible';
          $start_sent = $start_sent - $end_sent;
          if ( $start_sent <= 0) {
            $start_sent = 0;
            $previous_sent = 'hidden';
          }
        }
      $active_inbox = '';
      $active_sent = 'active';
      $active_draft = '';

}else if(isset($_POST['next_sent'])){

      $start_sent = $_POST['page'];
      $previous_sent = 'visible';

      $start_sent = $start_sent + $end_sent ;


      $compare = $start_sent + $end_sent;

      if ($compare >= $rowcount_sent) {

      $next_sent = 'hidden';

      }

      $active_inbox = '';
      $active_sent = 'active';
      $active_draft = '';

}

//for draft messages
$count_draft = mysqli_query($db, "SELECT * FROM sent_msg WHERE success= 0");
$rowcount_draft=mysqli_num_rows($count_draft);

if ($rowcount_draft == 0) {
  $display_select_draft = 'hidden';
}

if ($rowcount_draft <= $end_draft) {
  $previous_draft = 'hidden';
  $next_draft = 'hidden';
}

if(isset($_POST['previous_draft'])){

        $start_draft = $_POST['page'];

        if ($start_draft == 0) {
          $start_draft = 0 ;
        }else{

          $previous_draft = 'visible';
          $start_draft = $start_draft - $end_draft;
          if ( $start_draft <= 0) {
            $start_draft = 0;
            $previous_draft = 'hidden';
          }
        }
      $active_inbox = '';
      $active_sent = '';
      $active_draft = 'active';

}else if(isset($_POST['next_draft'])){

      $start_draft = $_POST['page'];
      $previous_draft = 'visible';

      $start_draft = $start_draft + $end_draft ;


      $compare = $start_draft + $end_draft;

      if ($compare >= $rowcount_draft) {

      $next_draft = 'hidden';

      }

      $active_inbox = '';
      $active_sent = '';
      $active_draft = 'active';

}


?>



<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" >

    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Messages</h3>
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
             <div id="exTab3" class="">	
             	<ul  class="nav nav-pills hidden-xs" id="myTab">
             		<li class="<?php echo $active_inbox; ?>">
             			<a  href="#tab_inbox" data-toggle="tab">Inbox</a>
             		</li>
             		<li  class="<?php echo $active_sent; ?>">
             			<a href="#tab_sent" data-toggle="tab">Sent</a>
             		</li>
             		<li  class="<?php echo $active_draft; ?>">
                              <a href="#tab_draft" data-toggle="tab">Drafts</a>
                        </li>
                        <li  class="<?php echo $active_write; ?>">
                              <a href="#tab_write" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span> Write Message</a>
             		</li>
             	</ul>
             
             	<div class="tab-content clearfix">
             
             		<!--      Inbox        -->
             		<div class="tab-pane <?php echo $active_inbox; ?>" id="tab_inbox">
                    <form name="inbox_form" method="POST" action="inbox.php">
                   			<h3 class="">All Messages</h3>

                        

                        
                      
                        <ul class="list-group">
                          <div class="clearfix"></div>
                          <li class="list-group-item borderless <?php echo $display_select_in;?>">
                            <span class="round">
                                <input type="checkbox" id="inbox" onClick="select_in(this)"/>
                                <label for="inbox"></label>
                            </span>
                            <span class="" style="margin-left: 15px;">
                                    Select All
                            </span>
                            <input class="btn btn-danger pull-right " style="margin-top: -8px;" type="submit" name="delete_marked_inbox" value="Delete Marked" onclick="return deleteinbox()">
                            
                            <div class="clearfix"></div>
                          </li>
                                
                               <?php 

                                    $inbox_msg = mysqli_query($db, "SELECT * FROM message  ORDER BY id DESC LIMIT $start_in , $end_in");
                                    while($msg_inbox = mysqli_fetch_array($inbox_msg)){ 
       
                                    $flag = $msg_inbox['flag'];
 
                                    if ($flag == 1) {
                                          $mark_read ="Mark as Unread";
                                          $opacity = 'opacity: .7;';
                                    }else {
                                          $mark_read ="Mark as Read";
                                          $opacity = 'opacity: 1;';
                                    }
                                    $id = $msg_inbox['id'];
                                    $salt="How_You_Dare_To_hack";
                                    $encrypted_id = base64_encode($id . $salt);

                                    if (strlen($msg_inbox['subject']) <= 70) {
                                      $inbox_subject = $msg_inbox['subject'];
                                    }else {
                                      $inbox_subject = substr($msg_inbox['subject'], 0, 70).'...';
                                    }
 
                              ?>

                              <li class="list-group-item hover" style="<?php echo $opacity; ?>">
                                   
                                    <span class="round">
                                        <input type="checkbox" id="inbox<?php echo $msg_inbox['id'];?>" name="chkbox_in[]"  value="<?php echo $msg_inbox['id'];?>"/>
                                        <label for="inbox<?php echo $msg_inbox['id'];?>"></label>
                                    </span>
                                    <span class="" style="margin-left: 15px;">
                                          <a href="view_message.php?view=<?php echo $encrypted_id; ?>">
                                                <strong><?php echo $msg_inbox['name']; ?>:</strong> <?php echo $inbox_subject; ?>
                                          </a>
                                    </span>
                                          
                                    <div class="pull-right">
                                          
                                          
                                          <span class="label label-default"><?php echo $msg_inbox['time']; ?></span>
                                          <span class="label label-default"><?php echo $msg_inbox['date']; ?></span>
                                          
                                          <a style="margin:8px;" href = "write_message.php?user=<?php echo $encrypted_id; ?>" title="Replay" ><span class="glyphicon glyphicon-share"></span></a>

                                          <a class="label label-danger" href = "inbox.php?dell_inbox=<?php echo $encrypted_id; ?>" onclick="return deleletconfig()" title="Delete">
                                                <i class="fa fa-trash-o fa-lg"></i>
                                          </a>
                                    </div>
                                          
                                    <div class="clearfix"></div>
                                    
                              </li>

                        <?php } ?>
                        </ul> 

                        <div class="pull-middle">
                          <form method="post" action="inbox.php">
                            <input type="hidden" name="page" value="<?php echo $start_in; ?>">
                            <button class="<?php echo $previous_in; ?>" type="submit" name="previous_in" style="width: 150px;margin: 10px;"><< Previous</button>
                            <button class="<?php echo $next_in; ?>" type="submit" name="next_in" style="width: 150px;margin: 10px;">Next >></button>
                          </form>
                        </div>

                  </form>
             		</div>
             		<!--      /Inbox        -->
             
             
             
             		<!--      Sent Messages        -->
             		<div class="tab-pane <?php echo $active_sent; ?>" id="tab_sent">
                              <form method="POST" action="inbox.php">
                                    <h3 class="pull-left">Sent Messages</h3>
                                   
                                    <div class="clearfix"></div>
                                    <ul class="list-group">
                                      <div class="clearfix"></div>
                                      <li class="list-group-item borderless <?php echo $display_select_sent;?>">
                                        <span class="round">
                                            <input type="checkbox" id="sent" onClick="select_sent(this)"/>
                                            <label for="sent"></label>
                                        </span>
                                        <span class="" style="margin-left: 15px;">
                                                Select All
                                        </span>
                                        <input class="btn btn-danger pull-right " style="margin-top: -8px;" type="submit" name="delete_marked_sent" value="Delete Marked" onclick="return deletesent()">
                                        <div class="clearfix"></div>
                                      </li>
                                           <?php 

                                                $sent_msg = mysqli_query($db, "SELECT * FROM sent_msg WHERE success = '1' ORDER BY id DESC LIMIT $start_sent , $end_sent ");
                                                while($msg_sent = mysqli_fetch_array($sent_msg)){ 

                                                $id = $msg_sent['id'];
                                                $salt="How_You_Dare_To_hack";
                                                $encrypted_id = base64_encode($id . $salt);

                                                if (strlen($msg_sent['subject']) <= 70) {
                                                  $sent_subject = $msg_sent['subject'];
                                                }else {
                                                  $sent_subject = substr($msg_sent['subject'], 0, 70).'...';
                                                }
             
                                          ?>

                                          <li class="list-group-item hover" style="">
                                               
                                                <span class="round">
                                                    <input type="checkbox" id="sent<?php echo $msg_sent['id'];?>" name="chkbox_sent[]"  value="<?php echo $msg_sent['id'];?>"/>
                                                    <label for="sent<?php echo $msg_sent['id'];?>"></label>
                                                </span>
                                                <span class="" style="margin-left: 15px;">
                                                      <a href="view_message.php?view_sent=<?php echo $encrypted_id; ?>">
                                                            <strong><?php echo $msg_sent['name']; ?>:</strong> <?php echo $sent_subject; ?>
                                                      </a>
                                                </span>
                                                      
                                                <div class="pull-right">
                                                      
                                                      
                                                      <span class="label label-default"><?php echo $msg_sent['time']; ?></span>
                                                      <span class="label label-default"><?php echo $msg_sent['date']; ?></span>
                                                      
                                                      <a class="label label-danger" href = "inbox.php?dell_sent=<?php echo $encrypted_id; ?>" onclick="return deleletconfig()" title="Delete">
                                                            <i class="fa fa-trash-o fa-lg"></i>
                                                      </a>
                                                </div>
                                                      
                                                <div class="clearfix"></div>
                                                
                                          </li>

                                    <?php } ?>
                                    </ul> 

                                    <div class="pull-middle">
                                      <form method="post" action="inbox.php">
                                        <input type="hidden" name="page" value="<?php echo $start_sent; ?>">
                                        <button class="<?php echo $previous_sent; ?>" type="submit" name="previous_sent" style="width: 150px;margin: 10px;"><< Previous</button>
                                        <button class="<?php echo $next_sent; ?>" type="submit" name="next_sent" style="width: 150px;margin: 10px;">Next >></button>
                                      </form>
                                    </div>

                              </form>
             		</div>
             
             
             
             
             		
             		<!--     / Sent Messages        -->
             
             
             
             
             		<!--     Message Draft        -->
             		<div class="tab-pane <?php echo $active_draft; ?>" id="tab_draft">
             			<form method="POST" action="inbox.php">
                                    <h3 class="pull-left">Drafts</h3>
                                    
                                    <div class="clearfix"></div>
                                    <ul class="list-group">
                                      <div class="clearfix"></div>
                                      <li class="list-group-item borderless <?php echo $display_select_draft;?>">
                                        <span class="round">
                                            <input type="checkbox" id="draft" onClick="select_draft(this)"/>
                                            <label for="draft"></label>
                                        </span>
                                        <span class="" style="margin-left: 15px;">
                                                Select All
                                        </span>
                                        <input class="btn btn-danger pull-right " style="margin-top: -8px;" type="submit" name="delete_marked_draft" value="Delete Marked" onclick="return deletedraft()">
                                        <div class="clearfix"></div>
                                      </li>
                                           <?php 

                                                $draft_msg = mysqli_query($db, "SELECT * FROM sent_msg WHERE success = '0' ORDER BY id DESC LIMIT $start_draft , $end_draft ");
                                                while($msg_draft = mysqli_fetch_array($draft_msg)){ 

                                                $id = $msg_draft['id'];
                                                $salt="How_You_Dare_To_hack";
                                                $encrypted_id = base64_encode($id . $salt);

                                                if (strlen($msg_draft['subject']) <= 70) {
                                                  $draft_subject = $msg_draft['subject'];
                                                }else {
                                                  $draft_subject = substr($msg_draft['subject'], 0, 70).'...';
                                                }
             
                                          ?>

                                          <li class="list-group-item hover" style="">
                                               
                                                <span class="round">
                                                    <input type="checkbox" id="draft<?php echo $msg_draft['id'];?>" name="chkbox_draft[]"  value="<?php echo $msg_draft['id'];?>"/>
                                                    <label for="draft<?php echo $msg_draft['id'];?>"></label>
                                                </span>
                                                <span class="" style="margin-left: 15px;">
                                                      <a href="view_message.php?view_draft=<?php echo $encrypted_id; ?>">
                                                            <strong><?php echo $msg_draft['name']; ?>:</strong> <?php echo $draft_subject; ?>
                                                      </a>
                                                </span>
                                                      
                                                <div class="pull-right">
                                                      
                                                      
                                                      <span class="label label-default"><?php echo $msg_draft['time']; ?></span>
                                                      <span class="label label-default"><?php echo $msg_draft['date']; ?></span>
                                                      
                                                      <a class="label label-danger" href = "inbox.php?dell_draft=<?php echo $encrypted_id; ?>" onclick="return deleletconfig()" title="Delete">
                                                            <i class="fa fa-trash-o fa-lg"></i>
                                                      </a>
                                                </div>
                                                      
                                                <div class="clearfix"></div>
                                                
                                          </li>

                                    <?php } ?>
                                    </ul> 

                                    <div class="pull-middle">
                                      <form method="post" action="inbox.php">
                                        <input type="hidden" name="page" value="<?php echo $start_draft; ?>">
                                        <button class="<?php echo $previous_draft; ?>" type="submit" name="previous_draft" style="width: 150px;margin: 10px;"><< Previous</button>
                                        <button class="<?php echo $next_draft; ?>" type="submit" name="next_draft" style="width: 150px;margin: 10px;">Next >></button>
                                      </form>
                                    </div>

                              </form>
             		</div>
             		<!--     /Message Draft        -->

                        <!--     Message Draft        -->
                        <div class="tab-pane <?php echo $active_write; ?>" id="tab_write">
                              <h3>Write a Message</h3>
                              <div class="tab-pane" id="">
                                    <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
             
             
                                    <?php include('message.php');?>
             
             
             
                                    </div>
                              </div>
                        </div>
                        <!--     /Message Draft        -->
             
             	</div>
             </div>




	   </div>
	
    </div>
</div>










<script type="text/javascript">
	function validateform() {

	var a=document.forms["myform"]["name"].value;
	if (a==null || a=="")
	 {
	  document.getElementById("result").innerHTML = " Error : Name field must be filled...";
	  return false;
	 }
	 
	var x = document.forms["myform"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	
	var b=document.forms["myform"]["email"].value;
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
	 
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
        return false;
    }
	

	var c=document.forms["myform"]["subject"].value;
	if (c==null || c=="") {
	  document.getElementById("result").innerHTML = " Error : Subject field must be filled...";
	  return false;
	}
	var d=document.forms["myform"]["message"].value;
	if (d==null || d=="") {
	  document.getElementById("result").innerHTML = " Error : Please write a message .........";
	  return false;
	}
	var elem = document.getElementById("result");
	elem.innerHTML = "Message is sending";
	elem.style.color = "#00BEFD";


	return( true );
	}
	
</script>	
	
	
<script>
	$('#myform').submit(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "contact-form.php",
			data: $(this).serialize(),		
			success: function(data){
				$('#result').html(data);
			}					
		}).done(function() {
				$("#myform").trigger("reset");
			});
	});
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


<?php include('bottom.php');?>