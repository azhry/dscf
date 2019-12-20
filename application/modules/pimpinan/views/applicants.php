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
									<th>Nama</th>
									<th>-</th>
								</thead>
								<tbody>
									<?php $dec = 0; foreach ($users as $i => $row): ?>
										<?php
											$i -= $dec; 
											if (!isset($row->data))  
											{
												$dec++; 
												continue;
											}
										?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->data->name ?></td>
											<td id="status-<?= $row->data->id ?>">
												<?php 
												switch ($row->data->status)
												{
													case -1:
													case 1:
													case 2:
														?>
														<div class="btn-group">
															<button type="button" onclick="handleChangeStatus(<?= $row->data->id ?>, 3)" class="btn btn-success">
																<i class="fa fa-check"></i> Lulus
															</button>
															<button type="button" onclick="handleChangeStatus(<?= $row->data->id ?>, 0)" class="btn btn-danger">
																<i class="fa fa-close"></i> Tidak Lulus
															</button>	
														</div>
														<?php
														break;

													case 3:
														?>
														<button type="button" onclick="handleChangeStatus(<?= $row->data->id ?>, 2)" class="btn btn-success">
															<i class="fa fa-check"></i> Lulus
														</button>
														<?php
														break;

													case 0:
														?>
														<button type="button" onclick="handleChangeStatus(<?= $row->data->id ?>, 2)" class="btn btn-danger">
															<i class="fa fa-close"></i> Tidak Lulus
														</button>
														<?php
														break;
												}
												?>
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
	function handleChangeStatus(id, status) {
		if (confirm('Apakah anda yakin ingin mengubah status kelulusan peserta ini?')) {
			$.ajax({
				url: '<?= base_url('pimpinan/main/change-status') ?>',
				type: 'POST',
				data: {
					data_id: id,
					status: status
				},
				success: function(response) {
					console.log(response);
					const json = $.parseJSON(response);
					if (json.message == 'Success') {
						switch (Number(json.status)) {
							case -1:
							case 1:
							case 2:
								$('#status-' + id).html(`
									<div class="btn-group">
										<button type="button" onclick="handleChangeStatus(` + id + `, 3)" class="btn btn-success">
											<i class="fa fa-check"></i> Lulus
										</button>
										<button type="button" onclick="handleChangeStatus(` + id + `, 0)" class="btn btn-danger">
											<i class="fa fa-close"></i> Tidak Lulus
										</button>	
									</div>
								`);
								break;

							case 0:
								$('#status-' + id).html(`
									<button type="button" onclick="handleChangeStatus(` + id + `, 2)" class="btn btn-danger">
										<i class="fa fa-close"></i> Tidak Lulus
									</button>
								`);
								break;

							case 3:
								$('#status-' + id).html(`
									<button type="button" onclick="handleChangeStatus(` + id + `, 2)" class="btn btn-success">
										<i class="fa fa-check"></i> Lulus
									</button>
								`);
								break;
						}
					}		
				},
				error: function(error) {
					console.log(error);
				}
			});	
		}
		
	}
</script>