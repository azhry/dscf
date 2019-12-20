<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Criteria List</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body ">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead class=" text-primary">
									<th>No</th>
									<th>Criteria</th>
									<th>Weight</th>
									<th>Key</th>
									<th>Type</th>
									<th>Category</th>
									<th>-</th>
								</thead>
								<tbody>
									<?php foreach ($criteria as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->title ?></td>
											<td><?= $row->weight ?></td>
											<td><?= $row->key ?></td>
											<td><?= $row->type ?></td>
											<td><?= $row->category ?></td>
											<td>
												<div class="btn-group">
													<a href="<?= base_url('admin/criteria/update/' . $row->id) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
													<a onclick="return confirm('Apakah anda yakin ingin menghapus kriteria ini?')" href="<?= base_url('admin/criteria/delete/' . $row->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<?php if ($user->create_criteria_allowed == 1): ?>
							<a href="<?= base_url('admin/criteria/create') ?>" class="btn btn-primary">
								<i class="fa fa-plus"></i> Add New Criteria
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>