<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h4 class="card-title">Daftar Gejala</h4>
					</div>
					<div class="card-body ">
						<table class="table table-striped table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Gejala</th>
									<th>Belief</th>
									<th>Plausibility</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								<?php foreach ($gejala as $i => $row): ?>
									<tr>
										<td><?= $i + 1 ?></td>
										<td><?= $row->nama_gejala ?></td>
										<td><?= $row->belief ?></td>
										<td><?= 1 - $row->belief ?></td>
										<!-- <td>
											<div class="btn-group">
												<a class="btn blue" href="<?= base_url('dss/main/edit-gejala/' . $row->id) ?>">
													<i class="fa fa-edit"></i> Edit
												</a>
											<a class="btn red" href="#button">
												<i class="fa fa-trash"></i> Delete
											</a>
											</div>
										</td> -->
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

					<a href="<?= base_url('dss/main/input-gejala') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> Buat Gejala Baru</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>