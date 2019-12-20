<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>List Layers</h1>
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
		<?= $this->session->flashdata('msg') ?>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">List Layers</h3>
			</div>
			<div class="card-body">
				<table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr class="text-center">
							<th>Name</th>
							<th>Geotype</th>
							<th>Import ID</th>
							<th>-</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($layers as $layer): ?>
							<tr>
								<td><?= $layer->name ?></td>
								<td><?= $layer->geotype ?></td>
								<td><?= $layer->import_id ?></td>
								<td class="text-center">
									<a href="<?= base_url('admin/main/layer-detail/' . $layer->id) ?>" class="btn btn-primary btn-xs">
										<i class="fa fa-eye"></i> Detail
									</a>
									<a href="#" onclick="delete_layer(<?= $layer->id ?>);" class="btn btn-danger btn-xs">
										<i class="fa fa-trash"></i> Delete
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
				<a href="<?= base_url('admin/main/create-layers') ?>" class="btn btn-primary">Add New Layer</a>
			</div>
		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#example2").DataTable();
		
	});

	function delete_layer(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			preConfirm: () => {
				return fetch('<?= base_url('admin/main/list-layers') ?>/' + id + '/delete')
				.then(response => {
					if (!response.ok) {
						throw new Error(response.statusText);
					}
					return response.json();
				})
				.catch(error => {
					Swal.showValidationMessage('Request failed: ' + error);
				});
			},
			allowOutsideClick: () => !Swal.isLoading()
		}).then(result => {
			if (result.value.status == 'success') {
				Swal.fire(
					'Deleted!',
					'Your data has been deleted.',
					'success'
					);
				window.location = '<?= base_url('admin/main/list-layers') ?>';
			}
			else {
				Swal.fire('Failed!', result.value.message, 'error');
			}
		});
	}
</script>