
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h4 class="card-title">Form Input Data Gejala</h4>
					</div>
					<div class="card-body ">
						<?= form_open('dss/main/input-gejala') ?>
							<div class="form-group">
								<label for="nama_gejala">Nama Gejala</label>
								<textarea class="form-control" name="nama_gejala"></textarea>
							</div>
							<div class="form-group">
								<label for="belief">Belief</label>
								<input type="number" step="any" name="belief" class="form-control">
							</div>
							<div class="form-group">
								<label for="penyakit">Penyakit</label>
								<div class="md-checkbox-list">
									<?php foreach ($penyakit as $row): ?>
									<!-- <div class="md-checkbox"> -->
									<div>
										<input type="checkbox" id="checkbox-<?= $row->kode ?>" name="<?= $row->kode ?>" class="md-check">
										<label for="checkbox-<?= $row->kode ?>">
										<span></span>
										<span class="check"></span>
										<span class="box"></span>
										<?= $row->nama_penyakit . ' (' . $row->kode . ')' ?> </label>
									</div>
									<?php endforeach; ?>
								</div>
							</div>
							<input type="submit" value="Submit" name="submit" class="btn btn-primary">
						<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>