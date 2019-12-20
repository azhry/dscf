<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Pengumuman</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body ">
						<table class="table table-striped table-hover">
							<tbody>
								<!-- <?php foreach ($criteria as $i => $row): ?>
									<tr>
										<td><b><?= $row->title ?></b></td>
										<td>
											<?php if ($row->title == 'Audio Visual' && isset($user_data->values[$i])): ?>
												<?php  
													$details = json_decode($user_data->values[$i]->value);
													echo '<ul>';
													foreach ($details as $k => $v)
													{
														echo '<li>' . $v . '</li>';
													}
													echo '</ul>';
												?>
											<?php else: ?>
												<?= isset($user_data->values[$i]) ? $user_data->values[$i]->value : '-' ?>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?> -->
								<tr>
									<td><b>Administrasi</b></td>
									<td>
										<?php 
											switch ($user_data->status)
											{
												case -1:
													echo '<span class="text-primary">Belum Dinilai</span>';
													break;

												case 0:
													echo '<span class="text-danger">Tidak Lulus</span>';
													break;											
												default:
													echo '<span class="text-success">Lulus</span>';
													break;		
											}
										?>
									</td>
								</tr>
								<tr>
									<td><b>Wawancara</b></td>
									<td>
										<?php 
											switch ($user_data->status)
											{
												case -1:
												case 1:
													echo '<span class="text-primary">Belum Dinilai</span>';
													break;

												case 0:
													echo '<span class="text-danger">Tidak Lulus</span>';
													break;											
												default:
													echo '<span class="text-success">Lulus</span>';
													break;		
											}
										?>
									</td>
								</tr>
								<tr>
									<td><b>Hasil Akhir</b></td>
									<td>
										<?php if (!in_array($user->id, array_column($ranked, 'user_id'))): ?>
											<p class="text-primary">Belum Dinilai</p>
										<?php else: ?>
											<?php if ($user->id === $ranked[0]['user_id']): ?>
												<p class="text-success">Lulus</p>
											<?php else: ?>
												<p class="text-danger">Tidak Lulus</p>
											<?php endif; ?>
										<?php endif; ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>