<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?= $user->name ?></h1>
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
				<h3 class="card-title"><?= $user->name ?></h3>
				<?= $this->session->flashdata('msg') ?>
			</div>
			<div class="card-body">
				<table id="example2" class="table table-bordered table-hover">
					<tbody>
						<tr>
							<td>
								<b>Name</b>
							</td>
							<td><?= $user->name ?></td>
						</tr>
						<tr>
							<td>
								<b>Email</b>
							</td>
							<td><?= $user->email ?></td>
						</tr>
						<tr>
							<td>
								<b>Username</b>
							</td>
							<td><?= $user->username ?></td>
						</tr>
						<tr>
							<td>
								<b>Role</b>
							</td>
							<td><?= isset($user->role) ? $user->role->title : '-' ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
				<a href="<?= base_url('admin/main/update-users/' . $user->id) ?>" class="btn btn-primary">Edit User</a>
			</div>
		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>
  <!-- /.content-wrapper -->