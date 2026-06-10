<?php

include('db_connect.php');

$notice_num = mysqli_query($db, "SELECT * FROM notice");
$num_rows = mysqli_num_rows($notice_num);



?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/back_toto_notice.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

 <?php include('menu.php'); ?>

<div class="clearfix"></div>

<section style="width: 60%; margin: 150px auto; margin-bottom: 300px;padding: 10px;background-color: #F0F0E1;border-radius: 8px;box-shadow: 3px 3px 5px 3px rgba(10, 10, 10, 0.47);">


  <?php 

  $i = 1;
  $result = mysqli_query($db, "SELECT * FROM notice");
  while($row = mysqli_fetch_array($result)){ 

?>
  <div class="notice notice-success col-md-12">

      <strong ><?php echo $i; ?> . </strong>

      <span style="padding-right: 100px;"><?php echo $row['title']; ?></span>

      <span class="pull-right text-success readMore">Read</span>
        
        
      <div class="desc">
          <p style="white-space: pre-line;border-top: 1px solid red;margin: 5px; font-size: 15px;">
              <?php echo $row['description']; ?>
          </p>        
      </div>
  </div>
<?php $i++; } ?>


<div class="clearfix"></div>
</section>








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

<div class="clearfix"></div>

<?php include('footer.php'); ?>



<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

