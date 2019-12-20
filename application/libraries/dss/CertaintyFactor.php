<?php 

class CertaintyFactor
{
	public function calculateDiseaseCertaintyFactor($userCertaintyFactor)
	{
		$diseaseCertaintyFactor = [];
		foreach ($userCertaintyFactor as $cf)
		{
			// TODO
		}
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