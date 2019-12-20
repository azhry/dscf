<?php 
/**
* Class for mapping criteria based on configuration.
*
* @package    Vikor
* @author     Azhary Arliansyah
* @version    1.0
*/

require_once(__DIR__ . '/Config.php');

class Criteria
{
	protected $config;

	public function __construct()
	{
		$this->config = Config::$config;
	}

	public function set_config($config)
	{
		$this->config = $config;
	}

	public function get_config()
	{
		return $this->config;
	}

	

	public function fit_criteria($data, $exclude_key = [])
	{
		$result = [];
		foreach ($data as $row)
		{
			$result_row = [];
			foreach ($row as $key => $value)
			{
				if (!in_array($key, $exclude_key))
				{
					$result_row[$key] = $this->feature_map($key, $value);
				}
			}
			$result []= $result_row;
		}
		return $result;
	}

	public function fit_data($data, $exclude_key = [], $custom_opts = [])
	{
		$result = [];
		$keys = array_keys($custom_opts);
		foreach ($data as $row)
		{
			$result_row = [];
			$row = (object)$row->toArray();

			foreach ($row as $key => $value)
			{
				if (!in_array($key, $exclude_key))
				{
					foreach ($value as $k => $v)
					{
						if (in_array($v['criteria']['key'], $keys))
						{
							$result_row[$v['criteria']['key']] = $custom_opts[$v['criteria']['key']]($v['value']);
						}
						else
						{
							$result_row[$v['criteria']['key']] = $v['value'];
						}
						
					}
				}
			}

			if (count($result_row) <= 0)
			{
				continue;
			}
			
			$result []= $result_row;
		}
		return $result;
	}

	protected function fit_config($config)
	{
		$result = [];
		foreach ($config as $row)
		{
			$result[$row->key] = [
				'key'		=> $row->key,
				'weight'	=> $row->weight,
				'label'		=> $row->title,
				'type'		=> $row->type,
				'category'	=> $row->category,
				'values'	=> []
			];

			$details = json_decode($row->details);
			foreach ($details as $detail)
			{
				switch ($row->type)
				{
					case 'option':
						$result[$row->key]['values'] []= [
							'label'	=> $detail->label,
							'value'	=> $detail->value
						];
						break;

					case 'range':
						$result[$row->key]['values'] []= [
							'label'	=> $detail->label,
							'min'	=> $detail->min,
							'max'	=> $detail->max,
							'value'	=> $detail->value
						];
						break;

					case 'criteria':
						$cdetails = [];
						foreach ($detail->details as $d)
						{
							$cdetails []= [
								'label'	=> $d->label,
								'value'	=> $d->value
							];
						}

						$result[$row->key]['values'] []= [
							'title'		=> $detail->title,
							'key'		=> $detail->key,
							'weight'	=> $detail->weight,
							'type'		=> $detail->type,
							'details'	=> $cdetails
						];
						break;
				}
				
			}
		}
		return $result;
	}

	private function feature_map($key, $value)
	{
		switch ($this->config[$key]['type'])
		{
			case 'range':
				foreach ($this->config[$key]['values'] as $opt)
				{
					if ($opt['min'] === null)
					{
						if ($value <= $opt['max'])
						{
							return $opt['value'];
						}
					}
					elseif ($opt['max'] === null) 
					{
						if ($value >= $opt['min'])
						{
							return $opt['value'];
						}
					}
					else
					{
						if ($value >= $opt['min'] && $value <= $opt['max'])
						{
							return $opt['value'];
						}
					}
				}
				break;

			case 'option':
				$possible_values = [];
				$cvalue = json_decode($value);
				foreach ($this->config[$key]['values'] as $opt)
				{
					if (is_array($cvalue))
					{
						foreach ($cvalue as $v)
						{
							if ($v === $opt['label'])
							{
								$possible_values []= $opt['value'];
							}
						}
					}
					elseif (!is_array($cvalue) && $value === $opt['label'])
					{
						return $opt['value'];
					}
				}
				$len = count($possible_values);
				if ($len == 0) return 0;
				else if ($len == 1) return $possible_values[0];	
				return max($possible_values);

			case 'criteria':
				$result = 0;
				$cvalue = json_decode($value);
				foreach ($this->config[$key]['values'] as $opt)
				{
					foreach ($cvalue as $k => $v)
					{
						if ($k === $opt['key'])
						{
							foreach ($opt['details'] as $cdetail)
							{
								if ($cdetail['label'] === $v)
								{
									$result += $opt['weight'] * $cdetail['value'];
									break;
								}
							}
						}
					}
				}
				return $result;
		}
		
		return null;
	}
}