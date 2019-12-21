<?php 

class CertaintyFactor
{
	private $knowledge;

	public function __construct()
	{
		$this->knowledge = [];
	}

	public function setKnowledge($knowledge)
	{
		$this->knowledge = [];
		foreach ($knowledge as $row)
		{
			$k = [];
			foreach ($row->gejala_penyakit as $gp)
			{
				$k [$gp->gejala->nama_gejala]= $gp->gejala->belief;
			}
			$this->knowledge[$row->nama_penyakit] = $k;
		}
	}

	public function calculateDiseaseCertaintyFactor($userCertaintyFactor)
	{
		$diseaseCertaintyFactor = [];
		foreach ($this->knowledge as $k => $v)
		{
			$cf = $this->calculateCertaintyFactor($userCertaintyFactor, $v);
			if ($cf <= 0)
			{
				continue;
			}
			$diseaseCertaintyFactor[$k] = $cf;
		}
		arsort($diseaseCertaintyFactor);
		return $diseaseCertaintyFactor;
	}

	private function calculateCertaintyFactor($userCertaintyFactor, $expertCertaintyFactor)
	{
		$multipliedCertaintyFactor = $this->multiplyCertaintyFactor($userCertaintyFactor, $expertCertaintyFactor);
		$certaintyFactor = 0;
		$i = 0;
		foreach ($multipliedCertaintyFactor as $key => $cf)
		{
			if ($i > 0)
			{
				$cf = $cf * (1 - $certaintyFactor);
			}
			$certaintyFactor += $cf;
			$i++;
		}
		return $certaintyFactor;
	}

	private function multiplyCertaintyFactor($userCertaintyFactor, $expertCertaintyFactor)
	{
		$multipliedCertaintyFactor = [];
		foreach ($expertCertaintyFactor as $key => $value)
		{
			if (!isset($userCertaintyFactor[$key]))
			{
				$multipliedCertaintyFactor[$key] = 0;
			}
			else
			{
				$multipliedCertaintyFactor[$key] = $value * $userCertaintyFactor[$key];
			}
		}
		return $multipliedCertaintyFactor;
	}
}