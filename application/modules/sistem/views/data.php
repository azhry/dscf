<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Presenter List</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body ">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead class=" text-primary">
									<th>No</th>
									<!-- <th>-</th> -->
									<th>Status</th>
									<th>Nama</th>
									<th>Tempat/Tanggal Lahir</th>
									<th>Riwayat Pendidikan</th>
									<th>Alamat</th>
									<th>Hobi</th>
									<th>Alasan Mengikuti Rekrutmen Presenter</th>
									<?php foreach ($criteria as $row): ?>
										<th><?= $row->title ?></th>
									<?php endforeach; ?>
									<th>-</th>
								</thead>
								<tbody>
									<?php foreach ($data as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<!-- <td>
												<div class="form-group">
													<select style="width: 180px !important;" class="form-control" onchange="changeStatus(this, <?= $row->id ?>);">
														<option value="-1" <?= $row->status === -1 ? 'selected' : '' ?>>Belum Ditentukan</option>
														<option value="0" <?= $row->status === 0 ? 'selected' : '' ?>>Tidak Lulus</option>
														<option value="1" <?= $row->status === 1 ? 'selected' : '' ?>>Lulus Tahap Administrasi</option>
														<option value="2" <?= $row->status === 2 ? 'selected' : '' ?>>Lulus Tahap Wawancara</option>
													</select>	
												</div>
												
											</td> -->
											<td id="status-<?= $row->id ?>">
												<?php 
													switch ($row->status)
													{
														case -1:
															?>
															<div class="btn-group">
																<button type="button" onclick="handleChangeStatus(<?= $row->id ?>, 1)" class="btn btn-success">
																	<i class="fa fa-check"></i>
																</button>
																<button type="button" onclick="handleChangeStatus(<?= $row->id ?>, 0)" class="btn btn-danger">
																	<i class="fa fa-close"></i>
																</button>	
															</div>
															<?php
															break;

														case 0:
															echo '<span class="text-danger">Tidak Lulus</span>';
															break;

														case 1:
															echo '<span class="text-success">Lulus Tahap Administrasi</span>';
															break;

														case 2:
															echo '<span class="text-success">Lulus Tahap Wawancara</span>';
															break;
													}
												?>
											</td>
											<!-- <td id="status-<?= $row->id ?>">
												<?php 
													switch ($row->status)
													{
														case -1:
															echo '<span class="text-primary">Belum Ditentukan</span>';
															break;

														case 0:
															echo '<span class="text-danger">Tidak Lulus</span>';
															break;

														case 1:
															echo '<span class="text-success">Lulus Tahap Administrasi</span>';
															break;

														case 2:
															echo '<span class="text-success">Lulus Tahap Wawancara</span>';
															break;
													}
												?>
											</td> -->
											<td><?= $row->name ?></td>
											<td><?= $row->birthplace . '/' . $row->birthdate ?></td>
											<td>
												<ul>
													<?php  
													if (!empty($row->educational_background))
													{
														$background = json_decode($row->educational_background);
														foreach ($background as $k => $b)
														{
															if (!isset($b) or empty($b))
															{
																continue;
															}
															echo '<li>' . $b . '</li>';
														}
													}
													?>	
												</ul>
											</td>
											<td><?= $row->address ?></td>
											<td><?= $row->hobby ?></td>
											<td><?= $row->reason ?></td>
											<?php foreach ($row->values as $value): ?>
												<td>
													<?php  
													$details = json_decode($value->criteria->details);
													$label = '-';

													$break = false;
													foreach ($details as $detail)
													{
														switch ($value->criteria->type)
														{
															case 'option':
															if ($detail->label == $value->value)
															{
																$label = $value->value;
																$break = true;
															}
															break;

															case 'range':
															$label = $value->value;
															$break = true;
															break;

															case 'criteria':
															$label = '<ul>';
															$values = json_decode($value->value);
															foreach ($values as $k => $v)
															{
																$label .= '<li>' . $v . '</li>';
															}
															$label .= '</ul>';

															$break = true;
															break;
														}

														if ($break)
														{
															break;
														}
													}


													echo $label;
													?>
												</td>
											<?php endforeach; ?>
											<?php if (count($row->values) <= 0): ?>
												<?php foreach ($criteria as $x): ?>
													<td>-</td>
												<?php endforeach; ?>
											<?php endif; ?>
											<td>
												<div class="btn-group">
													<a href="<?= base_url('admin/data/detail/' . $row->id) ?>" class="btn btn-primary">
														<i class="fa fa-eye"></i> Detail
													</a>
													<!-- <a href="<?= base_url('admin/data/update/' . $row->id) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
														<a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?= base_url('admin/data/delete/' . $row->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> -->
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
						<!-- <a href="<?= base_url('admin/data/create') ?>" class="btn btn-primary">
							<i class="fa fa-plus"></i> Add Data
						</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function changeStatus(obj, id) {
		const value = $(obj).val();
		$.ajax({
			url: '<?= base_url('admin/data/change-status') ?>',
			type: 'POST',
			data: {
				data_id: id,
				status: value
			},
			success: function(response) {
				const json = $.parseJSON(response);
				console.log(json);
				if (json.message == 'Success') {
					switch (Number(json.status)) {
						case -1:
						$('#status-' + id).html(`<span class="text-primary">Belum Ditentukan</span>`);
						break;

						case 0:
						$('#status-' + id).html(`<span class="text-danger">Tidak Lulus</span>`);
						break;

						case 1:
						$('#status-' + id).html(`<span class="text-success">Lulus Tahap Administrasi</span>`);
						break;

						case 2:
						$('#status-' + id).html(`<span class="text-success">Lulus Tahap Wawancara</span>`);
						break;
					}
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
	}

	function handleChangeStatus(id, status) {
		if (confirm('Apakah anda yakin ingin mengubah status kelulusan peserta ini?')) {
			$.ajax({
				url: '<?= base_url('admin/data/change-status') ?>',
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
							$('#status-' + id).html(`<span class="text-primary">Belum Ditentukan</span>`);
							break;

							case 0:
							$('#status-' + id).html(`<span class="text-danger">Tidak Lulus</span>`);
							break;

							case 1:
							$('#status-' + id).html(`<span class="text-success">Lulus Tahap Administrasi</span>`);
							break;

							case 2:
							$('#status-' + id).html(`<span class="text-success">Lulus Tahap Wawancara</span>`);
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