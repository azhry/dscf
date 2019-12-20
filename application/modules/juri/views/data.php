<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card" style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Presenter List</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead class=" text-primary">
									<th>No</th>
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
													<a href="<?= base_url('juri/data/update/' . $row->id) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<a href="<?= base_url('juri/data/download-report') ?>" class="btn btn-success btn-lg">
							<i class="fa fa-download"></i> Unduh Laporan
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>