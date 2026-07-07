<?php 

$username = $_SESSION["sess_username"];

$select = "SELECT * FROM admin_login WHERE username = '$username'";
$result = mysqli_query($db, $select);
$row = mysqli_fetch_array( $result ); 
$userphoto = $row['image'];  


$message_num = mysqli_query($db, "SELECT * FROM message WHERE flag !='1'");
$num_rows = mysqli_num_rows($message_num);



$my_iframe="home.php";
$inbox="";
$dashboard="";
$my_profile="";
$lab_members="";

$page_elements="";

$home_panal ="";
$page_slider   ="";
$page_home_desptn  ="";
$page_activities = "";
$page_vission  ="";
$page_events  ="";
$page_news  ="";
             
$about_panal="";
$about_desptn="";
$members="";
$page_teachers ="";
$page_students  ="";
              
$research_panal ="";
$page_areas ="";
$page_instruments = "";
               
$pub_panal ="";
$page_journal ="";
$page_conference="";
               
$gallary_panal ="";
$page_photos  ="";
$page_videos ="";

$notices = "";
$security_active = "";
$inbox_active = "";

if(isset($_GET['id'])){
	
	$myid = $_GET['id'];
	
	if($myid=="dashboard"){$dashboard="active";}
	elseif($myid=="my_profile"){$my_profile="active";}
	elseif($myid=="security"){$security_active="active";}
	elseif($myid=="inbox"){$inbox_active="active";}
	
	elseif($myid=="page_slider"){$home_panal="active open"; $page_slider="active";$page_elements="active open";}
	elseif($myid=="page_home_desptn"){$home_panal="active open"; $page_home_desptn="active";$page_elements="active open";}
	elseif($myid=="page_activities"){$home_panal="active open"; $page_activities="active";$page_elements="active open";}
	elseif($myid=="page_vission"){$home_panal="active open"; $page_vission="active";$page_elements="active open";}
	
	elseif($myid=="page_teachers" || $myid=="page_members"){$lab_members="active open"; $page_teachers="active";$page_elements="active open";}
	elseif($myid=="page_students"){$lab_members="active open"; $page_students="active";$page_elements="active open";}
	
	elseif($myid=="page_areas"){$page_areas="active";$page_elements="active open";}
	elseif($myid=="page_instruments"){$page_instruments="active";$page_elements="active open";}
	
	elseif($myid=="page_journal"){$pub_panal="active open"; $page_journal="active";$page_elements="active open";}
	elseif($myid=="page_conference"){$pub_panal="active open"; $page_conference="active";$page_elements="active open";}
	
	elseif($myid=="page_photos"){$gallary_panal="active open"; $page_photos="active";$page_elements="active open";}
	elseif($myid=="page_videos"){$gallary_panal="active open"; $page_videos="active";$page_elements="active open";}

	elseif($myid=="notices"){$notices="active";$page_elements="active open";}

	elseif($myid=="messages"){}
	else{}
	
}


?>



<body class="no-skin">
<div class="glow-blob blob-1"></div>
<div class="glow-blob blob-2"></div>

<div class="modern-layout-wrapper">
    <!-- Modern Sidebar -->
    <aside class="modern-sidebar" id="modernSidebar">
        <div class="modern-sidebar-logo">
            <a href="index.php?id=dashboard">Plasma Engineering Laboratory</a>
            <button type="button" class="modern-sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close sidebar">&times;</button>
        </div>
        <ul class="modern-sidebar-menu">
            <!-- Core Section -->
            <li class="sidebar-section-header" style="padding: 10px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Core</li>
            <li class="modern-sidebar-item <?php echo $dashboard; ?>">
                <a class="modern-sidebar-link" href="index.php?id=dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $my_profile; ?>">
                <a class="modern-sidebar-link" href="profile.php?id=my_profile">
                    <i class="fa fa-user"></i> <span>My Profile</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $inbox_active; ?>">
                <a class="modern-sidebar-link" href="inbox.php?id=inbox">
                    <i class="fa fa-envelope"></i> <span>Inbox</span>
                    <?php if ($num_rows > 0) { ?>
                        <span class="badge badge-danger" style="margin-left: auto; background: var(--danger-gradient); border-radius: 20px; font-size: 11px; padding: 2px 6px;"><?php echo $num_rows; ?></span>
                    <?php } ?>
                </a>
            </li>

            <!-- Website Content Section -->
            <li class="sidebar-section-header" style="padding: 15px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Content</li>
            <li class="modern-sidebar-item <?php echo $page_slider; ?>">
                <a class="modern-sidebar-link" href="page_slider.php?id=page_slider">
                    <i class="fa fa-sliders"></i> <span>Slider</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_home_desptn; ?>">
                <a class="modern-sidebar-link" href="page_home_desptn.php?id=page_home_desptn">
                    <i class="fa fa-file-text-o"></i> <span>Description</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_activities; ?>">
                <a class="modern-sidebar-link" href="page_activities.php?id=page_activities">
                    <i class="fa fa-tasks"></i> <span>Activities</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_vission; ?>">
                <a class="modern-sidebar-link" href="page_vission.php?id=page_vission">
                    <i class="fa fa-eye"></i> <span>Vision</span>
                </a>
            </li>

            <!-- Members Section -->
            <li class="sidebar-section-header" style="padding: 15px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Members</li>
            <li class="modern-sidebar-item <?php echo $page_teachers; ?>">
                <a class="modern-sidebar-link" href="page_members.php?id=page_members">
                    <i class="fa fa-users"></i> <span>Faculty Members</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_students; ?>">
                <a class="modern-sidebar-link" href="page_students.php?id=page_students">
                    <i class="fa fa-graduation-cap"></i> <span>Students</span>
                </a>
            </li>

            <!-- Research & Publications Section -->
            <li class="sidebar-section-header" style="padding: 15px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Research</li>
            <li class="modern-sidebar-item <?php echo $page_areas; ?>">
                <a class="modern-sidebar-link" href="page_areas.php?id=page_areas">
                    <i class="fa fa-flask"></i> <span>Research Areas</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_instruments; ?>">
                <a class="modern-sidebar-link" href="page_instruments.php?id=page_instruments">
                    <i class="fa fa-cogs"></i> <span>Lab Instruments</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_journal; ?>">
                <a class="modern-sidebar-link" href="page_journal.php?id=page_journal">
                    <i class="fa fa-book"></i> <span>Journal Pubs</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_conference; ?>">
                <a class="modern-sidebar-link" href="page_conference.php?id=page_conference">
                    <i class="fa fa-trophy"></i> <span>Conference Pubs</span>
                </a>
            </li>

            <!-- Media Section -->
            <li class="sidebar-section-header" style="padding: 15px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Media & Alerts</li>
            <li class="modern-sidebar-item <?php echo $page_photos; ?>">
                <a class="modern-sidebar-link" href="page_photos.php?id=page_photos">
                    <i class="fa fa-camera"></i> <span>Photos Gallery</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $page_videos; ?>">
                <a class="modern-sidebar-link" href="page_videos.php?id=page_videos">
                    <i class="fa fa-video-camera"></i> <span>Videos Gallery</span>
                </a>
            </li>
            <li class="modern-sidebar-item <?php echo $notices; ?>">
                <a class="modern-sidebar-link" href="page_notice.php?id=notices">
                    <i class="fa fa-bullhorn"></i> <span>Notices</span>
                </a>
            </li>

            <!-- System Section -->
            <li class="sidebar-section-header" style="padding: 15px 16px 5px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">System</li>
            <li class="modern-sidebar-item <?php echo $security_active; ?>">
                <a class="modern-sidebar-link" href="security.php?id=security">
                    <i class="fa fa-lock"></i> <span>Security</span>
                </a>
            </li>
            <li class="modern-sidebar-item">
                <a class="modern-sidebar-link" href="logout.php" style="color: #f87171;">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Outer Wrapper -->
    <div style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
        <!-- Modern Top Header -->
        <header class="modern-header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="modern-menu-btn" id="menuToggleBtn">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="modern-header-title">
                    <?php 
                    // Dynamic Header Title based on Page
                    if (isset($_GET['id'])) {
                        $myid = $_GET['id'];
                        if($myid=="dashboard") echo "Dashboard Overview";
                        elseif($myid=="my_profile") echo "Admin Profile";
                        elseif($myid=="security") echo "Security Settings";
                        elseif($myid=="inbox") echo "Message Inbox";
                        elseif($myid=="page_slider") echo "Home Slider Editor";
                        elseif($myid=="page_home_desptn") echo "Home Description";
                        elseif($myid=="page_activities") echo "Research Activities";
                        elseif($myid=="page_vission") echo "Vision & Mission";
                        elseif($myid=="page_members") echo "Faculty Members Editor";
                        elseif($myid=="page_students") echo "Students Directory";
                        elseif($myid=="page_areas") echo "Research Areas";
                        elseif($myid=="page_instruments") echo "Lab Instruments";
                        elseif($myid=="page_journal") echo "Journal Publications";
                        elseif($myid=="page_conference") echo "Conference Publications";
                        elseif($myid=="page_photos") echo "Photo Gallery";
                        elseif($myid=="page_videos") echo "Video Gallery";
                        elseif($myid=="notices") echo "Announcements & Notices";
                        else echo "Admin Panel";
                    } else {
                        echo "Admin Panel";
                    }
                    ?>
                </div>
            </div>
            
            <div class="modern-header-actions">
                <a class="modern-nav-mail" href="inbox.php?id=inbox" title="Inbox">
                    <i class="fa fa-envelope-o"></i>
                    <?php if ($num_rows > 0) { ?>
                        <span class="badge"><?php echo $num_rows; ?></span>
                    <?php } ?>
                </a>
                
                <div class="modern-nav-user" id="userMenuDropdownBtn">
                    <img src="assets/images/admin/<?php echo $userphoto;?>" alt="Admin Avatar" />
                    <span><?php echo $_SESSION["sess_username"];?></span>
                    <i class="fa fa-caret-down"></i>
                    
                    <ul class="modern-dropdown-menu" id="userDropdownMenu">
                        <li>
                            <a href="profile.php?id=my_profile">
                                <i class="fa fa-user"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="security.php?id=security">
                                <i class="fa fa-shield"></i> Security
                            </a>
                        </li>
                        <li class="modern-dropdown-divider"></li>
                        <li>
                            <a href="logout.php" style="color: #f87171;">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Modern Main Content Wrapper -->
        <main class="modern-main-content">
					<!-------------------------------------- page content start ------------------------------------------>
