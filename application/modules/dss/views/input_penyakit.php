<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h4 class="card-title">Form Input Data Penyakit</h4>
					</div>
					<div class="card-body">
						<?= form_open('dss/main/input-penyakit') ?>
							<div class="form-group">
								<label for="nama_penyakit">Nama Penyakit</label>
								<textarea class="form-control" name="nama_penyakit"></textarea>
							</div>
							<div class="form-group">
								<label for="kode">Kode</label>
								<input type="text" name="kode" maxlength="2" class="form-control">
							</div>
							<div class="form-group">
								<label for="saran_penanganan">Saran Penanganan</label>
								<textarea class="form-control" name="saran_penanganan"></textarea>
							</div>
							<input type="submit" value="Submit" name="submit" class="btn btn-primary">
						<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>