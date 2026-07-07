<?php

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Plasma Engineering Laboratory
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
            
            <div class="members-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-top: 30px;">
                <?php while ($row_members = mysqli_fetch_array($result_members)) {
                    $show_designation = ($row_members['designation'] == "" || $row_members['designation'] == null) ? 'hidden' : '';
                    $show_phone = ($row_members['phone'] == "" || $row_members['phone'] == null) ? 'hidden' : '';
                    $show_email = ($row_members['email'] == "" || $row_members['email'] == null) ? 'hidden' : '';
                    $show_info = ($row_members['info'] == "" || $row_members['info'] == null) ? 'hidden' : '';
                    $show_link = ($row_members['link'] == "" || $row_members['link'] == null) ? 'hidden' : '';
                ?>
                <div class="member-card-wrapper">
                    <div class="view view-first" onclick="document.getElementById('myModal_<?php echo $row_members['id']; ?>').showModal();">
                        <img src="images/member/members/<?php echo $row_members['image']; ?>" alt="<?php echo $row_members['name']; ?>" />
                        <div class="mask">
                            <h2><?php echo $row_members['name']; ?></h2>
                            <p><?php echo $row_members['designation']; ?></p>
                            <a href="#" class="info" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('myModal_<?php echo $row_members['id']; ?>').showModal();">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Native HTML5 Dialog Modal -->
                <dialog id="myModal_<?php echo $row_members['id']; ?>" closedby="any" class="modern-dialog">
                    <div class="dialog-header">
                        <h3 class="dialog-title"><?php echo htmlspecialchars($row_members['name']); ?></h3>
                        <button class="dialog-close-btn" onclick="document.getElementById('myModal_<?php echo $row_members['id']; ?>').close();" aria-label="Close dialog">&times;</button>
                    </div>
                    <div class="dialog-body text-center">
                        <div class="modal-img" style="margin-bottom: 20px;">
                            <img src="images/member/members/<?php echo $row_members['image']; ?>" alt="img"
                                 style="max-width: 260px; width: 100%; height: auto; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin: 0 auto; display: block; object-fit: cover;">
                        </div>
                        <div class="member-meta" style="text-align: left; max-width: 480px; margin: 0 auto;">
                            <h4 class="<?php echo $show_designation; ?>" style="font-weight: 700; color: var(--lab-plum); font-size: 16px; margin-bottom: 12px;">
                                <?php echo htmlspecialchars($row_members['designation']); ?>
                            </h4>
                            <h4 class="<?php echo $show_phone; ?>" style="font-size: 14px; color: var(--lab-ink); margin: 6px 0;">
                                <strong>Phone:</strong> <?php echo htmlspecialchars($row_members['phone']); ?>
                            </h4>
                            <h4 class="<?php echo $show_email; ?>" style="font-size: 14px; color: var(--lab-teal-dark); margin: 6px 0;">
                                <strong>E-mail:</strong> <a href="mailto:<?php echo htmlspecialchars($row_members['email']); ?>" style="color: var(--lab-teal-dark); text-decoration: underline;"><?php echo htmlspecialchars($row_members['email']); ?></a>
                            </h4>
                            <div class="members-description <?php echo $show_info; ?>" style="margin-top: 15px; border-top: 1px dashed var(--lab-line); padding-top: 15px;">
                                <p style="font-size: 14px; line-height: 1.6; color: var(--lab-muted); text-align: left;">
                                    <?php echo nl2br(htmlspecialchars($row_members['info'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="dialog-footer">
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('myModal_<?php echo $row_members['id']; ?>').close();">Close</button>
                        <a class="<?php echo $show_link; ?>" href="<?php echo htmlspecialchars($row_members['link']); ?>" target="_blank">
                            <button type="button" class="btn btn-primary">More Details</button>
                        </a>
                    </div>
                </dialog>
                <?php } ?>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>

    <section class="students-section" style="background-color: var(--lab-soft); padding: 60px 0;">
        <div class="container">
            <div class="title-div text-center">
                <h1><span>L</span>ab <span>S</span>tudents</h1>
                <div class="tittle-style"></div>
            </div>
            <div class="clearfix"></div>
            
            <div class="students-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 24px; margin-top: 30px;">
                <?php while ($row_students = mysqli_fetch_array($result_students)) { ?>
                <div class="student-item-wrapper">
                    <div class="student-item" style="height: 100%; display: flex; flex-direction: column;">
                        <img class="img-responsive" src="images/member/students/<?php echo $row_students['image']; ?>" alt="<?php echo $row_students['name']; ?>" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                        <div class="student-info" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="margin-top: 10px; font-size: 17px; font-weight: 800;"><?php echo htmlspecialchars($row_students['name']); ?></h3>
                                <h4 class="email" style="font-size: 13px; margin: 4px 0;"><a href="mailto:<?php echo htmlspecialchars($row_students['email']); ?>" style="color: var(--lab-teal-dark); word-break: break-all;"><?php echo htmlspecialchars($row_students['email']); ?></a></h4>
                            </div>
                            <h4 style="font-size: 13px; color: var(--lab-muted); margin-top: 8px;">Session: <?php echo htmlspecialchars($row_students['session']); ?></h4>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'notice.php';?>
    <?php include 'footer.php';?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Light-dismiss dialog polyfill / fallback
            document.querySelectorAll('dialog[closedby="any"]').forEach(dialog => {
                if (!('closedBy' in HTMLDialogElement.prototype)) {
                    dialog.addEventListener('click', (event) => {
                        if (event.target !== dialog) return;
                        const rect = dialog.getBoundingClientRect();
                        const isInside = (
                            rect.top <= event.clientY &&
                            event.clientY <= rect.top + rect.height &&
                            rect.left <= event.clientX &&
                            event.clientX <= rect.left + rect.width
                        );
                        if (!isInside) dialog.close();
                    });
                }
            });
        });
    </script>
</body>
</html>
