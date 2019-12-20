<?php 

class DempsterShafer
{
	private $evidences = [];
	private $data = [];

	public function fit($data)
	{
		$this->data = [];
		foreach ($data as $row)
		{
			$rec = [
				'gejala'		=> $row->nama_gejala,
				'belief'		=> $row->belief,
				'plausibility'	=> 1 - $row->belief
			];

			$kode = [];
			foreach ($row->gejala_penyakit as $gejalaPenyakit)
			{
				$kode []= $gejalaPenyakit->penyakit->kode;
			}

			$rec['kode'] = $kode;

			$this->data []= $rec;
		}
	}

	private function fitRow($data)
	{
		return [
			[
				'index'	=> implode(',', $data['kode']),
				'kode'	=> $data['kode'],
				'nilai'	=> $data['belief']
			],
			[
				'index'	=> 'evidence_conflict',
				'kode'	=> null,
				'nilai'	=> $data['plausibility']
			]
		];
	}

	public function predict($data)
	{
		$this->fit($data);

		$this->evidences = $this->fitRow($this->data[0]);
		array_shift($this->data); // deleting first element

		foreach ($this->data as $row)
		{
			$this->calculateNewDensity($row);
		}

		return $this->rank();
	}

	private function calculateNewDensity($data)
	{
		$data = $this->fitRow($data);
		$newEvidences = [];
		$evidenceConflictTotal = 0;
		foreach ($data as $i => $row)
		{
			foreach ($this->evidences as $evidence)
			{
				if ($row['kode'] === null && $evidence['kode'] === null)
				{
					$intersection = [];
				}
				else
				{
					if ($row['kode'] === null)
					{
						$intersection = $evidence['kode'];
					}
					else if ($evidence['kode'] === null)
					{
						$intersection = $row['kode'];
					}
					else
					{
						$intersection = array_intersect($row['kode'], $evidence['kode']);
					}
				}
				
				$nilai = $row['nilai'] * $evidence['nilai'];
				if ($i === 0 && count($intersection) <= 0)
				{
					$evidenceConflictTotal += $nilai;
				}

				$rec = [
					'index'	=> count($intersection) <= 0 ? 'evidence_conflict' : implode(',', $intersection),
					'kode'	=> $intersection,
					'nilai'	=> $nilai
				];

				$newEvidences []= $rec;
			}
		}

		$densities = [];
		foreach ($newEvidences as $evidence)
		{
			if ($evidence['index'] !== 'evidence_conflict')
			{
				if (!isset($densities[$evidence['index']]))
				{
					$densities[$evidence['index']] = [
						'kode'	=> $evidence['kode'],
						'nilai'	=> $evidence['nilai']
					];
				}
				else
				{
					$densities[$evidence['index']]['nilai'] += $evidence['nilai'];
				}
			}
		}

		$evidences = [];
		$valueTotal = 0;
		foreach ($densities as $key => $value)
		{
			$val = $value['nilai'] / (1 - $evidenceConflictTotal);
			$evidences []= [
				'index'	=> $key,
				'kode'	=> $value['kode'],
				'nilai'	=> $val
			];
			$valueTotal += $val;
		}

		$evidences []= [
			'index'	=> 'evidence_conflict',
			'kode'	=> null,
			'nilai'	=> 1 - $valueTotal
		];

		$this->evidences = $evidences;
	}

	private function rank()
	{
		array_pop($this->evidences);
		$val = [];
		foreach ($this->evidences as $evidence) 
		{
			$val []= $evidence['nilai'];
		}
		array_multisort($val, SORT_DESC, $this->evidences);
		return $this->evidences;
	}
}