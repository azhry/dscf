<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Diagram</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body">
						<canvas id="myChart" width="400" height="400"></canvas>
					</div>
					<div class="card-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript">
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: [
				<?php $colors = []; foreach ($ranked as $i => $row): ?>
					`<?= $row['name'] ?>`,
				<?php $colors []= [mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)]; endforeach; ?>
			],
			datasets: [{
				label: 'VIKOR SCORE',
				data: [
					<?php foreach ($ranked as $i => $row): ?>
						`<?= round($row['total'], 2) ?>`,
					<?php endforeach; ?>
				],
				backgroundColor: [
					<?php foreach ($colors as $color): ?>
						`<?= 'rgba(' . $color[0] . ', ' . $color[1] . ', ' . $color[2] . ', 0.2)' ?>`,
					<?php endforeach; ?>
				],
				borderColor: [
					<?php foreach ($colors as $color): ?>
						`<?= 'rgba(' . $color[0] . ', ' . $color[1] . ', ' . $color[2] . ', 1)' ?>`,
					<?php endforeach; ?>
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			},
			onClick: function(e, arr) {
				if (arr[0]) {
					console.log(arr[0]._index);
					let ids = [];
					<?php foreach ($ranked as $i => $row): ?>
						ids.push(<?= $row['id'] ?>)
					<?php endforeach; ?>
					window.location = '<?= base_url('pimpinan/main/detail/') ?>' + ids[arr[0]._index];
				}
			}
		}
	});

	// $('#myChart').on('click', function(e) {
	// 	const activePoints = myChart.getSegmentsAtEvent(e);
	// 	console.log(activePoints[0]);
	// });
</script>