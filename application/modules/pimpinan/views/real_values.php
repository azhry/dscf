<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Real Values</h4>
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
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->name ?></td>
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
	</div>
</div>

