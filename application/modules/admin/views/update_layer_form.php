<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Update Layers</h1>
				</div>
				<div class="col-sm-6">
					<?php 
					echo $breadcrumb;
					?>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Update Layer Form</h3>
				<?= $this->session->flashdata('msg') ?>
			</div>
			<div class="card-body">
				<?= form_open_multipart('admin/main/update-layers/' . $layer->id, ['role' => 'form']) ?>
				<div class="card-body">
					<div class="form-group">
						<label for="name">Layer Name</label>
						<input value="<?= $layer->name ?>" type="text" maxlength="100" class="form-control" name="name" placeholder="E.g: Jembatan">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" name="description"><?= $layer->description ?></textarea>
					</div>
					<div class="form-group">
						<label for="geotype">Geotype</label>
						<select class="form-control" required name="geotype">
							<option value="">Choose Geotype</option>
							<?php foreach (['Polyline', 'Line', 'Markers', 'Shield', 'Line Pattern', 'Polygon Pattern', 'Raster', 'Point', 'Text', 'Building'] as $geotype): ?>
								<option <?= $layer->geotype == $geotype ? 'selected' : '' ?> value="<?= $geotype ?>"><?= $geotype ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="icon">Icon</label><br>
						<img style="width: 40px; height: 40px; object-fit: contain;" src="<?= file_exists(FCPATH . '/assets/files/icons/' . $layer->icon) ? base_url('/assets/files/icons/' . $layer->icon) : 'http://placehold.it/40' ?>" style="margin-bottom: 5px;">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="icon" name="icon" onchange="document.getElementById('icon-text').innerText = this.value.replace(/.*[\/\\]/, '') || 'Choose icon';">
								<label class="custom-file-label" for="icon" id="icon-text">Choose icon</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="icon">Shapefile <?= $imports != false ? '<small>(<i>Import Status: <span class="text-' . ($imports->state == 'complete' ? 'success' : 'danger') . '">' . $imports->state . '</span></i>)</small>' : '' ?></label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="shapefile" name="shapefile" onchange="document.getElementById('shapefile-text').innerText = this.value.replace(/.*[\/\\]/, '') || '<?= $imports != false ? $imports->table_name : 'Choose shapefile' ?>';">
								<label class="custom-file-label" for="shapefile" id="shapefile-text"><?= $imports != false ? $imports->table_name : 'Choose shapefile' ?></label>
							</div>
						</div>
					</div>
				</div>
				<!-- /.card-body -->

				<div class="card-footer">
					<input type="submit" name="submit" value="Edit Layer" class="btn btn-primary">
				</div>
				<?= form_close() ?>
			</div>
			<!-- /.card-body -->

		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>
  <!-- /.content-wrapper -->