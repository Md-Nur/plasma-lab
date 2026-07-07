<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Products & Services | Plasma Engineering Laboratory</title>
	<meta name="description" content="Explore the scientific products and analytical services offered by the Plasma Engineering Laboratory at Rajshahi University.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css?v=1.2">

	<script src="js/jquery-2.1.4.min.js"></script>

	<style>
		/* ─── Page Header ──────────────────────────────────── */
		.ps-hero {
			background: linear-gradient(135deg, rgba(123, 61, 115, 0.09) 0%, rgba(28, 167, 168, 0.09) 100%);
			padding: 90px 0 70px;
			text-align: center;
			border-bottom: 1px solid var(--lab-line);
			position: relative;
			overflow: hidden;
		}
		.ps-hero::before {
			content: '';
			position: absolute;
			top: -60px; right: -60px;
			width: 320px; height: 320px;
			border-radius: 50%;
			background: radial-gradient(circle, rgba(28,167,168,0.10), transparent 70%);
			pointer-events: none;
		}
		.ps-hero::after {
			content: '';
			position: absolute;
			bottom: -80px; left: -60px;
			width: 280px; height: 280px;
			border-radius: 50%;
			background: radial-gradient(circle, rgba(123,61,115,0.10), transparent 70%);
			pointer-events: none;
		}
		.ps-hero-badge {
			display: inline-block;
			background: linear-gradient(90deg, var(--lab-teal), var(--lab-plum));
			color: #fff;
			font-size: 12px;
			font-weight: 700;
			letter-spacing: 0.12em;
			text-transform: uppercase;
			padding: 5px 18px;
			border-radius: 30px;
			margin-bottom: 18px;
		}
		.ps-hero h1 {
			font-family: 'Outfit', sans-serif;
			font-size: 46px;
			font-weight: 800;
			color: var(--lab-ink);
			line-height: 1.15;
			margin-bottom: 16px;
		}
		.ps-hero h1 span {
			background: linear-gradient(90deg, var(--lab-teal), var(--lab-plum));
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}
		.ps-hero p {
			font-size: 17px;
			color: var(--lab-muted);
			max-width: 620px;
			margin: 0 auto;
			line-height: 1.7;
		}

		/* ─── Section Labels ───────────────────────────────── */
		.section-label {
			display: flex;
			align-items: center;
			gap: 14px;
			margin-bottom: 36px;
		}
		.section-label-icon {
			width: 46px; height: 46px;
			border-radius: 14px;
			display: flex; align-items: center; justify-content: center;
			font-size: 20px;
			flex-shrink: 0;
		}
		.section-label-icon.teal  { background: rgba(28,167,168,0.12); color: var(--lab-teal-dark); }
		.section-label-icon.plum  { background: rgba(123,61,115,0.12); color: var(--lab-plum); }
		.section-label h2 {
			font-family: 'Outfit', sans-serif;
			font-size: 28px;
			font-weight: 800;
			margin: 0 0 4px;
			color: var(--lab-ink);
		}
		.section-label p {
			font-size: 14px;
			color: var(--lab-muted);
			margin: 0;
		}
		.section-divider {
			height: 3px;
			width: 60px;
			border-radius: 4px;
			background: linear-gradient(90deg, var(--lab-teal), var(--lab-coral));
			margin-bottom: 10px;
		}

		/* ─── Services Grid ────────────────────────────────── */
		.services-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
			gap: 28px;
			margin-bottom: 20px;
		}
		.service-card {
			background: var(--lab-card);
			border: 1px solid var(--lab-line);
			border-radius: 20px;
			padding: 32px 28px 26px;
			display: flex;
			flex-direction: column;
			box-shadow: 0 8px 28px rgba(23,33,47,0.06);
			transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
			position: relative;
			overflow: hidden;
		}
		.service-card::before {
			content: '';
			position: absolute;
			top: 0; left: 0; right: 0;
			height: 4px;
			background: linear-gradient(90deg, var(--lab-teal), var(--lab-coral));
			opacity: 0;
			transition: opacity 0.3s ease;
		}
		.service-card:hover {
			transform: translateY(-6px);
			box-shadow: var(--lab-shadow);
			border-color: rgba(28,167,168,0.25);
		}
		.service-card:hover::before { opacity: 1; }

		.service-card-icon {
			width: 54px; height: 54px;
			border-radius: 16px;
			background: rgba(28,167,168,0.10);
			color: var(--lab-teal-dark);
			font-size: 22px;
			display: flex; align-items: center; justify-content: center;
			margin-bottom: 20px;
		}
		.service-card h3 {
			font-family: 'Outfit', sans-serif;
			font-size: 18px;
			font-weight: 700;
			color: var(--lab-ink);
			margin: 0 0 10px;
		}
		.service-card p {
			font-size: 14px;
			color: var(--lab-muted);
			line-height: 1.7;
			margin: 0 0 20px;
			flex: 1;
		}
		.service-tags {
			display: flex;
			flex-wrap: wrap;
			gap: 6px;
			margin-bottom: 20px;
		}
		.service-tag {
			background: rgba(28,167,168,0.08);
			color: var(--lab-teal-dark);
			font-size: 11px;
			font-weight: 600;
			padding: 3px 10px;
			border-radius: 20px;
			border: 1px solid rgba(28,167,168,0.18);
		}
		.btn-book-service {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-teal));
			color: #fff;
			border: none;
			border-radius: 10px;
			padding: 10px 20px;
			font-size: 14px;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.25s ease;
			text-decoration: none;
			width: 100%;
			justify-content: center;
		}
		.btn-book-service:hover {
			transform: translateY(-1px);
			box-shadow: 0 6px 20px rgba(8,125,130,0.35);
			color: #fff;
			text-decoration: none;
		}

		/* ─── Products Grid ────────────────────────────────── */
		.products-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
			gap: 28px;
			margin-bottom: 20px;
		}
		.product-card {
			background: var(--lab-card);
			border: 1px solid var(--lab-line);
			border-radius: 20px;
			overflow: hidden;
			box-shadow: 0 8px 28px rgba(23,33,47,0.06);
			display: flex;
			flex-direction: column;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}
		.product-card:hover {
			transform: translateY(-6px);
			box-shadow: var(--lab-shadow);
		}
		.product-card-banner {
			height: 160px;
			display: flex; align-items: center; justify-content: center;
			font-size: 56px;
			position: relative;
			overflow: hidden;
		}
		.product-card-banner.plum-bg {
			background: linear-gradient(135deg, rgba(123,61,115,0.12), rgba(123,61,115,0.06));
		}
		.product-card-banner.teal-bg {
			background: linear-gradient(135deg, rgba(28,167,168,0.12), rgba(28,167,168,0.06));
		}
		.product-card-banner.coral-bg {
			background: linear-gradient(135deg, rgba(232,93,117,0.12), rgba(232,93,117,0.06));
		}
		.product-card-body {
			padding: 26px 24px 22px;
			flex: 1;
			display: flex;
			flex-direction: column;
		}
		.product-card-badge {
			display: inline-block;
			font-size: 11px;
			font-weight: 700;
			letter-spacing: 0.08em;
			text-transform: uppercase;
			padding: 3px 10px;
			border-radius: 20px;
			margin-bottom: 12px;
		}
		.product-card-badge.plum-badge { background: rgba(123,61,115,0.10); color: var(--lab-plum); }
		.product-card-badge.teal-badge { background: rgba(28,167,168,0.10); color: var(--lab-teal-dark); }
		.product-card-badge.coral-badge { background: rgba(232,93,117,0.10); color: #c04060; }

		.product-card h3 {
			font-family: 'Outfit', sans-serif;
			font-size: 18px;
			font-weight: 700;
			color: var(--lab-ink);
			margin: 0 0 10px;
		}
		.product-card p {
			font-size: 14px;
			color: var(--lab-muted);
			line-height: 1.7;
			flex: 1;
			margin: 0 0 18px;
		}
		.product-specs {
			list-style: none;
			padding: 0;
			margin: 0 0 20px;
		}
		.product-specs li {
			display: flex;
			align-items: flex-start;
			gap: 8px;
			font-size: 13px;
			color: var(--lab-muted);
			margin-bottom: 6px;
		}
		.product-specs li i {
			color: var(--lab-teal);
			margin-top: 2px;
			flex-shrink: 0;
		}
		.btn-inquire-product {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: transparent;
			border: 2px solid var(--lab-plum);
			color: var(--lab-plum);
			border-radius: 10px;
			padding: 10px 20px;
			font-size: 14px;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.25s ease;
			width: 100%;
			justify-content: center;
		}
		.btn-inquire-product:hover {
			background: var(--lab-plum);
			color: #fff;
			transform: translateY(-1px);
			box-shadow: 0 6px 20px rgba(123,61,115,0.30);
		}

		/* ─── CTA Strip ────────────────────────────────────── */
		.cta-strip {
			background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-plum));
			border-radius: 24px;
			padding: 56px 48px;
			text-align: center;
			color: #fff;
			margin: 64px 0;
			position: relative;
			overflow: hidden;
		}
		.cta-strip::before {
			content: '';
			position: absolute; inset: 0;
			background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
		}
		.cta-strip h2 {
			font-family: 'Outfit', sans-serif;
			font-size: 32px;
			font-weight: 800;
			margin: 0 0 12px;
			color: #fff;
		}
		.cta-strip p {
			font-size: 16px;
			color: rgba(255,255,255,0.82);
			margin: 0 0 32px;
			max-width: 540px;
			margin-left: auto;
			margin-right: auto;
			line-height: 1.7;
		}
		.cta-strip-actions {
			display: flex;
			gap: 14px;
			justify-content: center;
			flex-wrap: wrap;
		}
		.btn-cta-white {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: #fff;
			color: var(--lab-teal-dark);
			border: none;
			border-radius: 12px;
			padding: 13px 28px;
			font-size: 15px;
			font-weight: 800;
			cursor: pointer;
			transition: all 0.25s ease;
			text-decoration: none;
		}
		.btn-cta-white:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 30px rgba(0,0,0,0.25);
			color: var(--lab-teal-dark);
			text-decoration: none;
		}
		.btn-cta-outline {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: transparent;
			color: #fff;
			border: 2px solid rgba(255,255,255,0.6);
			border-radius: 12px;
			padding: 13px 28px;
			font-size: 15px;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.25s ease;
			text-decoration: none;
		}
		.btn-cta-outline:hover {
			background: rgba(255,255,255,0.15);
			border-color: #fff;
			color: #fff;
			text-decoration: none;
			transform: translateY(-2px);
		}

		/* ─── Why Choose Us ────────────────────────────────── */
		.why-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
			gap: 22px;
			margin: 48px 0;
		}
		.why-item {
			text-align: center;
			padding: 28px 18px;
			background: var(--lab-card);
			border: 1px solid var(--lab-line);
			border-radius: 16px;
			transition: transform 0.25s ease, box-shadow 0.25s ease;
		}
		.why-item:hover {
			transform: translateY(-4px);
			box-shadow: 0 12px 30px rgba(23,33,47,0.10);
		}
		.why-item-icon {
			font-size: 30px;
			margin-bottom: 14px;
			color: var(--lab-teal-dark);
		}
		.why-item h4 {
			font-family: 'Outfit', sans-serif;
			font-size: 15px;
			font-weight: 700;
			color: var(--lab-ink);
			margin: 0 0 8px;
		}
		.why-item p {
			font-size: 13px;
			color: var(--lab-muted);
			margin: 0;
			line-height: 1.6;
		}

		@media (max-width: 600px) {
			.ps-hero h1 { font-size: 30px; }
			.cta-strip { padding: 36px 22px; }
			.cta-strip h2 { font-size: 22px; }
			.services-grid, .products-grid { grid-template-columns: 1fr; }
		}
	</style>
</head>

<body>

<?php include('menu.php'); ?>

<!-- ─── Hero Header ──────────────────────────────── -->
<div class="ps-hero">
	<div class="container" style="position:relative; z-index:1;">
		<span class="ps-hero-badge"><i class="fa fa-flask" style="margin-right:6px;"></i> Plasma Engineering Laboratory</span>
		<h1>Our <span>Products</span> &<br>Scientific <span>Services</span></h1>
		<p>Leveraging cutting-edge plasma physics and materials science to offer specialized measurement services, analytical testing, and research-grade plasma equipment to academia and industry.</p>
	</div>
</div>

<div class="clearfix"></div>

<!-- ─── Services Section ─────────────────────────── -->
<section style="padding: 80px 0 40px;">
	<div class="container">
		<div class="section-label">
			<div class="section-label-icon teal"><i class="fa fa-cogs"></i></div>
			<div>
				<div class="section-divider"></div>
				<h2>Our Services</h2>
				<p>Expert analytical and experimental services for your research needs</p>
			</div>
		</div>

		<div class="services-grid">

			<!-- Service 1 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-bolt"></i></div>
				<h3>Surface Modification & Treatment</h3>
				<p>Plasma-based surface treatment to improve wettability, adhesion, sterilization, and biocompatibility of polymers, metals, and bio-materials using DBD and atmospheric plasma jets.</p>
				<div class="service-tags">
					<span class="service-tag">DBD Plasma</span>
					<span class="service-tag">Wettability</span>
					<span class="service-tag">Adhesion</span>
					<span class="service-tag">Biocompatibility</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Book Surface Treatment Service')">
					<i class="fa fa-calendar"></i> Book This Service
				</button>
			</div>

			<!-- Service 2 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-atom" style="font-family:'FontAwesome'; content: '\f111';"></i><i class="fa fa-circle-o"></i></div>
				<h3>Nanomaterial Synthesis</h3>
				<p>Controlled synthesis of metal nanoparticles, carbon nanostructures, and functional thin films via plasma-assisted deposition and reactive sputtering processes.</p>
				<div class="service-tags">
					<span class="service-tag">Nanoparticles</span>
					<span class="service-tag">Thin Films</span>
					<span class="service-tag">Sputtering</span>
					<span class="service-tag">Carbon Nanotubes</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Request Nanomaterial Synthesis Service')">
					<i class="fa fa-calendar"></i> Book This Service
				</button>
			</div>

			<!-- Service 3 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-television"></i></div>
				<h3>Thin Film Deposition</h3>
				<p>Physical and chemical vapor deposition of functional coatings including anti-reflection, hard coatings, and dielectric layers for optical and electronic applications.</p>
				<div class="service-tags">
					<span class="service-tag">PVD</span>
					<span class="service-tag">CVD</span>
					<span class="service-tag">Optical Coatings</span>
					<span class="service-tag">Hard Coatings</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Request Thin Film Deposition Service')">
					<i class="fa fa-calendar"></i> Book This Service
				</button>
			</div>

			<!-- Service 4 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-bar-chart"></i></div>
				<h3>Consulting & Analytical Testing</h3>
				<p>Material characterization using XRD, SEM, UV-Vis spectroscopy, and plasma diagnostics. Expert consultation on experimental design for industry and academic research teams.</p>
				<div class="service-tags">
					<span class="service-tag">XRD Analysis</span>
					<span class="service-tag">SEM/TEM</span>
					<span class="service-tag">UV-Vis</span>
					<span class="service-tag">Consulting</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Book a Consultation')">
					<i class="fa fa-calendar"></i> Book a Consultation
				</button>
			</div>

			<!-- Service 5 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-medkit"></i></div>
				<h3>Plasma Agriculture & Biomedical</h3>
				<p>Cold plasma treatment for seed germination enhancement, food safety, wound disinfection, and cancer research applications using non-thermal atmospheric plasma systems.</p>
				<div class="service-tags">
					<span class="service-tag">Cold Plasma</span>
					<span class="service-tag">Seed Treatment</span>
					<span class="service-tag">Sterilization</span>
					<span class="service-tag">Biomedical</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Inquire about Plasma Agriculture & Biomedical Service')">
					<i class="fa fa-calendar"></i> Book This Service
				</button>
			</div>

			<!-- Service 6 -->
			<div class="service-card">
				<div class="service-card-icon"><i class="fa fa-graduation-cap"></i></div>
				<h3>Lab Visit & Training Programs</h3>
				<p>Guided lab tours, short-course workshops, and hands-on training sessions for students and researchers on plasma physics fundamentals and equipment operation.</p>
				<div class="service-tags">
					<span class="service-tag">Workshop</span>
					<span class="service-tag">Training</span>
					<span class="service-tag">Lab Tour</span>
					<span class="service-tag">Researchers</span>
				</div>
				<button class="btn-book-service" onclick="openContactDialog('Schedule a Lab Visit')">
					<i class="fa fa-calendar"></i> Schedule a Visit
				</button>
			</div>

		</div>
	</div>
</section>

<!-- ─── Why Choose Us ─────────────────────────────── -->
<section style="padding: 40px 0; background: var(--lab-soft);">
	<div class="container">
		<div style="text-align: center; margin-bottom: 12px;">
			<div class="section-divider" style="margin: 0 auto 12px;"></div>
			<h2 style="font-family:'Outfit',sans-serif; font-size:26px; font-weight:800; color:var(--lab-ink); margin-bottom:8px;">Why Partner With Us?</h2>
			<p style="color:var(--lab-muted); font-size:15px;">A trusted academic laboratory with decades of expertise and state-of-the-art instrumentation</p>
		</div>
		<div class="why-grid">
			<div class="why-item">
				<div class="why-item-icon"><i class="fa fa-university"></i></div>
				<h4>Academic Excellence</h4>
				<p>Affiliated with Rajshahi University, one of Bangladesh's leading research institutions</p>
			</div>
			<div class="why-item">
				<div class="why-item-icon"><i class="fa fa-flask"></i></div>
				<h4>Advanced Equipment</h4>
				<p>State-of-the-art plasma systems, characterization instruments, and diagnostic tools</p>
			</div>
			<div class="why-item">
				<div class="why-item-icon"><i class="fa fa-users"></i></div>
				<h4>Expert Team</h4>
				<p>Experienced faculty, researchers, and engineers dedicated to precision and quality</p>
			</div>
			<div class="why-item">
				<div class="why-item-icon"><i class="fa fa-book"></i></div>
				<h4>Published Research</h4>
				<p>100+ peer-reviewed publications in internationally recognized scientific journals</p>
			</div>
			<div class="why-item">
				<div class="why-item-icon"><i class="fa fa-handshake-o"></i></div>
				<h4>Industry Collaboration</h4>
				<p>Open to joint ventures, contract research, and technology transfer partnerships</p>
			</div>
		</div>
	</div>
</section>

<!-- ─── Products Section ──────────────────────────── -->
<section style="padding: 80px 0 40px;">
	<div class="container">
		<div class="section-label">
			<div class="section-label-icon plum"><i class="fa fa-cube"></i></div>
			<div>
				<div class="section-divider" style="background: linear-gradient(90deg, var(--lab-plum), var(--lab-coral));"></div>
				<h2>Our Products</h2>
				<p>Research-grade plasma systems and accessories designed for scientific excellence</p>
			</div>
		</div>

		<div class="products-grid">

			<!-- Product 1 -->
			<div class="product-card">
				<div class="product-card-banner teal-bg">⚡</div>
				<div class="product-card-body">
					<span class="product-card-badge teal-badge">Plasma System</span>
					<h3>Atmospheric Pressure Plasma Jet (APPJ)</h3>
					<p>Compact, bench-top plasma jet systems for surface treatment, biomedical, and environmental applications. Operates at room temperature — safe for heat-sensitive substrates.</p>
					<ul class="product-specs">
						<li><i class="fa fa-check-circle"></i> Frequency: 1–100 kHz operation</li>
						<li><i class="fa fa-check-circle"></i> Working gases: He, Ar, N₂, air mixtures</li>
						<li><i class="fa fa-check-circle"></i> Plasma temperature: Near room temperature</li>
						<li><i class="fa fa-check-circle"></i> Custom nozzle configurations available</li>
					</ul>
					<button class="btn-inquire-product" onclick="openContactDialog('Inquire about Atmospheric Pressure Plasma Jet (APPJ)')">
						<i class="fa fa-envelope"></i> Inquire About This Product
					</button>
				</div>
			</div>

			<!-- Product 2 -->
			<div class="product-card">
				<div class="product-card-banner plum-bg">🔬</div>
				<div class="product-card-body">
					<span class="product-card-badge plum-badge">Discharge System</span>
					<h3>Dielectric Barrier Discharge (DBD) Reactor</h3>
					<p>High-efficiency DBD reactors for ozone generation, pollutant decomposition, and large-area surface activation. Scalable electrode configurations for lab and pilot scale.</p>
					<ul class="product-specs">
						<li><i class="fa fa-check-circle"></i> Voltage: Up to 30 kV peak</li>
						<li><i class="fa fa-check-circle"></i> Treatment area: 5 × 5 cm to 30 × 30 cm</li>
						<li><i class="fa fa-check-circle"></i> Power: 10W–2kW configurations</li>
						<li><i class="fa fa-check-circle"></i> Air and nitrogen compatible</li>
					</ul>
					<button class="btn-inquire-product" onclick="openContactDialog('Inquire about Dielectric Barrier Discharge (DBD) Reactor')">
						<i class="fa fa-envelope"></i> Inquire About This Product
					</button>
				</div>
			</div>

			<!-- Product 3 -->
			<div class="product-card">
				<div class="product-card-banner coral-bg">🧪</div>
				<div class="product-card-body">
					<span class="product-card-badge coral-badge">Accessories</span>
					<h3>Plasma Synthesis Accessories & Probes</h3>
					<p>Langmuir probes, high-voltage power supplies, impedance matching networks, and diagnostic accessories for plasma parameter measurement and system optimization.</p>
					<ul class="product-specs">
						<li><i class="fa fa-check-circle"></i> Single & double Langmuir probes</li>
						<li><i class="fa fa-check-circle"></i> High-voltage measurement dividers</li>
						<li><i class="fa fa-check-circle"></i> Impedance matching (13.56 MHz, 2.45 GHz)</li>
						<li><i class="fa fa-check-circle"></i> Custom-designed on request</li>
					</ul>
					<button class="btn-inquire-product" onclick="openContactDialog('Inquire about Plasma Synthesis Accessories & Probes')">
						<i class="fa fa-envelope"></i> Inquire About This Product
					</button>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- ─── CTA Strip ─────────────────────────────────── -->
<section style="padding: 0 0 80px;">
	<div class="container">
		<div class="cta-strip">
			<h2>Ready to Collaborate?</h2>
			<p>Whether you need a service, product inquiry, or just want to explore how plasma technology can benefit your research, our team is here to help.</p>
			<div class="cta-strip-actions">
				<button class="btn-cta-white" onclick="openContactDialog('Book a Consultation')">
					<i class="fa fa-calendar-check-o"></i> Book a Consultation
				</button>
				<button class="btn-cta-outline" onclick="openContactDialog('Schedule a Lab Visit')">
					<i class="fa fa-map-marker"></i> Schedule a Lab Visit
				</button>
				<a href="https://www.facebook.com/profile.php?id=100064134276504" target="_blank" rel="noopener" class="btn-cta-outline">
					<i class="fa fa-facebook"></i> Find Us on Facebook
				</a>
			</div>
		</div>
	</div>
</section>

<?php include('notice.php'); ?>
<?php include('footer.php'); ?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wow.min.js"></script>
<script>
	new WOW().init();

	function openContactDialog(subject) {
		var dialog = document.getElementById('contact-dialog');
		if (dialog) {
			// Pre-fill subject
			var subjectField = document.querySelector('#contact-dialog [name="subject"]');
			if (subjectField) subjectField.value = subject;

			// Set inquiry type if dropdown exists
			var inquiryType = document.getElementById('inquiry-type');
			if (inquiryType) {
				if (subject.indexOf('Consultation') !== -1) {
					inquiryType.value = 'consultation';
				} else if (subject.indexOf('Lab Visit') !== -1) {
					inquiryType.value = 'lab_visit';
				} else if (subject.indexOf('Inquire') !== -1 || subject.indexOf('Product') !== -1 || subject.indexOf('Service') !== -1) {
					inquiryType.value = 'product_service';
				} else {
					inquiryType.value = 'general';
				}
				// Trigger change event so booking fields show/hide correctly
				if (typeof $ !== 'undefined') {
					$(inquiryType).trigger('change');
				}
			}

			dialog.showModal();
		}
	}
</script>

</body>
</html>
