<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Sertifikat</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('pelamar/main/certificate') ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<?php if (file_exists(FCPATH . 'assets/img/certificate-' . $user->id . '.jpg')): ?>
									<img src="<?= base_url('assets/img/certificate-' . $user->id . '.jpg') ?>" style="max-height: 250px;">
								<?php else: ?>
									<p>Anda belum mengupload sertifikat</p>
								<?php endif; ?>
								<div class="form-group">
									<label>Sertifikat</label>
									<input type="file" class="form-control" name="certificate" accept="image/jpg">
								</div>
							</div>
						</div>
						
					</div>
					<div class="card-footer">
						<button class="btn btn-primary" type="submit" name="submit" value="Upload">Upload</button>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>