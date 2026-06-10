<?php

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php echo $site_row['sitename']; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=1.1">

    <script src="js/jquery-2.1.4.min.js"></script>


</head>

<body>

    <?php include 'menu.php';?>


    <?php
$result_members = mysqli_query($db, "SELECT * FROM members");
$result_students = mysqli_query($db, "SELECT * FROM students");
?>
    <div class="clearfix"></div>


    <section id="team" class="pb-5">
        <div class="container">
            <div class="title-div text-center">
                <h1><span>L</span>ab <span>M</span>embers</h1>
            </div>
            <div class="tittle-style" style="margin-bottom: 50px;"></div>
            <div class="clearfix"></div>
            <div class="row">

                <?php while ($row_members = mysqli_fetch_array($result_members)) {?>

                <?php

    $show_designation = '';

    $show_phone = '';

    $show_email = '';

    $show_info = '';

    $show_link = '';

    if ($row_members['designation'] == "" || $row_members['designation'] == null) {
        $show_designation = 'hidden';
    }
    if ($row_members['phone'] == "" || $row_members['phone'] == null) {
        $show_phone = 'hidden';
    }
    if ($row_members['email'] == "" || $row_members['email'] == null) {
        $show_email = 'hidden';
    }
    if ($row_members['info'] == "" || $row_members['info'] == null) {
        $show_info = 'hidden';
    }
    if ($row_members['link'] == "" || $row_members['link'] == null) {
        $show_link = 'hidden';
    }

    ?>
      
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div id="all">
                        <div class="view view-first">
                            <img src="images/member/members/<?php echo $row_members['image']; ?>" />
                            <div class="mask">
                                <h2><?php echo $row_members['name']; ?></h2>
                                <p> <?php echo $row_members['designation']; ?></p>
                                <a href="#" class="info" data-toggle="modal" data-target="#myModal_<?php echo $row_members['id']; ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade member-modal" id="myModal_<?php echo $row_members['id']; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="modal-img">
                                    <img class="img-responsive"
                                        src="images/member/members/<?php echo $row_members['image']; ?>" alt="img"
                                        style="width:80%;margin:0 auto;">
                                </div>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <h2>
                                        <?php echo $row_members['name']; ?>
                                    </h2>
                                    <h4 class="<?php echo $show_designation; ?>">
                                        <?php echo $row_members['designation']; ?>
                                    </h4>
                                    <h4 class="<?php echo $show_phone; ?>">Phone:
                                        <?php echo $row_members['phone']; ?>
                                    </h4>
                                    <h4 class="<?php echo $show_email; ?>" style="color: blue;font-style: italic;">
                                        E-mail:
                                        <?php echo $row_members['email']; ?>
                                    </h4>
                                </div>
                                <div class="members-description <?php echo $show_info; ?>" style="margin-top: 10px;">
                                    <p style="white-space: pre-line;font-size: 16px;">
                                        <?php echo $row_members['info']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <a class="<?php echo $show_link; ?>" href="<?php echo $row_members['link']; ?>"
                                        target="_blank"><button type="button" class="btn btn-info">More
                                            Details</button></a></span>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- ./Team member -->
                <?php }?>
                <!-- ./Team member -->

            </div>
        </div>
    </section>




    <div class="clearfix"></div>


    <section class="" style="background-color:#f5f5f5;">
        <div class="container">
            <div class="title-div text-center">
                <h1>
                    <span>L</span>ab
                    <span>S</span>tudents
                </h1>
                <div class="tittle-style"></div>
            </div>
            <div class="clearfix"></div>
            <div class="team-row">

                <?php while ($row_students = mysqli_fetch_array($result_students)) {?>
                <div class=" students col-lg-2 col-md-3 col-sm-6 col-xxs-12">
                    <div class="student-item">
                        <img class="img-responsive" src="images/member/students/<?php echo $row_students['image']; ?>"
                            alt="img">
                        <div class="student-info">
                            <h3>
                                <?php echo $row_students['name']; ?>
                            </h3>
                            <h4 class="email">ferdousapee@gmail.com</h4>
                            <h4>
                                <?php echo $row_students['session']; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="clearfix"> </div>
            </div>
        </div>
    </section>


    <?php include 'notice.php';?>

    <?php include 'footer.php';?>



    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <script src="js/jquery.flexisel.js"></script>
    <script src="js/easing.js"></script>

</body>

</html>
