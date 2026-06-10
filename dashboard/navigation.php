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
               
$pub_panal ="";
$page_journal ="";
$page_conference="";
               
$gallary_panal ="";
$page_photos  ="";
$page_videos ="";

$notices = "";

if(isset($_GET['id'])){
	
	$myid = $_GET['id'];
	
	if($myid=="dashboard"){$dashboard="active";}
	elseif($myid=="my_profile"){$my_profile="active";}
	elseif($myid=="security"){}
	elseif($myid=="inbox"){}
	
	elseif($myid=="page_slider"){$home_panal="active open"; $page_slider="active";$page_elements="active open";}
	elseif($myid=="page_home_desptn"){$home_panal="active open"; $page_home_desptn="active";$page_elements="active open";}
	elseif($myid=="page_activities"){$home_panal="active open"; $page_activities="active";$page_elements="active open";}
	elseif($myid=="page_vission"){$home_panal="active open"; $page_vission="active";$page_elements="active open";}
	
	elseif($myid=="page_teachers"){$lab_members="active open"; $page_teachers="active";$page_elements="active open";}
	elseif($myid=="page_students"){$lab_members="active open"; $page_students="active";$page_elements="active open";}
	
	elseif($myid=="page_areas"){$page_areas="active";$page_elements="active open";}
	
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
	<div id="navbar" class="navbar navbar-default          ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<div class="pull-left">
				<a href="index.php?id=home" class="navbar-brand">
					<small>
						<span class="div_hide">
							<?php echo $site_row['sitename'];?></span>
					</small>
				</a>
			</div>

			<div class="pull-right" role="navigation">
				<ul class="ace-nav">

					<?php 

									if ($num_rows == 0) {
										$num_rows = '';
										$animation = '';
									}else {
										$animation = 'icon-animated-vertical';
									}

								?>
					<li class="green dropdown-modal">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<i class="ace-icon fa fa-envelope <?php echo $animation; ?>"></i>



							<span class="badge badge-success">
								<?php echo $num_rows; ?></span>
						</a>

						<ul class="dropdown-navbar dropdown-menu dropdown-close">
							<li class="dropdown-header">
								<i class="ace-icon fa fa-envelope-o"></i>
								<?php echo $num_rows; ?> Messages
							</li>

							<li class="dropdown-footer">
								<a href="inbox.php?id=inbox">
									See all messages
									<i class="ace-icon fa fa-arrow-right"></i>
								</a>
							</li>
						</ul>
					</li>

					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="assets/images/admin/<?php echo $userphoto;?>" alt="Admin's Photo" />
							<span class="div_hide">
								<small>Welcome,</small>
								<?php echo $_SESSION["sess_username"];?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

							<li>
								<a href="profile.php?id=my_profile">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="security.php?id=security">
									<i class="ace-icon fa fa-user"></i>
									Security
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="logout.php">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}

		</script>

		<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
			<script type="text/javascript">
				try {
					ace.settings.loadState('sidebar')
				} catch (e) {}

			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<span>Admin Panal</span>
				</div>
			</div><!-- /.sidebar-shortcuts -->

			<ul class="nav nav-list">
				<li class="<?php echo($dashboard); ?>">
					<a href="../dashboard?id=dashboard">
						<i class="menu-icon fa fa-tachometer"></i>
						<span class="menu-text"> Dashboard </span>
					</a>

					<b class="arrow"></b>
				</li>

				<li class="<?php echo($my_profile); ?>">
					<a href="profile.php">
						<i class="menu-icon fa fa-tachometer"></i>
						<span class="menu-text"> My Profile </span>
					</a>
				</li>

				<li class="<?php echo($page_elements); ?>">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-desktop"></i>
						<span class="menu-text">
							Page &amp; Elements
						</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>

					<b class="arrow"></b>

					<ul class="submenu">
						<li class="<?php echo($home_panal); ?>">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Home
								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								<li class="<?php echo($page_slider); ?>">
									<a href="page_slider.php?id=page_slider">
										<i class="menu-icon fa fa-caret-right"></i>
										Slider
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_home_desptn); ?>">
									<a href="page_home_desptn.php?id=page_home_desptn">
										<i class="menu-icon fa fa-caret-right"></i>
										Description
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_activities); ?>">
									<a href="page_activities.php?id=page_activities">
										<i class="menu-icon fa fa-caret-right"></i>
										Activities
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_vission); ?>">
									<a href="page_vission.php?id=page_vission">
										<i class="menu-icon fa fa-caret-right"></i>
										Vission
									</a>

									<b class="arrow"></b>
								</li>

							</ul>
						</li>

						<li class="<?php echo($lab_members); ?>">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Lab Members
								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">

								<li class="<?php echo($page_teachers); ?>">
									<a href="page_members.php?id=page_members">
										<i class="menu-icon fa fa-caret-right"></i>
										Members
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_students); ?>">
									<a href="page_students.php?id=page_students">
										<i class="menu-icon fa fa-caret-right"></i>
										Students
									</a>

									<b class="arrow"></b>
								</li>

							</ul>
						</li>

						<li class="<?php echo($page_areas); ?>">
							<a href="page_areas.php?id=page_areas">
								<i class="menu-icon fa fa-caret-right"></i>
								Areas
							</a>

							<b class="arrow"></b>
						</li>


						<li class="<?php echo($pub_panal); ?>">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Publications
								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								<li class="<?php echo($page_journal); ?>">
									<a href="page_journal.php?id=page_journal">
										<i class="menu-icon fa fa-caret-right"></i>
										Journal
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_conference); ?>">
									<a href="page_conference.php?id=page_conference">
										<i class="menu-icon fa fa-caret-right"></i>
										Conference
									</a>

									<b class="arrow"></b>
								</li>
							</ul>
						</li>

						<li class="<?php echo($gallary_panal); ?>">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Gallary
								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								<li class="<?php echo($page_photos); ?>">
									<a href="page_photos.php?id=page_photos">
										<i class="menu-icon fa fa-caret-right"></i>
										Photos
									</a>

									<b class="arrow"></b>
								</li>

								<li class="<?php echo($page_videos); ?>">
									<a href="page_videos.php?id=page_videos">
										<i class="menu-icon fa fa-caret-right"></i>
										Videos
									</a>

									<b class="arrow"></b>
								</li>
							</ul>
						</li>


						<li class="<?php echo($notices); ?>">
							<a href="page_notice.php?id=notices">
								<i class="menu-icon fa fa-caret-right"></i>
								Notices
							</a>
						</li>

					</ul>
				</li>

				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-tag"></i>
						<span class="menu-text"> More Pages </span>

						<b class="arrow fa fa-angle-down"></b>
					</a>

					<b class="arrow"></b>

					<ul class="submenu">

						<li class="">
							<a href="http://www.ru.ac.bd/" target="_blank">
								<i class="menu-icon fa fa-caret-right"></i>
								University of Rajshahi
							</a>

							<b class="arrow"></b>
						</li>

						<li class="">
							<a href="http://www.ru.ac.bd/eee/" target="_blank">
								<i class="menu-icon fa fa-caret-right"></i>
								Applied Physics & Electronic Engineering
							</a>

							<b class="arrow"></b>
						</li>
					</ul>
				</li>

			</ul><!-- /.nav-list -->

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<div class="ace-settings-container" id="ace-settings-container">
						<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
							<i class="ace-icon fa fa-cog bigger-130"></i>
						</div>

						<div class="ace-settings-box clearfix" id="ace-settings-box">
							<div class="pull-left width-50">
								<div class="ace-settings-item">
									<div class="pull-left">
										<select id="skin-colorpicker" class="hide">
											<option data-skin="no-skin" value="#438EB9">#438EB9</option>
											<option data-skin="skin-1" value="#222A2D">#222A2D</option>
											<option data-skin="skin-2" value="#C6487E">#C6487E</option>
											<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
										</select>
									</div>
									<span>&nbsp; Choose Skin</span>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
									<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
									<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
									<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
									<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
									<label class="lbl" for="ace-settings-add-container">
										Inside
										<b>.container</b>
									</label>
								</div>
							</div><!-- /.pull-left -->

							<div class="pull-left width-50">
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
									<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
									<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
									<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
								</div>
							</div><!-- /.pull-left -->
						</div><!-- /.ace-settings-box -->
					</div><!-- /.ace-settings-container -->



					<!-------------------------------------- page content start ------------------------------------------>
