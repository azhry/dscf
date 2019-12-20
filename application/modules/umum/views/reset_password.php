<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?= base_url('assets/light-bootstrap-dashboard-master') ?>/assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?= 'Reset Password' ?></title>
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
		<div class="collapse navbar-collapse justify-content-end" id="navigation">
			<ul class="navbar-nav ml-auto">
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
						<h4 class="card-title">Reset Password</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('umum/main/reset-password?token=' . $token) ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>New Password</label>
									<input type="password" class="form-control" name="password">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" class="form-control" name="rpassword">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
					</div>
					<div class="card-footer text-center">
						<button class="btn btn-primary" type="submit" name="reset" value="Send Request">
							Reset Password
						</button>
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
