<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5>Tampilkan Pengumuman</h5>
						<div id="btn-show-container">
							<?php if ($settings->value == 1): ?>
								<button class="btn btn-danger" onclick="change_settings()" type="button">Sembunyikan</button>
								<?php else: ?>
									<button class="btn btn-success" onclick="change_settings()" type="button">Tampilkan</button>
								<?php endif; ?>	
							</div>

							<h5 class="card-category">
								<?= $breadcrumb ?>
							</h5>
							<h4 class="card-title">Converted Values</h4>
							<?= $this->session->flashdata('msg') ?>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<?php foreach ($criteria as $row): ?>
											<th><?= $row->title ?></th>
										<?php endforeach; ?>
									</thead>
									<tbody>
										<?php foreach ($data as $i => $row): ?>
											<?php  
											if (!isset($converted[$i]))
											{
												continue;
											}
											?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row->name ?></td>
												<?php foreach ($row->values as $value): ?>
													<td><?= $converted[$i][$value->criteria->key] ?></td>
												<?php endforeach; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Solution Matrix</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>Kriteria</th>
										<th>f+</th>
										<th>f-</th>
									</thead>
									<tbody>
										<?php foreach ($solution_matrix['positive'] as $k => $v): ?>
											<tr>
												<td><?= $k ?></td>
												<td><?= $v ?></td>
												<td><?= $solution_matrix['negative'][$k] ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Normalized Values</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<?php foreach ($criteria as $row): ?>
											<th><?= $row->title ?></th>
										<?php endforeach; ?>
									</thead>
									<tbody>
										<?php foreach ($data as $i => $row): ?>
											<?php  
											if (!isset($normalized[$i]))
											{
												continue;
											}
											?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row->name ?></td>
												<?php foreach ($row->values as $value): ?>
													<td><?= round($normalized[$i][$value->criteria->key], 2) ?></td>
												<?php endforeach; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Weighted Values</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<?php foreach ($criteria as $row): ?>
											<th><?= $row->title ?></th>
										<?php endforeach; ?>
									</thead>
									<tbody>
										<?php foreach ($data as $i => $row): ?>
											<?php  
											if (!isset($weighted[$i]))
											{
												continue;
											}
											?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row->name ?></td>
												<?php foreach ($row->values as $value): ?>
													<td><?= round($weighted[$i][$value->criteria->key], 2) ?></td>
												<?php endforeach; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Utility Measures</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<th>S</th>
										<th>R</th>
									</thead>
									<tbody>
										<?php foreach ($data as $i => $row): ?>
											<?php  
											if (!isset($utility_measures['sum'][$i]))
											{
												continue;
											}
											?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row->name ?></td>
												<td><?= round($utility_measures['sum'][$i], 2) ?></td>
												<td><?= round($utility_measures['max'][$i], 2) ?></td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-warning">
											<td colspan="2" style="text-align: center;">+</td>
											<td><?= round($utility_measures['max_sum'], 2) ?></td>
											<td><?= round($utility_measures['max_max'], 2) ?></td>
										</tr>
										<tr class="table-warning">
											<td colspan="2" style="text-align: center;">-</td>
											<td><?= round($utility_measures['min_sum'], 2) ?></td>
											<td style="width: 100% !important;"><?= round($utility_measures['min_max'], 2) ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">VIKOR Index (Q)</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<th>Q</th>
									</thead>
									<tbody>
										<?php foreach ($data as $i => $row): ?>
											<?php  
											if (!isset($q_index[$i]))
											{
												continue;
											}
											?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row->name ?></td>
												<td><?= round($q_index[$i], 3) ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Ranked Result</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class=" text-primary">
										<th>No</th>
										<th>Nama</th>
										<th>Total</th>
									</thead>
									<tbody>
										<?php foreach ($ranked as $i => $row): ?>
											<tr>
												<td><?= $i + 1 ?></td>
												<td><?= $row['name'] ?></td>
												<td><?= round($row['total'], 3) ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header ">
							<h5 class="card-category">
							</h5>
							<h4 class="card-title">Compromise Solution</h4>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<h5>Kondisi 1</h5>
								<hr>
								<div class="table-responsive">
									<table class="table table-hover table-striped">
										<thead class=" text-primary">
											<th>DQ</th>
											<th>QA2 - QA1</th>
										</thead>
										<tbody>
											<td><?= $compromise_solution['condition_1']['DQ'] ?></td>
											<td><?= $compromise_solution['condition_1']['QA'] ?></td>
										</tbody>
									</table>
									<p class="text-<?= $condition_1_fulfilled ? 'success' : 'danger' ?>"><?= $condition_1_fulfilled ? 'TERPENUHI' : 'TIDAK TERPENUHI' ?></p>
								</div>
								<hr>
								<h5>Kondisi 2</h5>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="table-responsive">
											<table class="table table-hover table-striped">
												<thead class=" text-primary">
													<th>No</th>
													<th>Nama</th>
													<th>Total</th>
												</thead>
												<tbody>
													<?php foreach ($compromise_solution['condition_2']['v_1'] as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row['name'] ?></td>
															<td><?= round($row['total'], 3) ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-6">
										<div class="table-responsive">
											<table class="table table-hover table-striped">
												<thead class=" text-primary">
													<th>No</th>
													<th>Nama</th>
													<th>Total</th>
												</thead>
												<tbody>
													<?php foreach ($compromise_solution['condition_2']['v_2'] as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row['name'] ?></td>
															<td><?= round($row['total'], 3) ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<p class="text-<?= $condition_2_fulfilled ? 'success' : 'danger' ?>"><?= $condition_2_fulfilled ? 'TERPENUHI' : 'TIDAK TERPENUHI' ?></p>
							</div>
						</div>
						<div class="card-footer">
							<a href="<?= base_url('pimpinan/main/download-report') ?>" class="btn btn-success btn-lg">
								<i class="fa fa-download"></i> Unduh Laporan
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		function change_settings() {
			$.ajax({
				url: '<?= base_url('pimpinan/main/change-settings') ?>',
				type: 'POST',
				data: { },
				success: function(response) {
					const json = $.parseJSON(response);
					if (json.status == 'success') {
						switch (json.value) {
							case 0:
							$('#btn-show-container').html(`
								<button onclick="change_settings()" type="button" class="btn btn-success">Tampilkan</button>
								`);
							break;

							case 1:
							$('#btn-show-container').html(`
								<button onclick="change_settings()" type="button" class="btn btn-danger">
								Sembunyikan
								</button>
								`);
							break;
						}
					}
				},
				error: function(error) { console.log(error); }
			});
		}
	</script>