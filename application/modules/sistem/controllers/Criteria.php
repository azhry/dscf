<?php 

class Criteria extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'admin';

		$this->_check_privilege([SYSTEM_PRIVILEGE]);

		$this->data['user'] = $this->session->userdata(USER_INFO_KEY);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Criteria', 'admin/criteria');

		$this->load->model('M_Criteria');

		$this->data['criteria']		= M_Criteria::get();
		$this->data['title'] 		= 'Criteria | ' . $this->title;
		$this->data['content']		= 'criteria';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function create()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('M_Criteria');
			$type = $this->POST('type');
			$details = [];

			switch ($type)
			{
				case 'range':
					$rangeLabel = $this->POST('range_label');
					$rangeMax 	= $this->POST('range_max');
					$rangeMin 	= $this->POST('range_min');
					$rangeValue = $this->POST('range_value');
					
					for ($i = 0; $i < count($rangeLabel); $i++)
					{
						$details []= [
							'label'	=> $rangeLabel[$i],
							'max'	=> $rangeMax[$i],
							'min'	=> $rangeMin[$i],
							'value'	=> $rangeValue[$i]
						];
					}

					break;

				case 'option':
					$optionLabel = $this->POST('option_label');
					$optionValue = $this->POST('option_value');

					for ($i = 0; $i < count($optionLabel); $i++)
					{
						$details []= [
							'label'	=> $optionLabel[$i],
							'value'	=> $optionValue[$i]
						];
					}

					break;

				case 'criteria':
					$subcriteriaLabel 	= $this->POST('subcriteria_label');
					$subcriteriaKey 	= $this->POST('subcriteria_key');
					$subcriteriaWeight 	= $this->POST('subcriteria_weight');
					$subNum 			= count($subcriteriaLabel);

					for ($i = 0; $i < $subNum; $i++)
					{
						$optionLabel 	= $this->POST($i . '-option_label');
						$optionValue 	= $this->POST($i . '-option_value');

						$values = [];
						$sNum = count($optionLabel);
						for ($j = 0; $j < $sNum; $j++)
						{
							$values []= [
								'label'	=> $optionLabel[$j],
								'value'	=> $optionValue[$j]
							];	
						}

						

						$details []= [
							'title'		=> $subcriteriaLabel[$i],
							'key'		=> $subcriteriaKey[$i],
							'weight'	=> $subcriteriaWeight[$i],
							'type'		=> 'option',
							'details'	=> $values
						];
					}

					

					break;

				default:
					$this->flashmsg('Wrong type', 'danger');
					$this->go_back(-1);
					exit;
			}

			$criteria = new M_Criteria();
			$criteria->title 		= $this->POST('title');
			$criteria->description 	= $this->POST('description');
			$criteria->weight 		= $this->POST('weight');
			$criteria->key 			= $this->POST('key');
			$criteria->type 		= $this->POST('type');
			$criteria->category 	= $this->POST('category');
			$criteria->details 		= json_encode($details);
		
			if (!$criteria->save())
			{
				$this->flashmsg('Failed to save criteria', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->load->model('M_Users');
			$user = M_Users::find($this->data['user']->id);
			$user->create_criteria_allowed = 0;
			$user->save();

			$this->flashmsg('Criteria successfully saved');
			redirect('admin/criteria');
		}

		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Criteria', 'admin/criteria');
		$this->breadcrumbs->push(2, 'Add New Criteria', 'admin/criteria/create');

		$this->data['title'] 		= 'Create Criteria | ' . $this->title;
		$this->data['content']		= 'create_criteria';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function update()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Criteria');
		$this->data['criteria'] = M_Criteria::find($this->data['id']);
		$this->check_allowance(!isset($this->data['criteria']), ['Data not found', 'danger']);

		// $this->dump(json_decode($this->data['criteria']->details), 1);

		if ($this->POST('submit'))
		{
			$this->load->model('M_Criteria');
			$type = $this->POST('type');
			$details = [];

			switch ($type)
			{
				case 'range':
					$rangeLabel = $this->POST('range_label');
					$rangeMax 	= $this->POST('range_max');
					$rangeMin 	= $this->POST('range_min');
					$rangeValue = $this->POST('range_value');
					
					for ($i = 0; $i < count($rangeLabel); $i++)
					{
						if (empty($rangeLabel[$i]))
						{
							continue;
						}

						$details []= [
							'label'	=> $rangeLabel[$i],
							'max'	=> $rangeMax[$i],
							'min'	=> $rangeMin[$i],
							'value'	=> $rangeValue[$i]
						];
					}

					break;

				case 'option':
					$optionLabel = $this->POST('option_label');
					$optionValue = $this->POST('option_value');

					for ($i = 0; $i < count($optionLabel); $i++)
					{
						if (empty($optionLabel[$i]))
						{
							continue;
						}

						$details []= [
							'label'	=> $optionLabel[$i],
							'value'	=> $optionValue[$i]
						];
					}

					break;

				case 'criteria':
					$subcriteriaLabel 	= $this->POST('subcriteria_label');
					$subcriteriaKey 	= $this->POST('subcriteria_key');
					$subcriteriaWeight 	= $this->POST('subcriteria_weight');
					$subNum 			= count($subcriteriaLabel);

					for ($i = 0; $i < $subNum; $i++)
					{
						$optionLabel 	= $this->POST($i . '-option_label');
						$optionValue 	= $this->POST($i . '-option_value');

						$values = [];
						$sNum = count($optionLabel);
						for ($j = 0; $j < $sNum; $j++)
						{
							$values []= [
								'label'	=> $optionLabel[$j],
								'value'	=> $optionValue[$j]
							];	
						}

						

						$details []= [
							'title'		=> $subcriteriaLabel[$i],
							'key'		=> $subcriteriaKey[$i],
							'weight'	=> $subcriteriaWeight[$i],
							'type'		=> 'option',
							'details'	=> $values
						];
					}

					

					break;

				default:
					$this->flashmsg('Wrong type', 'danger');
					$this->go_back(-1);
					exit;
			}

			$this->data['criteria']->title 			= $this->POST('title');
			$this->data['criteria']->description 	= $this->POST('description');
			$this->data['criteria']->weight 		= $this->POST('weight');
			$this->data['criteria']->key 			= $this->POST('key');
			$this->data['criteria']->type 			= $this->POST('type');
			$this->data['criteria']->category 		= $this->POST('category');
			$this->data['criteria']->details 		= json_encode($details);

			if (!$this->data['criteria']->save())
			{
				$this->flashmsg('Failed to update criteria', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->flashmsg('Criteria successfully updated');
			redirect('admin/criteria/update/' . $this->data['id']);
		}

		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Criteria', 'admin/criteria');
		$this->breadcrumbs->push(2, 'Update New Criteria', 'admin/criteria/update/' . $this->data['id']);

		$this->data['title'] 		= 'Update Criteria | ' . $this->title;
		$this->data['content']		= 'update_criteria';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function delete()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Criteria');
		$this->data['criteria'] = M_Criteria::find($this->data['id']);
		$this->check_allowance(!isset($this->data['criteria']), ['Data not found', 'danger']);

		M_Criteria::where('id', $this->data['id'])->delete();
		$this->flashmsg('Criteria deleted');
		redirect('admin/criteria');
	}
}