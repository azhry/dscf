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
