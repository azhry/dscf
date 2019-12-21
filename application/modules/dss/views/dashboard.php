<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h4 class="card-title"></h4>
					</div>
					<div class="card-body">
						<?php if (isset($result, $result_cf)): ?>
							<div class="row">
								<div class="col-md-12">
									<div class="portlet box green">
										<div class="portlet-title">
											<h3 class="caption">
												Hasil Dempster - Shafer
											</h3>
										</div>
										<div class="portlet-body">
											<table class="table table-responsive table-hover table-bordered">
												<thead>
													<tr>
														<th>No.</th>
														<th>Gejala</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($gejala_terpilih as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row->nama_gejala ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
											<p>Dari perhitungan <strong><?= count($gejala_terpilih) ?></strong> gejala tersebut didapat hasil penyakit <strong><?= $result[0]['index'] ?> (<?= implode(',', array_column($penyakit, 'nama_penyakit')) ?>)</strong> dengan nilai probabilitas <strong><?= $result[0]['nilai'] ?></strong> atau <strong><?= round($result[0]['nilai'] * 100, 2) ?> %</strong></p>
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th>No</th>
														<th>Penyakit</th>
														<th>Saran Penanganan</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($penyakit as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row->nama_penyakit ?></td>
															<td><?= nl2br($row->saran_penanganan) ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="portlet box green">
										<div class="portlet-title">
											<h3 class="caption">
												Hasil Certainty Factor
											</h3>
										</div>
										<div class="portlet-body">
											<table class="table table-responsive table-hover table-bordered">
												<thead>
													<tr>
														<th>No.</th>
														<th>Gejala</th>
														<th>CF</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($gejala_terpilih as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row->nama_gejala ?></td>
															<td><?= $cfs[$row->nama_gejala] ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
											<p>Dari perhitungan <strong><?= count($gejala_terpilih) ?></strong> gejala tersebut didapat hasil penyakit 
												<?php foreach ($result_cf_keys as $i => $key): ?>
													<strong><?= $key ?> </strong> dengan nilai probabilitas <strong><?= $result_cf_values[$i] ?></strong> atau <strong><?= round($result_cf_values[$i] * 100, 2) ?> %</strong>. 
												<?php endforeach; ?>
												
											</p>
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th>No</th>
														<th>Penyakit</th>
														<th>Saran Penanganan</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($penyakit_cf as $i => $row): ?>
														<tr>
															<td><?= $i + 1 ?></td>
															<td><?= $row->nama_penyakit ?></td>
															<td><?= nl2br($row->saran_penanganan) ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="row">
							<div class="col-md-12">
								<?= $this->session->flashdata('msg') ?>
								<div class="portlet box green">
									<div class="portlet-title">
										<h3 class="caption">
											Daftar Gejala
										</h3>
									</div>
									<div class="portlet-body">
										<?= form_open('dss/main') ?>
										<div class="md-checkbox-list">
											<?php foreach ($gejala as $row): ?>
												<div class="row">
													<div class="col-md-6">
														<input type="checkbox" id="checkbox-<?= $row->id ?>" name="gejala_<?= $row->id ?>" class="md-check">
														<label for="checkbox-<?= $row->id ?>">
															<span></span>
															<span class="check"></span>
															<span class="box"></span>
															<?= $row->nama_gejala ?> 
														</label>	
													</div>
													<div class="col-md-6">
														<select class="form-control" id="select-<?= $row->id ?>" name="gejala_select_<?= $row->id ?>">
															<option value="0.2">Tidak Yakin</option>
															<option value="0.4">Sedikit Yakin</option>
															<option value="0.6">Cukup Yakin</option>
															<option value="0.8">Yakin</option>
														</select>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
										<input type="submit" value="Proses" name="process" class="btn btn-primary">
										<?= form_close() ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>