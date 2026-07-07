<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Lab Instruments | Plasma Engineering Laboratory</title>
	<meta name="description" content="Explore the state-of-the-art laboratory equipment and instruments at the Plasma Engineering Laboratory.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.2">

	<script src="js/jquery-2.1.4.min.js"></script>

	<style>
		/* Custom Instruments Page Styles */
		.instruments-header-section {
			background: linear-gradient(135deg, rgba(123, 61, 115, 0.08), rgba(28, 167, 168, 0.08));
			padding: 80px 0 60px 0;
			text-align: center;
			border-bottom: 1px solid var(--lab-line);
		}

		.instruments-header-section h1 {
			font-family: 'Outfit', sans-serif;
			font-size: 40px;
			font-weight: 800;
			margin-bottom: 15px;
			color: var(--lab-ink);
		}

		.instruments-header-section p {
			font-size: 16px;
			color: var(--lab-muted);
			max-width: 600px;
			margin: 0 auto;
		}

		.filters-container {
			margin: 40px 0 30px 0;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			align-items: center;
			gap: 20px;
			padding: 15px 25px;
			background: var(--lab-card);
			border: 1px solid var(--lab-line);
			border-radius: 16px;
			box-shadow: 0 4px 20px rgba(23, 33, 47, 0.05);
			backdrop-filter: blur(10px);
		}

		.filter-tabs {
			display: flex;
			gap: 10px;
			flex-wrap: wrap;
		}

		.filter-tab {
			padding: 8px 18px;
			border-radius: 20px;
			font-size: 14px;
			font-weight: 600;
			color: var(--lab-muted);
			background: #f1f5f9;
			border: 1px solid transparent;
			cursor: pointer;
			transition: all 0.25s ease;
		}

		.filter-tab:hover {
			background: #e2e8f0;
			color: var(--lab-ink);
		}

		.filter-tab.active {
			background: var(--lab-teal);
			color: #fff;
			box-shadow: 0 4px 12px rgba(28, 167, 168, 0.25);
		}

		.search-box-wrapper {
			position: relative;
			min-width: 280px;
		}

		.search-box-wrapper i {
			position: absolute;
			left: 15px;
			top: 50%;
			transform: translateY(-50%);
			color: #94a3b8;
			font-size: 14px;
		}

		.search-input {
			width: 100%;
			padding: 10px 15px 10px 42px;
			border-radius: 25px;
			border: 1px solid var(--lab-line);
			background: #f8fafc;
			font-size: 14px;
			color: var(--lab-ink);
			outline: none;
			transition: all 0.25s ease;
		}

		.search-input:focus {
			border-color: var(--lab-teal);
			background: #fff;
			box-shadow: 0 0 0 3px rgba(28, 167, 168, 0.15);
		}

		.instruments-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
			gap: 30px;
			margin-bottom: 80px;
		}

		.instrument-card {
			background: var(--lab-card);
			border: 1px solid var(--lab-line);
			border-radius: 20px;
			overflow: hidden;
			box-shadow: 0 10px 30px rgba(23,33,47,0.06);
			display: flex;
			flex-direction: column;
			transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease;
		}

		.instrument-card:hover {
			transform: translateY(-6px);
			box-shadow: var(--lab-shadow);
		}

		.instrument-card-image-wrap {
			position: relative;
			width: 100%;
			padding-top: 62.5%; /* 16:10 Aspect Ratio */
			overflow: hidden;
			background: #e2e8f0;
		}

		.instrument-card-image-wrap img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: transform 0.5s ease;
		}

		.instrument-card:hover .instrument-card-image-wrap img {
			transform: scale(1.06);
		}

		.status-badge {
			position: absolute;
			top: 15px;
			right: 15px;
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 11px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.05em;
			color: #fff;
			z-index: 2;
			box-shadow: 0 4px 10px rgba(0,0,0,0.15);
		}

		.badge-active {
			background: linear-gradient(135deg, #10b981, #059669);
		}

		.badge-maintenance {
			background: linear-gradient(135deg, #f59e0b, #d97706);
		}

		.badge-retired {
			background: linear-gradient(135deg, #ef4444, #dc2626);
		}

		.instrument-card-body {
			padding: 24px;
			display: flex;
			flex-direction: column;
			flex-grow: 1;
		}

		.instrument-card-body h3 {
			font-size: 20px;
			font-weight: 800;
			color: var(--lab-ink);
			margin: 0 0 12px 0;
			line-height: 1.4;
		}

		.instrument-card-body p {
			font-size: 14px;
			color: var(--lab-muted);
			line-height: 1.6;
			margin-bottom: 20px;
			flex-grow: 1;
		}

		.view-details-btn {
			width: 100%;
			padding: 11px 20px;
			border-radius: 10px;
			font-size: 14px;
			font-weight: 600;
			border: 1px solid var(--lab-line);
			background: #f8fafc;
			color: var(--lab-teal-dark);
			cursor: pointer;
			text-align: center;
			transition: all 0.25s ease;
		}

		.view-details-btn:hover {
			background: var(--lab-teal);
			color: #fff;
			border-color: var(--lab-teal);
			box-shadow: 0 4px 12px rgba(28, 167, 168, 0.2);
		}

		/* Modal Status badge */
		.status-pill {
			display: inline-block;
			padding: 3px 10px;
			border-radius: 12px;
			font-size: 12px;
			font-weight: 700;
			text-transform: uppercase;
			color: #fff;
		}

		.status-active {
			background-color: #10b981;
		}

		.status-maintenance {
			background-color: #f59e0b;
		}

		.status-retired {
			background-color: #ef4444;
		}

		/* Dialog styles override for specifications formatting */
		.specs-list {
			margin: 0;
			padding-left: 20px;
		}
		.specs-list li {
			margin-bottom: 6px;
		}
	</style>
</head>

<body>

	<?php include('menu.php'); ?>

	<div class="clearfix"></div>

	<section class="instruments-header-section" style="margin-top:70px;">
		<div class="container">
			<h1><span>L</span>ab <span>I</span>nstruments</h1>
			<p>Explore the state-of-the-art laboratory equipment and instrumentation driving our research in plasma engineering and technology.</p>
		</div>
	</section>

	<section class="instruments-list-section">
		<div class="container">
			
			<div class="filters-container">
				<div class="filter-tabs">
					<button class="filter-tab active" onclick="filterStatus('all', this)">All Equipment</button>
					<button class="filter-tab" onclick="filterStatus('active', this)">Active</button>
					<button class="filter-tab" onclick="filterStatus('maintenance', this)">In Maintenance</button>
					<button class="filter-tab" onclick="filterStatus('retired', this)">Retired</button>
				</div>
				<div class="search-box-wrapper">
					<i class="fa fa-search"></i>
					<input type="text" class="search-input" id="searchBar" placeholder="Search instruments..." onkeyup="filterSearch()">
				</div>
			</div>

			<div class="instruments-grid" id="instrumentsGrid">
				<?php 
				$result_inst = mysqli_query($db, "SELECT * FROM instruments ORDER BY id DESC"); 
				if (mysqli_num_rows($result_inst) == 0):
				?>
				<div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: var(--lab-muted);">
					<i class="fa fa-cogs fa-4x" style="margin-bottom: 20px; color: #cbd5e1;"></i>
					<h3>No instruments loaded yet.</h3>
					<p>Please add instruments via the admin dashboard.</p>
				</div>
				<?php 
				else:
					while($row_inst = mysqli_fetch_array($result_inst)):
						$status_val = htmlspecialchars($row_inst['status']);
						$badge_class = 'badge-active';
						$status_label = 'Active';
						if ($status_val == 'maintenance') {
							$badge_class = 'badge-maintenance';
							$status_label = 'Maintenance';
						} elseif ($status_val == 'retired') {
							$badge_class = 'badge-retired';
							$status_label = 'Retired';
						}
				?>
				
				<div class="instrument-card" data-status="<?php echo $status_val; ?>" data-name="<?php echo htmlspecialchars(strtolower($row_inst['name'])); ?>">
					<div class="instrument-card-image-wrap">
						<span class="status-badge <?php echo $badge_class; ?>"><?php echo $status_label; ?></span>
						<img src="images/instruments/<?php echo htmlspecialchars($row_inst['image']); ?>" alt="<?php echo htmlspecialchars($row_inst['name']); ?>" onerror="this.src='images/activities/demo_image.png'">
					</div>
					<div class="instrument-card-body">
						<h3><?php echo htmlspecialchars($row_inst['name']); ?></h3>
						<p><?php echo htmlspecialchars($row_inst['description']); ?></p>
						<button class="view-details-btn" onclick="document.getElementById('instModal_<?php echo $row_inst['id']; ?>').showModal()">
							<i class="fa fa-info-circle"></i> Detailed Specifications
						</button>
					</div>
				</div>

				<!-- Native HTML5 Dialog Modal for details -->
				<dialog id="instModal_<?php echo $row_inst['id']; ?>" closedby="any" class="modern-dialog">
					<div class="dialog-header">
						<h3 class="dialog-title"><?php echo htmlspecialchars($row_inst['name']); ?></h3>
						<button class="dialog-close-btn" onclick="document.getElementById('instModal_<?php echo $row_inst['id']; ?>').close();" aria-label="Close dialog">&times;</button>
					</div>
					<div class="dialog-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
						<div class="modal-img" style="margin-bottom: 24px;">
							<img src="images/instruments/<?php echo htmlspecialchars($row_inst['image']); ?>" alt="<?php echo htmlspecialchars($row_inst['name']); ?>"
								 style="max-width: 100%; max-height: 280px; width: auto; height: auto; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); margin: 0 auto; display: block; object-fit: cover;" onerror="this.src='images/activities/demo_image.png'">
						</div>
						<div class="instrument-meta" style="text-align: left; max-width: 520px; margin: 0 auto;">
							<div style="margin-bottom: 15px;">
								<span style="font-weight: 700; color: var(--lab-ink); margin-right: 8px;">Status:</span>
								<span class="status-pill status-<?php echo $status_val; ?>"><?php echo ucfirst($status_label); ?></span>
							</div>
							
							<div style="font-size: 15px; line-height: 1.6; color: var(--lab-ink); margin-bottom: 25px;">
								<strong style="color: var(--lab-ink); display: block; margin-bottom: 6px;">Overview</strong>
								<span style="color: var(--lab-muted);"><?php echo nl2br(htmlspecialchars($row_inst['description'])); ?></span>
							</div>
							
							<?php if (!empty($row_inst['specifications'])): ?>
							<div class="specs-section" style="border-top: 1px dashed var(--lab-line); padding-top: 20px;">
								<strong style="color: var(--lab-ink); display: block; margin-bottom: 10px;"><i class="fa fa-sliders"></i> Technical Specifications</strong>
								<div style="font-size: 14px; line-height: 1.6; color: var(--lab-muted); background: #f8fafc; padding: 16px 20px; border-radius: 10px; border: 1px solid var(--lab-line);">
									<?php echo nl2br($row_inst['specifications']); ?>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="dialog-footer" style="padding: 15px 24px; border-top: 1px solid var(--lab-line); background: var(--lab-soft); display: flex; justify-content: flex-end;">
						<button type="button" class="btn btn-default" onclick="document.getElementById('instModal_<?php echo $row_inst['id']; ?>').close();" style="border-radius: 6px; padding: 8px 20px;">Close</button>
					</div>
				</dialog>

				<?php 
					endwhile;
				endif;
				?>
			</div>
		</div>
	</section>

	<?php include('notice.php'); ?>
	<?php include('footer.php'); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script>
		let activeFilter = 'all';

		function filterStatus(status, btnElement) {
			activeFilter = status;
			
			// Update active tab styles
			document.querySelectorAll('.filter-tab').forEach(tab => {
				tab.classList.remove('active');
			});
			btnElement.classList.add('active');

			applyFilters();
		}

		function filterSearch() {
			applyFilters();
		}

		function applyFilters() {
			const searchValue = document.getElementById('searchBar').value.toLowerCase().trim();
			const cards = document.querySelectorAll('.instrument-card');
			
			cards.forEach(card => {
				const cardStatus = card.getAttribute('data-status');
				const cardName = card.getAttribute('data-name');
				
				const matchesStatus = (activeFilter === 'all' || cardStatus === activeFilter);
				const matchesSearch = (searchValue === '' || cardName.includes(searchValue));

				if (matchesStatus && matchesSearch) {
					card.style.display = 'flex';
				} else {
					card.style.display = 'none';
				}
			});
		}

		// Light-dismiss dialog polyfill / click outside to close
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
	</script>
</body>

</html>
