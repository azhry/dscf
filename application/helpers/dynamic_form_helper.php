<?php 

function generate_form($config, $data = null) 
{
	$html = '';
	$index = 0;
	foreach ($config as $row)
	{
		$html .= '<div class="row">';
		$html .= '<div class="col-md-12">';
		$html .= '<div class="form-group">';
		$html .= '<label>' . $row->title . '</label>';

		if (is_string($row->details))
		{
			$details = json_decode($row->details);
			$data->values = $data->toArray();
			$data->values = $data->values['values'];
		}
		else
		{
			$details = $row->details;
		}
		switch ($row->type)
		{
			case 'option':
				$html .= '<select class="form-control" required name="' . $row->key . '">';
				$html .= '<option value="">Choose ' . $row->title . '</option>';
				foreach ($details as $detail)
				{
					if (isset($data) && count($data->values) > 0 && is_array($data->values[$index]))
					{
						$html .= '<option value="' . $detail->label . '" ' . ((isset($data) && count($data->values) > 0 && $data->values[$index]['value'] === $detail->label) ? 'selected' : '') . '>' . $detail->label . '</option>';
					}
					else
					{
						$html .= '<option value="' . $detail->label . '" ' . ((isset($data) && count($data->values) > 0 && $data->values[$index]['value'] === $detail->label) ? 'selected' : '') . '>' . $detail->label . '</option>';
					}
					
				}
				$html .= '</select>';
				break;

			case 'range':
				if (isset($data) && count($data->values) > 0 && $index < count($data->values) && is_array($data->values[$index]))
				{
					$html .= '<input type="number" name="' . $row->key . '" step="any" class="form-control" value="' . (isset($data) && count($data->values) > 0 ? $data->values[$index]['value'] : '') . '">';
				}
				else
				{
					$html .= '<input type="number" name="' . $row->key . '" step="any" class="form-control" value="' . (isset($data) && count($data->values) > 0 && $index < count($data->values) ? $data->values[$index]->value : '') . '">';
				}
				
				break;

			case 'criteria':
				if (isset($data))
				{
					if (isset($data) && count($data->values) > 0 && is_array($data->values[$index]))
					{
						$xdata = json_decode($data->values[$index]['value']);
						if ($xdata == null)
						{
							$xdata = (object)[];
						}
						$xdata->values = [];
						foreach ($xdata as $k => $v)
						{
							$xdata->values []= [
								'value'	=> $v
							];
						}
						$html .= generate_form($details, $xdata);
					}
					else
					{
						if (count($data->values) > 0)
						{
							$html .= generate_form($details, json_decode($data->values[$index]->value));
						}
						else
						{
							$html .= generate_form($details);
						}
					}
					
				}
				else
				{
					$html .= generate_form($details);
				}
				
				break;
		}

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		$index++;
	}

	return $html;

} 