<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Update Data Form</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('admin/data/update/' . $id) ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" value="<?= $data->name ?>" class="form-control" name="name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" value="<?= $data->birthdate ?>" class="form-control" name="birthdate">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" class="form-control" value="<?= $data->birthplace ?>" name="birthplace">
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12 pr-1">
								<label>Riwayat Pendidikan</label>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SD</label>
											<input type="text" class="form-control" name="elementary" value="<?= count($educational_background) > 0 ? $educational_background['elementary'] : '' ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SMP</label>
											<input type="text" class="form-control" name="junior" value="<?= count($educational_background) > 0 ? $educational_background['junior'] : '' ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>SMA</label>
											<input type="text" class="form-control" name="senior" value="<?= count($educational_background) > 0 ? $educational_background['senior'] : '' ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Universitas</label>
											<input type="text" class="form-control" name="university" value="<?= count($educational_background) > 0 ? $educational_background['university'] : '' ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Alamat rumah</label>
									<textarea class="form-control" name="address"><?= $data->address ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Hobi</label>
									<input type="text" class="form-control" value="<?= $data->hobby ?>" name="hobby">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Alasan mengikuti rekrutment presenter</label>
									<textarea class="form-control" name="reason"><?= $data->reason ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<img src="<?= base_url('assets/img/' . $data->id . '.jpg?1') ?>" width="100" height="100">
								<div class="form-group">
									<label>Pas Foto</label>
									<input type="file" class="form-control" name="image" accept="image/*">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-primary" type="submit" name="submit" value="Submit">
							<i class="fa fa-paper-plane"></i> Submit
						</button>
					</div>
					<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>