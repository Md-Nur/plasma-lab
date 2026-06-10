<?php

include('head.php');
include ('redirect.php');
include('navigation.php');
//initializing variable
$title = "";
$description = "";
$id = 0;
$edit_state = false;
$i = 1;

$alert_failed = 'display : none';
$alert_success = 'display : none';
$msg = '';

//connect to database

//if save btn is clicked
if(isset($_POST['submit'])){

	$title = addslashes($_POST['title']);
	$description = addslashes($_POST['description']);
	
	$query = "INSERT INTO notice (title, description) VALUES ('$title','$description')";

	if ($db->query($query) === TRUE) {

		 $alert_success = '';
          $msg = "Notice Published";

	} else {

		 $msg = "Failed to publish";
		 $alert_failed = '';

	}
}
	
//update data
if (isset($_POST['update'])) {
	
	$title = addslashes($_POST['title']);
	$description = addslashes($_POST['description']);
	$id = $_POST['id'];
	
	$sql_update = mysqli_query($db, "UPDATE notice SET title='$title', description='$description' WHERE id=$id");

	if ($sql_update === TRUE) {
            
        $msg = 'Updated';
        $alert_success = '';
        $edit_state = true;

	} else {

		$msg = 'Failed';
		$alert_failed = '';

	}

}



//delete data
if(isset($_GET['dell'])){
	$id = $_GET['dell'];
	mysqli_query($db, "DELETE FROM notice WHERE id=$id");

	$msg = 'Deleted';
	$alert_success ='';
}


	
	
//retrive records

$result = mysqli_query($db, "SELECT * FROM notice ORDER BY id DESC");

	//fetch the record to be updated
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$edit_state = true;
	
	$rec = mysqli_query($db, "SELECT * FROM notice WHERE id=$id");
	$record = mysqli_fetch_array($rec);
	$title = $record['title'];
	$description = $record['description'];
	$id = $record['id'];
}

?>


<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Add/Edit Notices</h3>
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


	<form  method="post" action="page_notice.php">
		
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="clearfix"></div>
		<fieldset  class="form-group">
			<input class="form-control" placeholder="Title ...." type="text" name="title" tabindex="1" value="<?php echo $title; ?>" required>
		</fieldset>

		<fieldset class="form-group">
			<textarea class="form-control" name="description" placeholder=" Description..." width="" rows="6" ><?php echo $description; ?></textarea>
		</fieldset>

		<fieldset class="file-input action">
			<?php if ($edit_state == false): ?>
				<button name="submit" type="submit" class="btn btn-primary">Add</button>
			<?php else: ?>
				<div class="edit_state">
					<button type="submit" name="update" class="btn btn-info">Update</button>
					<a href="page_notice.php" class="btn btn-default">Reset</a>
				</div>
			<?php endif ?>
		</fieldset>

	</form>


		  </div>
	   </div>

    </div>
</div>

<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Notices</h3>
	   </div>
	   <div class="panel-body">
             
             
		  <div class="row">

	<?php
	$i = 1;
	 while($row = mysqli_fetch_array($result)){ 
	 ?>
		
	     		<div class="pull-left">
	     			<h2><strong> <?php echo $i; ?>:  </strong> <?php echo $row['title']; ?></h2>
	    			 <p><?php echo $row['description']; ?></p>
	     		</div>
		      <div class="pull-right"> 
		           <a href = "page_notice.php?edit=<?php echo $row['id']; ?>" class="label label-default" title="Edit"> 
		                <i class="fa fa-edit fa-lg"></i>
		          </a>
		          <a href = "page_notice.php?dell=<?php echo $row['id']; ?>" onclick="return deleletconfig()" class="label label-danger" title="Delete"> 
		               <i class="fa fa-trash-o fa-lg"></i>
		          </a>
		     </div>    
	           
	     <div class="clearfix"></div>
	     <hr>
	<?php $i++; } ?>



		  </div>
	   </div>

    </div>
</div>





<script src="assets/js/bootstrap.min.js"></script>

<script>
	function deleletconfig(){

	var del=confirm("Are you sure you want to delete this record?");
	if (del==true){
	   alert ("record deleted")
	}
	return del;
	}
</script>

<script type="text/javascript">

    $(document).ready(function(){
        $(".readMore").click(function(){
            var This=$(this);    
            $(this).next().toggle(function(){
                if(This.text()=="Read"){
                    This.text("Hide") 
                }
                else{
                    This.text("Read") 
                }
            })
        });
    })
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
