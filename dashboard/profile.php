<?php include ('head.php');?>
<?php include ('redirect.php');?>
<?php include ('navigation.php');?>


<div class="well box-shadow col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1" style="margin-top:50px;">
    <div class="panel panel-primary">
	   <div class="panel-heading">
		  <h3 class="panel-title">Admin's information</h3>
	   </div>
	   <div class="panel-body">
		  <div class="row">
			 <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
				<img class=" img-responsive" src="assets/images/admin/<?php echo $admin_image; ?>" alt="Profile Picture">
			 </div>
			 <div class="col-xs-12 col-sm-2 hidden-md hidden-lg">
				<img class=" img-responsive" src="assets/images/admin/<?php echo $admin_image; ?>" alt="Profile Picture">
			 </div>

			 <div class=" col-md-9 col-lg-9">
				<strong><h3> <?php echo $admin_fullname; ?></h3></strong><br>
				<table class="table table-user-information">
				    <tbody>
					    <tr>
                                  <td>User level:</td> <td>Administrator</td>
					    </tr>
					    <tr>
						   <td>Email Address:</td> <td><?php echo $admin_email; ?></td>
					    </tr>
					    <tr>
						   <td>Contact No.</td> <td><?php echo $admin_phone;?></td>
					    </tr>
				    </tbody>
				</table>
               </div>
               
		  </div>
	   </div>
	   <div class="panel-footer">
		  <span class="pull-right">
			 <a href="edit_profile.php" class="btn btn-warning" type="button"><i class="glyphicon glyphicon-edit"></i> Edit</a>
		  </span>
            <div class="clearfix"></div>
	   </div>
    </div>
</div>

<?php include('bottom.php');?>
