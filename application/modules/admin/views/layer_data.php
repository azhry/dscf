<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Data <?= $layer->name ?></h1>
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
				<h3 class="card-title"><?= $layer->name ?></h3>
				<?= $this->session->flashdata('msg') ?>
			</div>
			<div class="card-body">
				<table id="example2" class="table table-bordered table-hover">
					<tbody>
						<tr>
							<td>
								<b>Name</b>
							</td>
							<td><?= $layer->name ?></td>
						</tr>
						<tr>
							<td>
								<b>Geotype</b>
							</td>
							<td><?= $layer->geotype ?></td>
						</tr>
						<tr>
							<td>
								<b>Import ID</b>
							</td>
							<td><?= $layer->import_id ?></td>
						</tr>
						<tr>
							<td>
								<b>Description</b>
							</td>
							<td><?= $layer->description ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
				<a href="<?= base_url('admin/main/update-layers/' . $layer->id) ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Layer</a>
				<a href="<?= base_url('admin/main/layer-data/' . $layer->id) ?>" class="btn btn-info"><i class="fas fa-eye"></i> View Data</a>
			</div>
		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>
  <!-- /.content-wrapper -->