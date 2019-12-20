<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Detail</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<div class="card-body ">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<td><b>Foto</b></td>
									<td>
										<?php if (file_exists(FCPATH . '/assets/img/' . $data->id . '.jpg')): ?>
											<img src="<?= base_url('assets/img/' . $data->id . '.jpg') ?>" style="max-width: 200px;">
										<?php else: ?>
											<img src="http://placehold.it/200x260">
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td><b>Nama</b></td>
									<td><?= $data->name ?></td>
								</tr>
								<tr>
									<td><b>Tempat / Tanggal Lahir</b></td>
									<td><?= $data->birthplace . ' / ' . $data->birthdate ?></td>
								</tr>
								<tr>
									<td><b>Pendidikan</b></td>
									<td>
										<ul>
											<?php foreach ($educational_background as $key => $val): ?>
											<li><?= $val ?></li>
											<?php endforeach; ?>	
										</ul>
										
									</td>
								</tr>
								<tr>
									<td><b>Alamat</b></td>
									<td><?= $data->address ?></td>
								</tr>
								<tr>
									<td><b>Hobi</b></td>
									<td>
										<?php  
											$hobbies = json_decode($data->hobby);
											echo '<ul>';
											foreach ($hobbies as $hobby)
											{
												echo '<li>' . $hobby . '</li>';
											}
											echo '</ul>';
										?>
									</td>
								</tr>
								<tr>
									<td><b>Alasan mengikuti rekrutmen</b></td>
									<td><?= $data->reason ?></td>
								</tr>
								<tr>
									<td><b>Sertifikat</b></td>
									<td>
										<?php if (count($certificates) > 0): ?>
											<?php foreach ($certificates as $certificate): ?>
												<img src="<?= base_url('assets/img/' . $certificate) ?>" style="max-width: 260px;">
											<?php endforeach ?>
										<?php else: ?>
											<img src="http://placehold.it/260x200">
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td><b>KTP</b></td>
									<td>
										<?php if (file_exists(FCPATH . '/assets/img/ktp-' . $data->id . '.jpg')): ?>
											<img src="<?= base_url('assets/img/ktp-' . $data->id . '.jpg') ?>" style="max-width: 260px;">
										<?php else: ?>
											<img src="http://placehold.it/260x200">
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td><b>Kartu Keluarga</b></td>
									<td>
										<?php if (file_exists(FCPATH . '/assets/img/kk-' . $data->id . '.jpg')): ?>
											<img src="<?= base_url('assets/img/kk-' . $data->id . '.jpg') ?>" style="max-width: 260px;">
										<?php else: ?>
											<img src="http://placehold.it/260x200">
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