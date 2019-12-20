<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">User List</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body ">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead class=" text-primary">
									<th>No</th>
									<th>Username</th>
									<th>Role</th>
									<th>-</th>
								</thead>
								<tbody>
									<?php foreach ($users as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->username ?></td>
											<td><?= $row->role->role ?></td>
											<td>
												<div class="btn-group">
													<a href="<?= base_url('sistem/users/update/' . $row->id) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
													<a onclick="return confirm('Apakah anda yakin ingin menghapus pengguna ini?')" href="<?= base_url('sistem/users/delete/' . $row->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<a href="<?= base_url('sistem/users/create') ?>" class="btn btn-primary">
							<i class="fa fa-plus"></i> Add New User
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>