<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Edit User</h1>
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
				<h3 class="card-title">Edit User Form</h3>
				<?= $this->session->flashdata('msg') ?>
				
				<div class="card-body">
					<?= form_open_multipart('admin/main/update-users/' . $user->id, ['role' => 'form']) ?>
					<div class="card-body">
						<div class="form-group">
							<label for="name">Name</label>
							<input value="<?= $user->name ?>" type="text" maxlength="400" class="form-control" name="name">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input value="<?= $user->email ?>" type="email" maxlength="300" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input value="<?= $user->username ?>" type="text" maxlength="50" class="form-control" name="username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<div class="form-group">
							<label for="rpassword">Re-type Password</label>
							<input type="password" class="form-control" name="rpassword">
						</div>
						<div class="form-group">
							<label for="role_id">Role</label>
							<select class="form-control" required name="role_id">
								<option value="">Choose Role</option>
								<?php foreach ($roles as $role): ?>
									<option <?= isset($user->role) && $user->role->id == $role->id ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->title ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<!-- /.card-body -->

					<div class="card-footer">
						<input type="submit" name="submit" value="Edit User" class="btn btn-primary">
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