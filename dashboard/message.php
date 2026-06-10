<?php

$to_email = '';
$to_name = '';

if (isset($_GET['user'])) {
     $encrypted_id = $_GET['user'];
	  $salt="How_You_Dare_To_hack";
	  $decrypted_id_raw = base64_decode($encrypted_id);
	  $id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);
     
    $rec = mysqli_query($db, "SELECT * FROM message WHERE id = '$id'");
    $record = mysqli_fetch_array($rec);
    $to_name = $record['name'];
    $to_email = $record['email'];
}




?>


 <form id="myform" action="" method="post" >
      

      <fieldset>
        <label class="">To: </label>
        <input type="text" class="form-control" name="name" id="nmae" placeholder="Receiver's Name" value="<?php echo $to_name;?>" required/>
      </fieldset>

      <fieldset class="form-group">
        <label class="">Email: </label>
        <input class="form-control" type="email" placeholder="Receiver's Email.." name="email" value="<?php echo $to_email;?>" tabindex="1" required>
      </fieldset>

      <fieldset>
        <label class="">Subject: </label>
        <input class="form-control"  placeholder="Message subject..." type="text" name="subject" value="" tabindex="4" required>
      </fieldset>

      <fieldset>
        <label class="">Message: </label>
        <textarea class="form-control"  type="text" name="message" placeholder="Write a message..." id="" cols="150" rows="8" value="" required></textarea>
      </fieldset>
      <div class="space"></div>
      <fieldset class="col-md-2">
        <input onclick="return validateform()" name="submit" type="submit" value="Send Message" id="contact-submit" class="btn btn-success form-control">
      </fieldset>

      <div id='result'></div>
 </form>


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
<script src="assets/js/jquery.min.js"></script>                 
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