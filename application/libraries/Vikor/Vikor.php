<?php 

require_once __DIR__ .'/Criteria.php';

class Vikor extends Criteria
{
	private $data;
	private $result;
	private $normalized_result;
	private $normalizer;
	private $weights;
	private $solution = ['positive' => [], 'negative' => []];

	public function __construct($config = NULL, $verbose = false)
	{
		parent::__construct();
		$this->normalizer 	= [];
		$this->weights 		= [];
		if ($config != NULL)
		{
			$this->config = $this->fit_config($config);
		}

		foreach ($this->config as $key => $value)
		{
			$this->weights[$key] = $value['weight'];
		}
	}

	public function fit($data, $exclude_key = [])
	{
		$this->data = $data;
		$this->result = $this->fit_criteria($data, $exclude_key);
		foreach ($this->weights as $key => $value)
		{
			$col_values = array_column($this->result, $key);
			$this->normalizer[$key] = [
				'min' 	=> count($col_values) > 0 ? min($col_values) : 0,
				'max' 	=> count($col_values) > 0 ? max($col_values) : 0,
				'diff'	=> (count($col_values) > 0 ? max($col_values) : 0) - (count($col_values) > 0 ? min($col_values) : 0)
			];
		}
		return $this->result;
	}

	public function normalize($data = [])
	{
		if (count($data) > 0)
		{
			$fit = $data;
		}
		else
		{
			$fit = $this->result;
		}

		$this->normalized_result = array_map(function($row) {
			$result = [];
			foreach ($row as $key => $value)
			{
				// $result[$key] = $this->normalizer[$key]['diff'] === 0 ? 0 : (($value - $this->normalizer[$key]['min']) / $this->normalizer[$key]['diff']);
				$denomonator = $this->solution['positive'][$key] - $this->solution['negative'][$key];
				$result[$key] = $denomonator == 0 ? 0 : ((float)($this->solution['positive'][$key] - $value) / (float)$denomonator);
			}
			return $result;
		}, $fit);
		return $this->normalized_result;
	}

	public function weightings()
	{
		$this->normalize();
		$this->weighted_result = array_map(function($row) {
			$result = [];
			foreach ($row as $key => $value)
			{
				$result[$key] = $value * $this->weights[$key];
			}
			return $result;
		}, $this->normalized_result);
		return $this->weighted_result;
	}

	public function utility_measures($data)
	{
		$result['sum'] 		= $this->sum_rows($data);
		$result['max_sum']	= count($result['sum']) > 0 ? max($result['sum']) : 0;
		$result['min_sum']	= count($result['sum']) > 0 ? min($result['sum']) : 0;

		$result['max'] 		= $this->max_rows($data);
		$result['max_max']	= count($result['max']) > 0 ? max($result['max']) : 0;
		$result['min_max']	= count($result['max']) > 0 ? min($result['max']) : 0;

		return $result;
	}

	public function q_index($utility_measures, $v_value = 0.5)
	{
		$result = [];
		foreach ($utility_measures['sum'] as $i => $v)
		{
			$result []= (0.5 * ($utility_measures['max_sum'] - $utility_measures['min_sum'] == 0 ? 1 : ((float)($v - $utility_measures['min_sum']) / (float)($utility_measures['max_sum'] - $utility_measures['min_sum']))) + (1 - $v_value) * ($utility_measures['max_max'] - $utility_measures['min_max'] == 0 ? 1 : ((float)($utility_measures['max'][$i] - $utility_measures['min_max']) / (float)($utility_measures['max_max'] - $utility_measures['min_max']))));
		}

		return $result;
	}

	private function max_rows($data)
	{
		return array_map(function($row) {
			$row = array_values($row);
			if (count($row) <= 0)
			{
				return 0;
			}
			return max($row);
		}, $data);
	}

	private function sum_rows($data)
	{
		return array_map(function($row) {
			return array_sum(array_values($row));
		}, $data);
	}

	public function rank($raw_data = [], $order = 'DESC', $v_value = 0.5)
	{
		$result = $this->weighted_result;
		$utility_measures = $this->utility_measures($result, $v_value);
		$data = $this->q_index($utility_measures);

		$p_raw_data = [];
		foreach ($raw_data as $row)
		{
			if (count($row->values) > 0)
			{
				$p_raw_data []= $row;
			}
		}

		if (count($raw_data) <= 0)
		{
			$ranked_data = $result;
		}
		else
		{
			$ranked_data = $p_raw_data;
		}

		array_multisort($data, $order === 'DESC' ? SORT_DESC : SORT_ASC, $ranked_data);
		for ($i = 0; $i < count($ranked_data); $i++)
		{
			$ranked_data[$i]['total'] = $data[$i];
		}
		return $ranked_data;
	}

	public function solution_matrix($matrix)
	{
		$this->solution = ['positive' => [], 'negative' => []];
		foreach ($this->weights as $key => $value)
		{
			$col = array_column($matrix, $key);
			$len_col = count($col);
			$this->solution['positive'][$key] = $len_col > 0 ? (($this->config[$key]['category'] === 'Cost') ? min($col) : max($col)) : 0;
			$this->solution['negative'][$key] = $len_col > 0 ? (($this->config[$key]['category'] === 'Cost') ? max($col) : min($col)) : 0;
		}
		return $this->solution;
	}
}