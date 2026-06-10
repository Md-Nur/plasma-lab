<?php
include('head.php'); 
	include('redirect.php'); 
	include('navigation.php'); 
	//im=nitializing variable
	$title = "";
	$description = "";
	$id = 1;

	$alert_failed = 'display : none';
	$alert_success = 'display : none';
	$msg = '';
	//connect to database
	

	//update data
	if (isset($_POST['update'])) {
		
		$title = addslashes($_POST['title']);
		$description = addslashes($_POST['description']);

		$sql_update = mysqli_query($db, "UPDATE vission SET title='$title', description='$description' WHERE id=$id");

		if ($sql_update === TRUE) {
                
         $msg = 'Page Vission Updated.';  
         $alert_success = '';

		} else {

		$msg = 'Unable to Update.';  
         $alert_failed = '';

		}

	}
	


	$rec = mysqli_query($db, "SELECT * FROM vission WHERE id=$id");
	$record = mysqli_fetch_array($rec);
	$title = $record['title'];
	$description = $record['description'];
	
?>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Page Vission</h3>
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
			 <div class="clearfix"></div>
			 <section class="">

	<form  method="post" action="page_vission.php">
		<fieldset class="form-group">
			<textarea class="form-control" name="title" placeholder=" Description..." rows="3" ><?php echo $title; ?></textarea>
		</fieldset>

		<fieldset class="form-group">
			<textarea class="form-control" name="description" placeholder=" Description..." rows="8" ><?php echo $description; ?></textarea>
		</fieldset>

		<fieldset class="form-group">
		
			<button type="submit" name="update" class="btn btn-success">Update</button>
			<button type="reset"  class="btn btn-default">Reset</button>
		
		</fieldset>
	</form>

			</section>
               
		  </div>
	   </div>
    </div>
</div>


<?php	include('bottom.php'); ?>