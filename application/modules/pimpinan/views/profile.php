<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Profile</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('pelamar/main/profile') ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" value="<?= $data->name ?>" class="form-control" name="name">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" value="<?= $data->birthdate ?>" class="form-control" name="birthdate">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" value="<?= $data->birthplace ?>" class="form-control" name="birthplace">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<label>Riwayat Pendidikan</label>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SD</label>
											<input type="text" value="<?= $educational_background->elementary ?>" class="form-control" name="elementary">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SMP</label>
											<input type="text" value="<?= $educational_background->junior ?>" class="form-control" name="junior">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SMA</label>
											<input type="text" value="<?= $educational_background->senior ?>" class="form-control" name="senior">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Universitas</label>
											<input type="text" value="<?= $educational_background->university ?>" class="form-control" name="university">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Alamat rumah</label>
									<textarea class="form-control" name="address"><?= $data->address ?></textarea>
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Hobi</label> <br/>
									<input type="checkbox" <?= in_array('Sport', $hobby) ? 'checked' : '' ?> name="sport" value="Sport"> Sport <br/>
									<input type="checkbox" <?= in_array('Food', $hobby) ? 'checked' : '' ?> name="food" value="Food"> Food <br/>
									<input type="checkbox" <?= in_array('Photograph', $hobby) ? 'checked' : '' ?> name="photograph" value="Photograph"> Photograph <br/>
									<input type="checkbox" <?= in_array('Travelling', $hobby) ? 'checked' : '' ?> name="travelling" value="Travelling"> Travelling <br/>
									<input type="checkbox" <?= count(array_diff($hobby, ['Sport', 'Food', 'Photograph', 'Travelling'])) > 0 ? 'checked' : '' ?> name="lainnya" value="Lainnya"> Lainnya <br/>
									<input type="text" value="<?= count(array_diff($hobby, ['Sport', 'Food', 'Photograph', 'Travelling'])) > 0 ? $hobby[0] : '' ?>" class="form-control" name="hobby" placeholder="Hobi lainnya">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Alasan mengikuti rekrutment presenter</label>
									<textarea class="form-control" name="reason"><?= $data->reason ?></textarea>
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<?php if (file_exists(FCPATH . 'assets/img/' . $data->id . '.jpg')): ?>
									<img src="<?= base_url('assets/img/' . $data->id . '.jpg?1') ?>" style="max-height: 100px;">
								<?php else: ?>
									<p>Anda belum mengupload pas foto</p>
								<?php endif; ?>
								<div class="form-group">
									<label>Pas Foto</label>
									<input type="file" accept="image/*" class="form-control" name="image">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-3 pr-1"></div>
							<div class="col-md-6 pr-1">
								<div class="form-group">
									<label>Email</label>
									<input type="email" value="<?= $user->username ?>" class="form-control" name="email">
								</div>
							</div>
							<div class="col-md-3 pr-1"></div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-primary" type="submit" name="submit" value="Upload">Edit</button>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('input[name=hobby]').css('display', 'none');
		if ($('input[name=lainnya]').is(':checked')) {
			$('input[name=hobby]').css('display', 'block');
		}
		else {
			$('input[name=hobby]').css('display', 'none');
		}

		$('input[name=lainnya]').on('change', function() {
			if ($(this).is(':checked')) {
				$('input[name=hobby]').css('display', 'block');
			}
			else {
				$('input[name=hobby]').css('display', 'none');
			}
		});
	});
</script>