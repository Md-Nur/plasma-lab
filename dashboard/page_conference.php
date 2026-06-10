<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 
	//im=nitializing variable
	$conference = "";
	$id = 0;
	$edit_state = false;
	
	$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';

	//if save btn is clicked
	if(isset($_POST['save'])){
		$conference = addslashes($_POST['conference']);
		
		$query = "INSERT INTO conference (conference) VALUES ('$conference')";
		if ($db->query($query) === TRUE) {
			$msg = 'Journal Added..';
			$conference = '';

			$alert_success = '';
		} else {
			$msg = 'Failed to add..';

			$alert_failed = '';
		}
	}
	
	//update data
	if (isset($_POST['update'])) {
		
		$conference = addslashes($_POST['conference']);
		$id =$_POST['id'];
		
		$sql_update = mysqli_query($db, "UPDATE conference SET conference='$conference' WHERE id=$id");
		if ($sql_update === TRUE) {

			$msg = 'Updated..';
			$edit_state = true;
			$alert_success = '';

		} else {

			 $msg = 'Failed to update..';

			$alert_failed = '';

		}
	}
	
	

	
	//delete data
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM conference WHERE id=$id");
		$msg = 'Deleted..';
		$alert_success = '';
	}
	
	
		
		
	//retrive records
	$result = mysqli_query($db, "SELECT * FROM conference ORDER BY id DESC");

	
		//fetch the record to be updated
	if(isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		
		$rec = mysqli_query($db, "SELECT * FROM conference WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$conference = $record['conference'];
		$id = $record['id'];
	}

?>

	
<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
               <h3 class="panel-title">Insert/ Edit Conference</h3>
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
             <div class="clearfix"></div>
             <form method="post" action="page_conference.php">
             
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
           
                  <fieldset class="form-group">
                       <textarea class="form-control" name="conference" rows="6" required><?php echo $conference;?></textarea>
                  </fieldset>
           
                  <fieldset class="form-group">
                       <?php if ($edit_state == false): ?>
                       <button name="save" type="submit" class="btn btn-primary">Add</button>
                       <?php else: ?>
                            <div class="edit_state">
                                 <button type="submit" name="update" class="btn btn-success">Update</button>
                                 <button type="reset" class="btn btn-default">Reset</button>
                                 <a href="page_conference.php" class="btn btn-info">Add</a>
                            </div>
                       <?php endif ?>
                  </fieldset>
             </form>
             
	   </div>
    </div>
</div>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
               <h3 class="panel-title">Conference:</h3>
	   </div>
	   <div class="panel-body">
             <?php 
                  $conference_counter = 1;
                  while($row = mysqli_fetch_array($result)){ 
             ?>
             <?php 
                $id = $row['id'];
                
              ?>
                <div class="border-bottom padding-tb hover">
                     <div class="col-md-10">
                         <p><?php echo $conference_counter; ?>. &nbsp; <?php echo $row['conference'] ?></p>
                    </div>
                    <div class="col-md-2">
                         <a class="label label-default" title="Edit" href="page_conference.php?edit=<?php echo $id; ?>"><i class="fa fa-edit fa-lg"></i>  </a> 
                         <a class="label label-danger" title="Delete" href="page_conference.php?del=<?php echo $id; ?>" onclick="return deleletconfig()"> <i class="fa fa-trash-o fa-lg"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
             <?php $conference_counter++; } ?>
             
	   </div>
    </div>
</div>

	



<script>
	function deleletconfig(){

	var del=confirm("Are you sure you want to delete this record?");
	if (del==true){
	   alert ("record deleted")
	}
	return del;
	}
</script>


<?php include('bottom.php'); ?>