<?php 
include('db_connect.php'); 

// Fetch counts
$res_j_cnt = mysqli_query($db, "SELECT COUNT(*) as cnt FROM journal");
$j_cnt = ($res_j_cnt && $r = mysqli_fetch_array($res_j_cnt)) ? $r['cnt'] : 0;

$res_c_cnt = mysqli_query($db, "SELECT COUNT(*) as cnt FROM conference");
$c_cnt = ($res_c_cnt && $r = mysqli_fetch_array($res_c_cnt)) ? $r['cnt'] : 0;

$res_r_cnt = mysqli_query($db, "SELECT COUNT(*) as cnt FROM reports");
$r_cnt = ($res_r_cnt && $r = mysqli_fetch_array($res_r_cnt)) ? $r['cnt'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Publications | Plasma Engineering Laboratory</title>
	<meta name="description" content="View journal and conference publications from the Plasma Engineering Laboratory, University of Rajshahi.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.3">
	<script src="js/jquery-2.1.4.min.js"></script>

	<style>
		.pub-tabs > li > a {
			border-radius: 999px;
			color: var(--lab-ink);
			font-weight: 700;
			font-size: 15px;
			margin-right: 8px;
			border: 1px solid var(--lab-line);
			background: #fff;
			padding: 10px 22px;
			transition: all 0.25s ease;
		}
		.pub-tabs > li.active > a,
		.pub-tabs > li.active > a:hover,
		.pub-tabs > li.active > a:focus {
			background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-teal)) !important;
			color: #fff !important;
			border-color: var(--lab-teal-dark) !important;
			box-shadow: 0 4px 14px rgba(8,125,130,0.3);
		}
		.pub-tabs > li > a:hover {
			background: rgba(28,167,168,0.08);
			color: var(--lab-teal-dark);
		}
		.tab-counter {
			display: inline-block;
			padding: 2px 8px;
			font-size: 11px;
			border-radius: 12px;
			background: rgba(0,0,0,0.08);
			margin-left: 6px;
		}
		.pub-tabs > li.active .tab-counter {
			background: rgba(255,255,255,0.25);
			color: #fff;
		}
		.publication-table-wrap {
			background: #fff;
			border: 1px solid var(--lab-line);
			border-radius: 16px;
			box-shadow: var(--lab-shadow);
			overflow: hidden;
			margin-top: 15px;
		}
		.publication-table {
			margin-bottom: 0;
		}
		.publication-table > tbody > tr > td {
			padding: 18px 22px;
			vertical-align: top;
			border-top: 1px solid var(--lab-line);
		}
		.publication-table > tbody > tr:first-child > td {
			border-top: 0;
		}
		.publication-table > tbody > tr:hover {
			background-color: rgba(28,167,168,0.03);
		}
		.pub-idx {
			width: 44px;
			font-size: 16px;
			font-weight: 800;
			color: var(--lab-teal-dark);
			text-align: right;
			padding-right: 14px !important;
			line-height: 1.5;
		}
		.pub-content {
			font-size: 14px;
			line-height: 1.7;
			color: var(--lab-ink);
		}
		.pub-content b {
			color: var(--lab-ink);
			display: block;
			font-size: 15px;
			margin: 4px 0;
			line-height: 1.5;
		}
		.pub-content .label-success {
			background-color: #10b981;
			font-size: 11px;
			font-weight: 700;
			padding: 4px 10px;
			border-radius: 12px;
		}
		.pub-content .btn-primary.btn-xs {
			background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-teal));
			border: none;
			border-radius: 6px;
			padding: 4px 12px;
			font-weight: 700;
			font-size: 12px;
			box-shadow: 0 2px 8px rgba(8,125,130,0.2);
			transition: all 0.2s ease;
		}
		.pub-content .btn-primary.btn-xs:hover {
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(8,125,130,0.35);
			color: #fff;
		}
		.search-box {
			background: #fff;
			border: 1px solid var(--lab-line);
			border-radius: 12px;
			padding: 12px 18px;
			font-size: 14px;
			color: var(--lab-ink);
			box-shadow: 0 2px 10px rgba(23,33,47,0.04);
			transition: all 0.2s ease;
		}
		.search-box:focus {
			border-color: var(--lab-teal);
			outline: none;
			box-shadow: 0 0 0 3px rgba(28,167,168,0.15);
		}
		@media (max-width: 767px) {
			.pub-tabs > li { width: 100%; margin-bottom: 6px; }
			.pub-tabs > li > a { margin-right: 0; text-align: center; }
			.publication-table > tbody > tr > td { padding: 14px 14px; }
			.pub-idx { width: 30px; font-size: 14px; padding-right: 8px !important; }
		}
	</style>
</head>

<body>

	<?php include('menu.php'); ?>

	<section class="publications" style="padding-top: 100px; padding-bottom: 80px;">
		<div class="container">
			<div class="title-div text-center" style="margin-bottom: 30px;">
				<h1><span>P</span>ublications</h1>
				<div class="tittle-style"></div>
			</div>

			<!-- RU Profile Action Banner (Modeled exactly after Sir's RU page) -->
			<div class="publication-action-bar" style="background: linear-gradient(135deg, rgba(28,167,168,0.06), rgba(123,61,115,0.06)); border: 1px solid var(--lab-line); border-radius: 16px; padding: 22px 26px; margin-bottom: 28px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
				<div>
					<h4 style="margin: 0 0 4px; font-weight: 800; color: var(--lab-ink); font-size: 17px;">
						<i class="fa fa-university" style="color: var(--lab-teal); margin-right: 8px;"></i>University of Rajshahi Faculty Publications
					</h4>
					<p style="margin: 0; color: var(--lab-muted); font-size: 13px;">
						Professor Dr. M. Mamunur Rashid Talukder • Department of Electrical & Electronic Engineering (EEE)
					</p>
				</div>
				<div style="display: flex; flex-wrap: wrap; gap: 10px;">
					<a class="btn btn-primary" href="http://rurfid.ru.ac.bd/ru_profile/public/profiles/128/download_publication_file" target="_blank" rel="noopener" role="button" style="border-radius: 8px; font-weight: 700; font-size: 13px; padding: 9px 18px; background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-teal)); border: none; box-shadow: 0 4px 12px rgba(8,125,130,0.25);">
						<i class="fa fa-download" style="margin-right: 6px;"></i> Download Publication List
					</a>
					<a class="btn btn-default" href="http://rurfid.ru.ac.bd/ru_profile/public/teacher/25400481/profile" target="_blank" rel="noopener" role="button" style="border-radius: 8px; font-weight: 700; font-size: 13px; padding: 9px 18px; border: 1px solid var(--lab-line); color: var(--lab-ink); background: #fff;">
						<i class="fa fa-id-card-o" style="margin-right: 6px; color: var(--lab-plum);"></i> Sir's RU RFID Profile
					</a>
					<a class="btn btn-default" href="https://scholar.google.com/citations?hl=en&user=0RI4jGUAAAAJ&view_op=list_works&sortby=pubdate" target="_blank" rel="noopener" role="button" style="border-radius: 8px; font-weight: 700; font-size: 13px; padding: 9px 18px; border: 1px solid var(--lab-line); color: #1a73e8; background: #fff;">
						<i class="fa fa-graduation-cap" style="margin-right: 6px;"></i> Google Scholar
					</a>
				</div>
			</div>

			<!-- Search and Tabs Header -->
			<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px;">
				<!-- Tab Navigation -->
				<ul class="nav nav-tabs pub-tabs" id="pubTabs" style="border-bottom: 0; margin-bottom: 0;">
					<li class="active">
						<a href="#tab-journal" data-toggle="tab" id="tab-journal-link">
							<i class="fa fa-book" style="margin-right: 6px;"></i>Journal <span class="tab-counter"><?php echo $j_cnt; ?></span>
						</a>
					</li>
					<li>
						<a href="#tab-conference" data-toggle="tab" id="tab-conf-link">
							<i class="fa fa-microphone" style="margin-right: 6px;"></i>Conference <span class="tab-counter"><?php echo $c_cnt; ?></span>
						</a>
					</li>
					<li>
						<a href="#tab-reports" data-toggle="tab" id="tab-reports-link">
							<i class="fa fa-file-text-o" style="margin-right: 6px;"></i>Report / Preprints <span class="tab-counter"><?php echo $r_cnt; ?></span>
						</a>
					</li>
				</ul>

				<!-- Real-time Filter Search -->
				<div style="flex: 1; max-width: 320px; min-width: 200px;">
					<input type="text" id="pubSearch" class="search-box form-control" placeholder="🔍 Search publications...">
				</div>
			</div>

			<div class="tab-content">

				<!-- 1. Journal Tab -->
				<div id="tab-journal" class="tab-pane fade in active">
					<div class="publication-table-wrap">
						<table class="table table-striped table-hover publication-table" id="journalTable">
							<tbody>
								<?php
								$i = 1;
								$result_jur = mysqli_query($db, "SELECT * FROM journal ORDER BY id ASC");
								if ($result_jur && mysqli_num_rows($result_jur) > 0) {
									while ($row_jur = mysqli_fetch_array($result_jur)) {
								?>
								<tr class="pub-row">
									<td class="pub-idx"><?php echo $i; ?>.</td>
									<td class="pub-content"><?php echo $row_jur['journal']; ?></td>
								</tr>
								<?php 
										$i++; 
									} 
								} else {
								?>
								<tr>
									<td colspan="2" class="text-center" style="padding: 40px; color: var(--lab-muted);">No journal publications listed yet.</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- 2. Conference Tab -->
				<div id="tab-conference" class="tab-pane fade">
					<div class="publication-table-wrap">
						<table class="table table-striped table-hover publication-table" id="confTable">
							<tbody>
								<?php
								$j = 1;
								$result_con = mysqli_query($db, "SELECT * FROM conference ORDER BY id ASC");
								if ($result_con && mysqli_num_rows($result_con) > 0) {
									while ($row_con = mysqli_fetch_array($result_con)) {
								?>
								<tr class="pub-row">
									<td class="pub-idx"><?php echo $j; ?>.</td>
									<td class="pub-content"><?php echo $row_con['conference']; ?></td>
								</tr>
								<?php 
										$j++; 
									} 
								} else {
								?>
								<tr>
									<td colspan="2" class="text-center" style="padding: 40px; color: var(--lab-muted);">No conference publications listed yet.</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- 3. Reports Tab -->
				<div id="tab-reports" class="tab-pane fade">
					<div class="publication-table-wrap">
						<table class="table table-striped table-hover publication-table" id="reportTable">
							<tbody>
								<?php
								$k = 1;
								$result_rep = mysqli_query($db, "SELECT * FROM reports ORDER BY id ASC");
								if ($result_rep && mysqli_num_rows($result_rep) > 0) {
									while ($row_rep = mysqli_fetch_array($result_rep)) {
								?>
								<tr class="pub-row">
									<td class="pub-idx"><?php echo $k; ?>.</td>
									<td class="pub-content"><?php echo $row_rep['report']; ?></td>
								</tr>
								<?php 
										$k++; 
									} 
								} else {
								?>
								<tr>
									<td colspan="2" class="text-center" style="padding: 40px; color: var(--lab-muted);">No report publications listed yet.</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php include('notice.php'); ?>
	<?php include('footer.php'); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script>
		// Live Search Filter for Publications
		$(document).ready(function() {
			$('#pubSearch').on('keyup', function() {
				var value = $(this).val().toLowerCase();
				$('.tab-pane.active .pub-row').filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
				});
			});

			// Re-apply filter when tab changes
			$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
				var value = $('#pubSearch').val().toLowerCase();
				if (value) {
					$('.tab-pane.active .pub-row').filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
					});
				} else {
					$('.tab-pane.active .pub-row').show();
				}
			});
		});
	</script>
</body>

</html>
