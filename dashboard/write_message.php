<?php
include('head.php');
include('redirect.php'); 
include('navigation.php');

$id = '';


?>



<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Write a Message</h3>
	   </div>
	   <div class="panel-body">
		 
         <?php include('message.php');?>   
               
	   </div>
	   <div class="panel-footer">
               <span class="pull-right">
                <a href="inbox.php" class="btn btn-warning" type="button"><i class="glyphicon glyphicon-arrow-left"></i> Go Back To Inbox</a>
               </span>
               <div class="clearfix"></div>
	   </div>
    </div>
</div>

<?php include('bottom.php');?>
