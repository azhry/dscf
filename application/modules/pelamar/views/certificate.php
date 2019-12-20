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
								<?php if (count($certificates) > 0): ?>
									<?php foreach ($certificates as $i => $certificate): ?>
										<img src="<?= base_url('assets/img/certificate-' . $user->id . '-' . ($i + 1) . '.jpg') ?>" style="max-height: 250px;">
									<?php endforeach; ?>
								<?php else: ?>
									<p>Anda belum mengupload sertifikat</p>
								<?php endif; ?>
								<br/><br/>
								<div id="upload-container">
									<button class="btn btn-success" type="button" onclick="add();">
										<i class="fa fa-plus"></i>
									</button>
									<input type="hidden" name="upload_count" id="upload-count" value="1">
									<div class="form-group">
										<label>Sertifikat</label>
										<input type="file" class="form-control" name="certificates_1" accept="image/jpg">
									</div>	
								</div>

							</div>
						</div>
						
					</div>
					<div class="card-footer">
						<?php if (count($certificates) <= 0): ?>
						<button onclick="return confirm('Apakah anda yakin? Setelah diunggah, anda tidak akan bisa lagi mengunggah sertifikat');" class="btn btn-primary" type="submit" name="submit" value="Upload">Upload</button>
						<?php endif; ?>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var upload_count = 1;
	function add() {
		$('#upload-container').append(`
			<div class="form-group">
				<label>Sertifikat</label>
				<input type="file" class="form-control" name="certificates_` + (++upload_count) + `" accept="image/jpg">
			</div>	
		`);
		
		$('#upload-count').val(upload_count);
	}
</script>