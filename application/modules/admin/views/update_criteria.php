<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header ">
						<h5 class="card-category">
							<?= $breadcrumb ?>
						</h5>
						<h4 class="card-title">Update Criteria Form</h4>
						<?= $this->session->flashdata('msg') ?>
					</div>
					<?= form_open_multipart('admin/criteria/update/' . $id) ?>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" value="<?= $criteria->title ?>" name="title">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" name="description"><?= $criteria->description ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Weight</label>
									<input type="number" step="any" class="form-control" value="<?= $criteria->weight ?>" name="weight">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Key</label>
									<input type="text" class="form-control" value="<?= $criteria->key ?>" name="key">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Type</label>
									<select class="form-control" name="type" id="type" required>
										<option value="">Choose Type</option>
										<option <?= $criteria->type === 'range' ? 'selected' : '' ?> value="range">Range</option>
										<option <?= $criteria->type === 'option' ? 'selected' : '' ?> value="option">Option</option>
										<option <?= $criteria->type === 'criteria' ? 'selected' : '' ?> value="criteria">Criteria</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Category</label>
									<select class="form-control" name="category" required>
										<option value="">Choose Category</option>
										<option <?= $criteria->category === 'Cost' ? 'selected' : '' ?> value="Cost">Cost</option>
										<option <?= $criteria->category === 'Benefit' ? 'selected' : '' ?> value="Benefit">Benefit</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-1">
								<div class="form-group">
									<label>Details</label>
								</div>
							</div>
						</div>
						<div id="type-container"></div>
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

<script type="text/javascript">
	var num_sub = 0;
	$(document).ready(function() {
		$('#type').on('change', function() {
			init();
		});

		init();

		let idx;
		<?php if ($criteria->type === 'criteria'): ?>
			<?php
				$i = 0;  
				$details = json_decode($criteria->details);
				foreach ($details as $detail):
			?>
				add_subcriteria_edit('<?= $detail->key ?>', '<?= $detail->title ?>', '<?= $detail->weight ?>');
				<?php  
					$values = $detail->details;
					foreach ($values as $v):
				?>
					idx = add_subcriteria_values_edit('<?= $i ?>', '<?= $v->label ?>', '<?= $v->value ?>');
				<?php endforeach; $i++; ?>
			<?php endforeach; ?>
		<?php elseif ($criteria->type == 'option'): ?>
			<?php  
				$details = json_decode($criteria->details);
				foreach ($details as $detail):
			?>
				add_option_edit(`<?= $detail->label ?>`, `<?= $detail->value ?>`);
			<?php endforeach; ?>
		<?php elseif ($criteria->type == 'range'): ?>
			<?php  
				$details = json_decode($criteria->details);
				foreach ($details as $detail):
			?>
				add_range_edit(`<?= $detail->label ?>`, `<?= $detail->min ?>`, `<?= $detail->max ?>`, `<?= $detail->value ?>`);
			<?php endforeach; ?>
		<?php endif; ?>
	});

	function init() {
		let type = $('#type').val();
		if (type === 'range') {
			$('#type-container').html('')
				.html('<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="type"></label><div class="col-md-3 col-sm-3 col-xs-12" for="type"><button onclick="add_range();" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add</button></div></div>');
				add_range();
		} else if (type === 'option') {
			$('#type-container').html('')
				.html('<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="type"></label><div class="col-md-3 col-sm-3 col-xs-12" for="type"><button onclick="add_option();" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add</button></div></div>');
				add_option();
		} else if (type === 'criteria') {
			$('#type-container').html('')
				.html('<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="type"></label><div class="col-md-3 col-sm-3 col-xs-12" for="type"><button onclick="add_subcriteria();" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add</button></div></div>'); // tambah subcriteria
				add_subcriteria();
		}
	}

	function add_range() {
		$('#type-container').append(`
			<div class="row">
				<div class="col-md-2 pr-1">
					<input type="text" name="range_label[]" required="required" class="form-control" placeholder="Label">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_min[]" required="required" min="0" step="any" class="form-control" placeholder="Min">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_max[]" required="required" min="0" step="any" class="form-control" placeholder="Max">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_value[]" required="required" min="0" step="any" class="form-control" placeholder="Value">
				</div>
				<div class="col-md-1 pr-1">
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		`);
	}

	function add_option() {
		$('#type-container').append(`
			<div class="row">
				<div class="col-md-5 pr-1">
					<input type="text" name="option_label[]" class="form-control" placeholder="Label">
				</div>
				<div class="col-md-5 pr-1">
					<input type="number" name="option_value[]" min="0" step="any" class="form-control" placeholder="Value">
				</div>
				<div class="col-md-1 pr-1">
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		`);
	}

	function add_range_edit(label, min, max, value) {
		$('#type-container').append(`
			<div class="row">
				<div class="col-md-2 pr-1">
					<input type="text" name="range_label[]" required="required" class="form-control" placeholder="Label" value="` + label + `">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_min[]" required="required" min="0" step="any" class="form-control" placeholder="Min" value="` + min + `">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_max[]" required="required" min="0" step="any" class="form-control" placeholder="Max" value="` + max + `">
				</div>
				<div class="col-md-2 pr-1">
					<input type="number" name="range_value[]" required="required" min="0" step="any" class="form-control" placeholder="Value" value="` + value + `">
				</div>
				<div class="col-md-1 pr-1">
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		`);
	}

	function add_option_edit(label, value) {
		$('#type-container').append(`
			<div class="row">
				<div class="col-md-5 pr-1">
					<input type="text" name="option_label[]" required="required" class="form-control" placeholder="Label" value="` + label + `">
				</div>
				<div class="col-md-5 pr-1">
					<input type="number" name="option_value[]" required="required" min="0" step="any" class="form-control" placeholder="Value" value="` + value + `">
				</div>
				<div class="col-md-1 pr-1">
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		`);
	}

	function add_subcriteria_edit(key, label, weight) {
		$('#type-container').append(`
			<div>
				<div class="row" id="` + key + `">
					<div class="col-md-3 pr-1">
						<input type="text" name="subcriteria_label[]" required="required" class="form-control" value="` + label + `" placeholder="Label">
					</div>
					<div class="col-md-3 pr-1">
						<input type="text" name="subcriteria_key[]" required="required" class="form-control" value="` + key + `" placeholder="Key">
					</div>
					<div class="col-md-3 pr-1">
						<input type="number" name="subcriteria_weight[]" required="required" min="0" step="any" class="form-control" placeholder="Weight" value="` + weight + `">
						<input type="hidden" value="` + num_sub + `" id="idx-` + num_sub + `"/>
						<input type="hidden" value="` + num_sub + `" id="val-` + num_sub + `"/>
					</div>
					<div class="col-md-2 pr-1">
						<button onclick="add_subcriteria_values(this);" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
						<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
					</div>
				</div>
				<div id="sub-container-subcriteria-` + num_sub + `"></div>
			</div>
		`);
		num_sub++;
	}

	function add_subcriteria_values_edit(id, label, value) {
		let idx = $('#idx-' + id).parent().parent().children().eq(2).children()[1].value;
		let sub = $('#val-' + idx).parent().parent().children().eq(2).children()[2].value;
		$('#val-' + idx).parent().parent().children().eq(2).children().eq(2).val(Number(sub) + 1);

		$('#sub-container-subcriteria-' + idx).append(`
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4 pr-1">
					<input type="text" name="` + idx + `-option_label[]" required="required" class="form-control" placeholder="Label" value="` + label + `">
				</div>
				<div class="col-md-4 pr-1">
					<input type="text" name="` + idx + `-option_value[]" id="` + idx + `-option_key" required="required" class="form-control" placeholder="Value" value="` + value + `">
					<input type="hidden" value="` + sub + `" id="idx-idx-` + sub + `"/>
				</div>
				<div class="col-md-2 pr-1">
					<!-- <button onclick="add_subcriteria_values_values(this, ` + idx + `);" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button> -->
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button></div>
				</div>
				<!-- <div id="sub-value-container-` + idx + `-` + sub + `"></div> -->
			</div>
		`);

	}

	// 3x sub
	function add_subcriteria() {
		$('#type-container').append(`
			<div>
				<div class="row">
					<div class="col-md-3 pr-1">
						<input type="text" name="subcriteria_label[]" required="required" class="form-control" placeholder="Label">
					</div>
					<div class="col-md-3 pr-1">
						<input type="text" name="subcriteria_key[]" required="required" class="form-control" placeholder="Key">
					</div>
					<div class="col-md-3 pr-1">
						<input type="number" name="subcriteria_weight[]" required="required" min="0" step="any" class="form-control" placeholder="Weight">
						<input type="hidden" value="` + num_sub + `" id="idx-` + num_sub + `"/>
						<input type="hidden" value="` + num_sub + `" id="val-` + num_sub + `"/>
					</div>
					<div class="col-md-2 pr-1">
						<button onclick="add_subcriteria_values(this);" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
						<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
					</div>
				</div>
				<div id="sub-container-subcriteria-` + num_sub + `"></div>
			</div>
		`);
		num_sub++;
	}

	// cth: merk_tempat_tidur, ukuran_tempat_tidur
	function add_subcriteria_values(obj) {
		let idx = $(obj).parent().parent().children().eq(2).children()[1].value;
		let sub = $('#val-' + idx).parent().parent().children().eq(2).children()[2].value;
		$('#val-' + idx).parent().parent().children().eq(2).children().eq(2).val(Number(sub) + 1);

		$('#sub-container-subcriteria-' + idx).append(`
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4 pr-1">
					<input type="text" name="` + idx + `-option_label[]" required="required" class="form-control" placeholder="Label">
				</div>
				<div class="col-md-4 pr-1">
					<input type="text" name="` + idx + `-option_value[]" id="` + idx + `-option_key" required="required" class="form-control" placeholder="Value">
					<input type="hidden" value="` + sub + `" id="idx-idx-` + sub + `"/>
				</div>
				<div class="col-md-2 pr-1">
					<!-- <button onclick="add_subcriteria_values_values(this, ` + idx + `);" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button> -->
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button></div>
				</div>
				<!-- <div id="sub-value-container-` + idx + `-` + sub + `"></div> -->
			</div>
		`);

	}

	// cth: Olympic, Napolly
	function add_subcriteria_values_values(obj, idx) {
		let sub = $(obj).parent().parent().children().eq(2).children()[1].value;
		$('#sub-value-container-' + idx + '-' + sub).append(`
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-4 pr-1">
					<input type="text" name="` + idx + `-` + sub + `-sub_label[]" required="required" class="form-control" placeholder="Label">	
				</div>
				<div class="col-md-4 pr-1">
					<input type="number" name="` + idx + `-` + sub + `-sub_value[]" required="required" min="0" step="any" class="form-control" placeholder="Value">
				</div>
				<div class="col-md-1 pr-1">
					<button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		`);
	}
</script>