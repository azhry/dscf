<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h4 class="card-title">Form Tambah Gejala Penyakit</h4>
					</div>
					<div class="card-body">
						<?= $this->session->flashdata('msg') ?>
						<?= form_open('dss/main/tambah-gejala-penyakit/' . $id_penyakit) ?>
						<table class="table table-bordered table-striped table-hover">
							<tbody>
								<tr>
									<td width="20%"><strong>Nama Penyakit</strong></td>
									<td><?= $penyakit->nama_penyakit ?></td>
								</tr>
								<tr>
									<td><strong>Kode</strong></td>
									<td><?= $penyakit->kode ?></td>
								</tr>
								<tr>
									<td><strong>Saran Penanganan</strong></td>
									<td><?= $penyakit->saran_penanganan ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Gejala</th>
									<th>Belief</th>
									<th>Plausibility</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($penyakit->gejala_penyakit as $i => $gejala): ?>
									<tr>
										<td><?= $i + 1 ?></td>
										<td><?= $gejala->gejala->nama_gejala ?></td>
										<td><?= $gejala->gejala->belief ?></td>
										<td><?= 1 - $gejala->gejala->belief ?></td>
										<td>
											<a class="btn red btn-xs" href="<?= base_url('admin/hapus-gejala-penyakit?id_penyakit=' . $penyakit->id . '&id_gejala=' . $gejala->gejala->id) ?>">Hapus Gejala</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<hr>
						<h3>Tambah Gejala Baru</h3>
						<div class="form-group">
							<label for="nama_gejala">Nama Gejala</label>
							<textarea class="form-control" name="nama_gejala"></textarea>
						</div>
						<div class="form-group">
							<label for="belief">Belief</label>
							<input type="number" step="any" name="belief" class="form-control">
						</div>
						<input type="submit" value="Submit" name="submit" class="btn btn-primary">
						<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>