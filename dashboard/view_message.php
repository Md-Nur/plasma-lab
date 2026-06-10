<?php 
include('head.php');
include('redirect.php'); 
include('navigation.php');
$display = '';
$from_to = '';
$redirect = '';

if(isset($_GET['view'])) {
  
  $encrypted_id = $_GET['view'];
  $salt="How_You_Dare_To_hack";
  $decrypted_id_raw = base64_decode($encrypted_id);
  $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);

  $sql_update = mysqli_query($db, "UPDATE message SET flag='1' WHERE id = $id ");
  
  $rec = mysqli_query($db, "SELECT * FROM message WHERE id=$id");
  $record = mysqli_fetch_array($rec);
  $name = $record['name'];
  $email = $record['email'];
  $time = $record['time'];
  $date = $record['date'];
  $subject = $record['subject'];
  $message = $record['msg'];
  $from_to = 'From';

}

if(isset($_GET['view_sent'])) {
  
  $encrypted_id = $_GET['view_sent'];
  $salt="How_You_Dare_To_hack";
  $decrypted_id_raw = base64_decode($encrypted_id);
  $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);
  
  $rec = mysqli_query($db, "SELECT * FROM sent_msg WHERE id=$id");
  $record = mysqli_fetch_array($rec);
  $name = $record['name'];
  $email = $record['email'];
  $time = $record['time'];
  $date = $record['date'];
  $subject = $record['subject'];
  $message = $record['msg'];
  $display = 'hidden';
  $from_to = 'To';
  $redirect = 'sent';


}

if(isset($_GET['view_draft'])) {
  
  $encrypted_id = $_GET['view_draft'];
  $salt="How_You_Dare_To_hack";
  $decrypted_id_raw = base64_decode($encrypted_id);
  $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);
  
  $rec = mysqli_query($db, "SELECT * FROM sent_msg WHERE id=$id");
  $record = mysqli_fetch_array($rec);
  $name = $record['name'];
  $email = $record['email'];
  $time = $record['time'];
  $date = $record['date'];
  $subject = $record['subject'];
  $message = $record['msg'];
  $display = 'hidden';
  $from_to = 'Tried to';
  $redirect = 'draft';


}


?>
     <div class="well  col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
         <div class="panel panel-primary">
     	   <div class="panel-heading">

     		  <?php echo $from_to; ?>: <?php echo $name; ?> ( <?php echo $email; ?> )
          
          <div class="pull-right">               
                <span class=""><?php echo $time; ?></span>
                <span class=""><?php echo $date; ?></span>
                
              
          </div>
         <div class="clearfix"></div>
     	   </div>
     	   <div class="panel-body">
                  
            
              <div class="pull-left"><strong> Subject: <?php echo $subject; ?> </strong></div>

              <div class="pull-right <?php echo $display;?>">
                <a class="btn btn-default" style="border-radius: 10%;" href = "write_message.php?user=<?php echo $encrypted_id; ?>" title="Replay" >
                      <span class="glyphicon glyphicon-share" style="" ></span>
                </a>

              </div>
              
            <div class="clearfix"></div>

            <hr>
            <p><?php echo $message; ?></p>
                  
     	   </div>
         <div class="panel-footer">
               <span class="pull-right">
                <a href="inbox.php?red=<?php echo $redirect;?>" class="btn btn-warning" type="button"><i class="glyphicon glyphicon-arrow-left"></i> Go Back To Inbox</a>
               </span>
               <div class="clearfix"></div>
         </div>
         </div>
     </div>

     <?php include('bottom.php');?>