<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " style="overflow-x: scroll;">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Setting</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('pelamar/main/setting') ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Password Lama</label>
									<input type="password" class="form-control" name="old_password">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Password Baru</label>
									<input type="password" class="form-control" name="new_password">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Konfirmasi Password</label>
									<input type="password" class="form-control" name="new_rpassword">
								</div>
							</div>
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