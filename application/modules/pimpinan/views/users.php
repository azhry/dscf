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
											<td id="btn-<?= $row->id ?>">
												<?php if ($row->create_criteria_allowed == 0): ?>
													<button class="btn btn-primary btn-sm" onclick="approve_create_criteria(<?= $row->id ?>)">Approve Create Criteria</button>
												<?php else: ?>
													<button class="btn btn-success btn-sm" onclick="approve_create_criteria(<?= $row->id ?>)">
														<i class="fa fa-check"></i> Create Criteria Approved
													</button>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function approve_create_criteria(id) {
		$.ajax({
			url: '<?= base_url('pimpinan/users/approve-create-criteria') ?>',
			type: 'POST',
			data: { id: id },
			success: function(response) {
				const json = $.parseJSON(response);
				if (json.status == 'success') {
					switch (json.data) {
						case 0:
							$('#btn-' + id).html(`
								<button onclick="approve_create_criteria(` + id + `)" class="btn btn-primary btn-sm">Approve Create Criteria</button>
							`);
							break;

						case 1:
							$('#btn-' + id).html(`
								<button onclick="approve_create_criteria(` + id + `)" class="btn btn-success btn-sm">
									<i class="fa fa-check"></i> Create Criteria Approved
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