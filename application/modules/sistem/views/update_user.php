<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Update User Form</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('sistem/users/update/' . $id) ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Username or email</label>
									<input type="text" class="form-control" name="username" value="<?= $user->username ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Role</label>
									<select class="form-control" name="role_id" required>
										<option value="">Choose Role</option>
										<?php foreach ($roles as $role): ?>
											<option <?= $user->role_id == $role->id ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->role ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" name="rpassword" class="form-control">
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