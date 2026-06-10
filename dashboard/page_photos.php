
<?php

include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$image = 'demo_image.png';
//im=nitializing variable

$alert_failed = 'display : none';
$alert_success = 'display : none';
$image = "demo_image.png";
$id = 0;

//if save btn is clicked
if(isset($_POST['insert'])){
	//path to store
     $tmp_name = $_FILES['image']['tmp_name'];
     $new_name = time().".jpg";
    

	if (move_uploaded_file($tmp_name, "../images/gallary/photos/".$new_name)) {

		$sql = "INSERT INTO photos(image ) VALUES ('$new_name')";
		if ($db->query($sql) === TRUE) {

               $msg = 'Image Uploaded..';
               $alert_success = '';

        } else {

             $msg = 'Could not upload. Please try again..';
             $alert_failed = '';

        }

	}else {

          $msg = 'Could not upload. Please try again..';
          $alert_failed = '';

	}
	
}

//delete data
if(isset($_GET['del'])){
	$id = $_GET['del'];
     
     $sql = "SELECT * FROM photos WHERE id=$id";
     $result = mysqli_query($db,$sql);
     $rowcount=mysqli_num_rows($result);
     
     if ($rowcount == 1) {
          
      $result = mysqli_query($db, "SELECT * FROM photos WHERE id=$id");
     	$row = mysqli_fetch_array($result);
     	$del_image=$row['image'];
     	unlink("../images/gallary/photos/".$del_image);
     	mysqli_query($db, "DELETE FROM photos WHERE id=$id");
     	
          $msg = 'Deleted..';
          $alert_success = '';
          
     }else {
          $msg = 'Failed..';
          $alert_failed = '';
     }
     
	
}


//retrive records
$result = mysqli_query($db, "SELECT * FROM photos");




?>



<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 " style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
               <h3 class="panel-title pull-left">Gallary: Photos</h3>
               <button type="button" class="pull-right btn btn-info" data-toggle="modal" data-target="#insert_photos">Insert Photos</button>
               <div class="clearfix"></div>
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
             
             <?php while($row = mysqli_fetch_array($result)){ ?>
             <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 well" style="padding:10px;">
                  <div class="" style="width:100%;overflow: hidden;">
                       <img src="../images/gallary/photos/<?php echo $row['image']; ?>" class="img-responsive" style="height:150px; width:100%;" alt="">
                  </div>

                  <div class="pull-right">
                      <a class="label label-danger" href="page_photos.php?del=<?php echo $row['id']; ?>" onclick="return deleletconfig()" title="Delete">
                        <i class="fa fa-trash-o fa-lg"></i>
                      </a>
                  </div>
                  
             </div>
             <?php } ?>
             
             <div class='clearfix'></div>
	   </div>
        
    </div>
</div>




<style type="text/css">


[type=file] {
    position: absolute;
    filter: alpha(opacity=0);
    opacity: 0;
}
input,
[type=file] + label {
 border: 1px solid #CCC;
 border-radius: 3px;
 text-align: left;
 position: relative;
}
[type=file] + label {
 text-align: center;
 /* Decorative */
 background: #333;
 color: #fff;
 border: none;
 cursor: pointer;
}
[type=file] + label:hover {
 background: #3399ff;
}
.photo_review{
    display: absolute;

}

</style>	


<div id="insert_photos" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
        
      </div>
      <div class="modal-body">
           
           <div class=" col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
               <div class="panel panel-primary">
           	   <div class="panel-heading">
                          <h3 class="panel-title">Upload Photos <span id="result" style="margin-left: 20px;"></span></h3>
                          
                          <div class="clearfix"></div>
           	   </div>
           	   <div class="panel-body">
                     
                       <div class="">
                        <form id="upload_photo" method="post" action="page_photos.php" enctype="multipart/form-data">
                             <input type="hidden" name="id" value="<?php echo $id; ?>" required>
            
                             <div class="col-md-12">
                               <img id="output" class="img-responsive" src="../images/member/students/<?php echo $image; ?>">
                            </div>
            
                            <div class="clearfix"></div>
                            <br>
            
                             <div class="col-md-6 photo_post form-group">
                                  <input class="form-control btn btn-info" name="image" id="f02" type="file" placeholder="Add profile picture" onchange="loadFile(event)"/>
                                  <label class="form-control btn btn-info" for="f02">Choose Photo</label>
                             </div>
            
                             <fieldset class="col-md-6 form-group">
                                  <input onclick="return validateform()" type="submit" name="insert" id="insert" value="Insert" class="form-control btn btn-info" />
                             </fieldset>
                        </form>
                   </div>
                        
           	   </div>
                   
               </div>
               
           </div>
           <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script>
  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
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

<script type="text/javascript">
	function validateform() {

	var image=document.forms["upload_photo"]["image"].value;
	if (image==null || image==""){
	  document.getElementById("result").innerHTML = " Error : Insert a Photo...";
	  return false;
	}

	return( true );
	}
	
</script>	

	
<?php include('bottom.php');?>