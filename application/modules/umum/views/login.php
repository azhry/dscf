<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?= 'Login' ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<!-- CSS Files -->
	<link href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/css/demo.css" rel="stylesheet" />
</head>

<body>
	<div class="wrapper">
		<nav class="navbar navbar-expand-lg " color-on-scroll="500">
			<div class="container-fluid">
				<a class="navbar-brand" href="#" style="font-size: 12px; text-align: center; margin-left: 380px;"> SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN PRESENTER MENGGUNAKAN <br>METODE VISE KRITERIJUMSKA OPTIMIZACIJA I KOMPROMISNO RESENJE (VIKOR) <br>(STUDI KASUS: TVRI SUMATERA SELATAN) </a>
		<!-- <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
		</button> -->
		<div class="collapse navbar-collapse justify-content-end" id="navigation">
			<!-- <ul class="nav navbar-nav mr-auto">
				<li class="nav-item">
					<a href="#" class="nav-link" data-toggle="dropdown">
						<i class="nc-icon nc-palette"></i>
						<span class="d-lg-none">Dashboard</span>
					</a>
				</li>
				<li class="dropdown nav-item">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<i class="nc-icon nc-planet"></i>
						<span class="notification">5</span>
						<span class="d-lg-none">Notification</span>
					</a>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="#">Notification 1</a>
						<a class="dropdown-item" href="#">Notification 2</a>
						<a class="dropdown-item" href="#">Notification 3</a>
						<a class="dropdown-item" href="#">Notification 4</a>
						<a class="dropdown-item" href="#">Another notification</a>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nc-icon nc-zoom-split"></i>
						<span class="d-lg-block">&nbsp;Search</span>
					</a>
				</li>
			</ul> -->
			<ul class="navbar-nav ml-auto">
				<!-- <li class="nav-item">
					<a class="nav-link" href="#pablo">
						<span class="no-icon">Account</span>
					</a>
				</li> -->
				<!-- <li class="nav-item">
					<a class="nav-link" href="#pablo">
						<span class="no-icon">Log out</span>
					</a>
				</li> -->
			</ul>
		</div>
	</div>
</nav>
<!-- End Navbar -->

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header text-center">
						<h5 class="card-category">
						</h5>
						<h4 class="card-title">Login</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('umum/main') ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" name="username">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" name="password">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
					</div>
					<div class="card-footer text-center">
						<button class="btn btn-primary" type="submit" name="login" value="Login">
							Login
						</button>
						<br>
						<a href="<?= base_url('umum/main/send-reset-password') ?>">Lupa password?</a>
						<br>
						<br>
						<br>
						<a href="<?= base_url('umum/main/register') ?>">Daftar Sekarang</a>
						<br>
						<br>
						<?php if ($settings && $settings->value == 1): ?>
							<a href="<?= base_url('umum/results') ?>">Lihat Pengumuman</a>
						<?php endif; ?>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<footer class="footer">
	<div class="container-fluid">
		<nav>
			<!-- <ul class="footer-menu">
				<li>
					<a href="#">
						Home
					</a>
				</li>
				<li>
					<a href="#">
						Company
					</a>
				</li>
				<li>
					<a href="#">
						Portfolio
					</a>
				</li>
				<li>
					<a href="#">
						Blog
					</a>
				</li>
			</ul> -->
			<p class="copyright text-center">
				©
				<script>
					document.write(new Date().getFullYear())
				</script>
				<a href="<?= base_url('admin/data') ?>">Sistem Informasi</a>, Fakultas Ilmu Komputer, Universitas Sriwijaya
			</p>
		</nav>
	</div>
</footer>
</div>
</div>
</body>
<!--   Core JS Files   -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/js/demo.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        // demo.showNotification();

    });
</script>

</html>
