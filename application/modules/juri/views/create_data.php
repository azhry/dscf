<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Create New Data Form</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('admin/data/create') ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" class="form-control" name="name">
								</div>
							</div>
						</div>
						<?= generate_form($criteria) ?>
						<!-- <?php foreach ($criteria as $row): ?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label><?= $row->title ?></label>
										<?php  
											$details = json_decode($row->details);
											switch ($row->type)
											{
												case 'option':
													?>
													<select class="form-control" required name="<?= $row->key ?>">
														<?php foreach ($details as $detail): ?>
															<option value="<?= $detail->label ?>"><?= $detail->label ?></option>
														<?php endforeach; ?>
													</select>
													<?php
												break;

												case 'range':
												?>
													<input type="number" name="<?= $row->key ?>" step="any" class="form-control">
													<?php
													break;
											}
										?>
									</div>
								</div>
							</div>
						<?php endforeach; ?> -->
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