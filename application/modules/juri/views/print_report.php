<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#bigWrapper{
			width: 100%;
		}
		.header{
			text-align: center;
			font-size: 26px;
			margin-bottom: 50px;
			border-bottom: 5px double black;
			padding-bottom: 15px;
		}
		#logoo{
			margin-top: -200px;
			width: 130px;
			height: 200px;
			margin-left: 10px;
			margin-right: 60px;	
		}
		#logoo img{
			width: 130px;
			height: 80px;
		}
		.title{
			margin-left: 50px;
			margin-top: -190px;
		}
		.kontak{
			margin-top: 5px;
			font-size: 12px;
			text-align: center;
		}
		table,th,td{
			border: 1px solid black;
		}
		table {
			border-collapse: collapse;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2
		}
		tr:first-child{
			width: 40px;
		}
		th{
			background-color: #4CAF50;
			color: white;
			/*min-width: 100px;*/
		}
		td{
			padding: 2px;
			padding-left: 10px; 
			text-align: center;
		}
	</style>
</head>
<body>
	<div id="bigWrapper">
		<div class="header">
			<div id="logoo">
				<img src="<?= base_url('assets/logo.png') ?>">
			</div>

			<div class="title">
				<strong>
					STASIUN TVRI <br>
					KOTA PALEMBANG
				</strong>
				<div class="kontak">
					Jl. POM IX, Lorok Pakjo, Kec. Ilir Barat<br> 
					Kota Palembang, Sumatera Selatan<br>
				</div>
			</div>
		</div>
		<div class="content" style="margin: 0 auto; width:100%;">
			<p style="margin-top: -30px; width: 100%; font-weight: bold; font-size: 22px; text-align: center; margin-bottom: 30px;">Laporan Daftar Pelamar</p>
			<table style="width: 100%;">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Tempat/Tanggal Lahir</th>
						<th>Riwayat Pendidikan</th>
						<th>Alamat</th>
						<th>Hobi</th>
						<th>Alasan Mengikuti Rekrutmen Presenter</th>
						<?php foreach ($criteria as $row): ?>
							<th><?= $row->title ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $i => $row): ?>
						<tr>
							<td><?= $i + 1 ?></td>
							<td><?= $row->name ?></td>
							<td><?= $row->birthplace . '/' . $row->birthdate ?></td>
							<td>
								<ul>
									<?php  
									if (!empty($row->educational_background))
									{
										$background = json_decode($row->educational_background);
										foreach ($background as $k => $b)
										{
											if (!isset($b) or empty($b))
											{
												continue;
											}
											echo '<li>' . $b . '</li>';
										}
									}
									?>	
								</ul>
							</td>
							<td><?= $row->address ?></td>
							<td><?= $row->hobby ?></td>
							<td><?= $row->reason ?></td>
							<?php foreach ($row->values as $value): ?>
								<td>
									<?php  
									$details = json_decode($value->criteria->details);
									$label = '-';

									$break = false;
									foreach ($details as $detail)
									{
										switch ($value->criteria->type)
										{
											case 'option':
											if ($detail->label == $value->value)
											{
												$label = $value->value;
												$break = true;
											}
											break;

											case 'range':
											$label = $value->value;
											$break = true;
											break;

											case 'criteria':
											$label = '<ul>';
											$values = json_decode($value->value);
											foreach ($values as $k => $v)
											{
												$label .= '<li>' . $v . '</li>';
											}
											$label .= '</ul>';

											$break = true;
											break;
										}

										if ($break)
										{
											break;
										}
									}


									echo $label;
									?>
								</td>
							<?php endforeach; ?>
							<?php if (count($row->values) <= 0): ?>
								<?php foreach ($criteria as $x): ?>
									<td>-</td>
								<?php endforeach; ?>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>