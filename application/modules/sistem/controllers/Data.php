<?php 

class Data extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'admin';

		$this->_check_privilege([SYSTEM_PRIVILEGE]);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Data', 'admin/data');

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] = M_Data::with(['values', 'values.criteria'])
							->orderBy('created_at', 'DESC')
							->get();

		$this->data['criteria']		= M_Criteria::get();
		$this->data['title'] 		= 'Data | ' . $this->title;
		$this->data['content']		= 'data';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function change_status()
	{
		$this->data['data_id'] = $this->POST('data_id');
		$this->load->model('M_Data');

		$this->data['data'] = M_Data::find($this->data['data_id']);
		if (!isset($this->data['data']))
		{
			echo json_encode([
				'message' => 'Not Found'
			]);
			exit;
		}

		$this->data['data']->status = $this->POST('status');
		$this->data['data']->save();

		$this->load->model('M_Users');
		$user = M_Users::where('id', $this->data['data']->user_id)->first();

		// TODO: send email
		$this->load->library('CI_PHPMailer/ci_phpmailer');
		try 
		{
			$status = $this->POST('status');
			if ($status == 1)
			{
				$link = base_url('login');
				$content = 'Selamat, anda lulus tahap administrasi. Silahkan login pada ' . '<a href="' . $link . '">' . $link . '</a>';	
			}
			else
			{
				$content = 'Mohon maaf, anda tidak lulus tahap administrasi. Tetap semangat ya';
			}

			$this->ci_phpmailer->setServer('smtp.gmail.com');
			$this->ci_phpmailer->setAuth('sofitafita123@gmail.com', 'sofita123');
			$this->ci_phpmailer->setAlias('no-reply@spk-vikor.com', 'SPK Vikor');
			$this->ci_phpmailer->sendMessage($user->username, 'Pengumuman Kelulusan', $content);
			$response = [
				'message'	=> 'Success',
				'status'	=> $this->POST('status')
			];
		}
		catch (Exception $e)
		{
			$response = [
				'message'	=> 'Failed',
				'status'	=> $this->POST('status')
			];
			$this->ci_phpmailer->displayError();
		}

		echo json_encode($response);
	}

	public function create()
	{
		$this->load->model('M_Criteria');
		$this->data['criteria'] = M_Criteria::get();

		if ($this->POST('submit'))
		{
			$this->load->model('M_Data');
			$this->load->model('M_DataValue');

			M_Data::getConnectionResolver()->connection()->beginTransaction();
			
			$data = new M_Data();
			$data->name = $this->POST('name');
			$data->birthdate 	= $this->POST('birthdate');
			$data->birthplace 	= $this->POST('birthplace');

			$elementary = $this->POST('elementary');
			$junior 	= $this->POST('junior');
			$senior 	= $this->POST('senior');
			$university = $this->POST('university');

			$data->educational_background = json_encode([
				'elementary'	=> $elementary,
				'junior'		=> $junior,
				'senior'		=> $senior,
				'university'	=> $university
			]);
			$data->address 	= $this->POST('address');
			$data->hobby 	= $this->POST('hobby');
			$data->reason 	= $this->POST('reason');

			if (!$data->save())
			{
				M_Data::getConnectionResolver()->connection()->rollback();
				$this->flashmsg('Failed to add new data', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->upload($data->id, 'assets/img', 'image');

			// foreach ($this->data['criteria'] as $criteria)
			// {
			// 	$value 				= new M_DataValue();
			// 	$value->criteria_id = $criteria->id;
			// 	$value->data_id 	= $data->id;
			// 	if ($criteria->type == 'criteria')
			// 	{
			// 		$detail_value = [];
			// 		$details = json_decode($criteria->details);
			// 		foreach ($details as $detail)
			// 		{
			// 			$detail_value[$detail->key] = $this->POST($detail->key);
			// 		}

			// 		$value->value = json_encode($detail_value);
			// 	}
			// 	else
			// 	{
			// 		$value->value = $this->POST($criteria->key);
			// 	}

			// 	if (!$value->save())
			// 	{
			// 		M_Data::getConnectionResolver()->connection()->rollback();
			// 		$this->flashmsg('Failed to add new data', 'danger');
			// 		$this->go_back(-1);
			// 		exit;
			// 	}
			// }

			M_Data::getConnectionResolver()->connection()->commit();
			$this->flashmsg('New data added');
			redirect('admin/data');
		}

		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Data', 'admin/data');
		$this->breadcrumbs->push(2, 'Create', 'admin/data/create');

		$this->load->helper('dynamic_form');

		$this->data['title'] 		= 'Create Data | ' . $this->title;
		$this->data['content']		= 'create_data';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function update()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Data');
		$this->load->model('M_Criteria');
		$this->data['data'] = M_Data::with(['values', 'values.criteria'])
							->orderBy('created_at', 'DESC')
							->find($this->data['id']);
		$this->check_allowance(!isset($this->data['data']), ['Data not found', 'danger']);

		$this->data['criteria'] = M_Criteria::get();

		if ($this->POST('submit'))
		{
			M_Data::getConnectionResolver()->connection()->beginTransaction();
			
			$data = $this->data['data'];
			$data->name 		= $this->POST('name');
			$data->birthdate 	= $this->POST('birthdate');
			$data->birthplace 	= $this->POST('birthplace');

			$elementary = $this->POST('elementary');
			$junior 	= $this->POST('junior');
			$senior 	= $this->POST('senior');
			$university = $this->POST('university');

			$data->educational_background = json_encode([
				'elementary'	=> $elementary,
				'junior'		=> $junior,
				'senior'		=> $senior,
				'university'	=> $university
			]);
			$data->address 	= $this->POST('address');
			$data->hobby 	= $this->POST('hobby');
			$data->reason 	= $this->POST('reason');
			
			if (!$data->save())
			{
				M_Data::getConnectionResolver()->connection()->rollback();
				$this->flashmsg('Failed to update data', 'danger');
				$this->go_back(-1);
				exit;
			}

			if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
			{
				$this->upload($data->id, 'assets/img', 'image');
			}
			

			// M_DataValue::where('data_id', $this->data['id'])->delete();

			// foreach ($this->data['criteria'] as $criteria)
			// {
			// 	$value 				= new M_DataValue();
			// 	$value->criteria_id = $criteria->id;
			// 	$value->data_id 	= $data->id;
			// 	if ($criteria->key === 'C5')
			// 	{
			// 		$month 	= $this->POST('bulan');
			// 		$year 	= $this->POST('tahun');
			// 		$experience = $year + ((float)$month / 12.0);
			// 		$value->value = $experience;
			// 	}
			// 	else
			// 	{
			// 		$value->value = $this->POST($criteria->key);
			// 	}

			// 	if (!$value->save())
			// 	{
			// 		M_Data::getConnectionResolver()->connection()->rollback();
			// 		$this->flashmsg('Failed to add new data', 'danger');
			// 		$this->go_back(-1);
			// 		exit;
			// 	}
			// }

			M_Data::getConnectionResolver()->connection()->commit();
			$this->flashmsg('Data updated');
			redirect('admin/data/update/' . $this->data['id']);
		}

		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Data', 'admin/data');
		$this->breadcrumbs->push(2, 'Update', 'admin/data/update/' . $this->data['id']);

		$this->load->helper('dynamic_form_helper');

		$this->data['educational_background'] = [];
		if (!empty($this->data['data']->educational_background))
		{
			$this->data['educational_background'] = json_decode($this->data['data']->educational_background, true);
		}

		$this->data['title'] 		= 'Update Data | ' . $this->title;
		$this->data['content']		= 'update_data';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function delete()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Data');
		$this->data['data'] = M_Data::with(['values', 'values.criteria'])
		->orderBy('created_at', 'DESC')
		->find($this->data['id']);
		$this->check_allowance(!isset($this->data['data']), ['Data not found', 'danger']);

		M_Data::where('id', $this->data['id'])->delete();
		$this->flashmsg('Data deleted');
		redirect('admin/data');
	}

	public function detail()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Data');
		$this->load->model('M_Criteria');
		$this->data['data'] = M_Data::with(['values', 'values.criteria'])
							->orderBy('created_at', 'DESC')
							->find($this->data['id']);
		$this->check_allowance(!isset($this->data['data']), ['Data not found', 'danger']);

		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Data', 'admin/data');
		$this->breadcrumbs->push(2, 'Detail', 'admin/data/detail/' . $this->data['id']);

		$this->data['educational_background'] = [];
		if (!empty($this->data['data']->educational_background))
		{
			$this->data['educational_background'] = json_decode($this->data['data']->educational_background, true);
		}

		$this->data['ed_map'] = [
			'elementary'	=> 'SD',
			'junior'		=> 'SMP',
			'senior'		=> 'SMA',
			'university'	=> 'Universitas'
		];

		$this->data['title'] 		= 'Detail Data | ' . $this->title;
		$this->data['content']		= 'detail_data';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function report()
	{
		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->breadcrumbs->push(1, 'Data', 'admin/data');
		$this->breadcrumbs->push(2, 'Report', 'admin/data/report');

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 2)
								->orderBy('created_at', 'DESC')
								->get();
		$this->data['criteria']	= M_Criteria::get();

		require_once APPPATH . '/libraries/Vikor/Vikor.php';
		$vikor = new Vikor($this->data['criteria']);

		$this->data['fit_data'] 			= $vikor->fit_data($this->data['data'], ['id', 'user_id', 'name', 'birthdate', 'birthplace', 'educational_background', 'address', 'hobby', 'reason', 'created_at', 'updated_at', 'deleted_at', 'status', 'submitted']);
		$this->data['converted'] 			= $vikor->fit($this->data['fit_data']);
		$this->data['solution_matrix'] 		= $vikor->solution_matrix($this->data['converted']);
		$this->data['normalized']			= $vikor->normalize();
		$this->data['weighted']				= $vikor->weightings();
		$this->data['utility_measures']		= $vikor->utility_measures($this->data['weighted']);
		$this->data['q_index']				= $vikor->q_index($this->data['utility_measures']);
		$this->data['ranked']				= $vikor->rank($this->data['data'], 'ASC');
		$this->data['compromise_solution']	= [
			'condition_1'	=> [
				'DQ'	=> count($this->data['ranked']) - 1 == 0 ? 0 : (1 / (count($this->data['ranked']) - 1)),
				'QA'	=> (count($this->data['ranked']) > 0 ? count($this->data['ranked']) <= 1 ? $this->data['ranked'][0]['total'] : ($this->data['ranked'][1]['total'] - $this->data['ranked'][0]['total']) : 0)
			],
			'condition_2'	=> [
				'v_1'	=> $vikor->rank($this->data['data'], 'ASC', 0.45),
				'v_2'	=> $vikor->rank($this->data['data'], 'ASC', 0.55)
			]
		];
		
		$this->data['condition_1_fulfilled'] = ($this->data['compromise_solution']['condition_1']['QA'] >= $this->data['compromise_solution']['condition_1']['DQ']);
		if (count($this->data['ranked']) > 0)
		{
			$this->data['condition_2_fulfilled'] = ($this->data['ranked'][0]['name'] === $this->data['compromise_solution']['condition_2']['v_1'][0]['name'] && $this->data['compromise_solution']['condition_2']['v_1'][0]['name'] === $this->data['compromise_solution']['condition_2']['v_2'][0]['name']);
		}
		else
		{
			$this->data['condition_2_fulfilled'] = false;
		}
		

		// $this->dump($this->data['compromise_solution'], 1);

		$this->data['title'] 		= 'Report | ' . $this->title;
		$this->data['content']		= 'report';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function download_report()
	{
		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 1)
								->orderBy('created_at', 'DESC')
								->get();
		$this->data['criteria']	= M_Criteria::get();

		require_once APPPATH . '/libraries/Vikor/Vikor.php';
		$vikor = new Vikor($this->data['criteria']);

		$this->data['fit_data'] 			= $vikor->fit_data($this->data['data'], ['id', 'user_id', 'name', 'birthdate', 'birthplace', 'educational_background', 'address', 'hobby', 'reason', 'created_at', 'updated_at', 'deleted_at', ]);
		$this->data['converted'] 			= $vikor->fit($this->data['fit_data']);
		$this->data['solution_matrix'] 		= $vikor->solution_matrix($this->data['converted']);
		$this->data['normalized']			= $vikor->normalize();
		$this->data['weighted']				= $vikor->weightings();
		$this->data['utility_measures']		= $vikor->utility_measures($this->data['weighted']);
		$this->data['q_index']				= $vikor->q_index($this->data['utility_measures']);
		$this->data['ranked']				= $vikor->rank($this->data['data'], 'ASC');
		$this->data['compromise_solution']	= [
			'condition_1'	=> [
				'DQ'	=> count($this->data['ranked']) - 1 == 0 ? 0 : (1 / (count($this->data['ranked']) - 1)),
				'QA'	=> count($this->data['ranked']) <= 1 ? $this->data['ranked'][0]['total'] : ($this->data['ranked'][1]['total'] - $this->data['ranked'][0]['total'])
			],
			'condition_2'	=> [
				'v_1'	=> $vikor->rank($this->data['data'], 'ASC', 0.45),
				'v_2'	=> $vikor->rank($this->data['data'], 'ASC', 0.55)
			]
		];
		
		$this->data['condition_1_fulfilled'] = ($this->data['compromise_solution']['condition_1']['QA'] >= $this->data['compromise_solution']['condition_1']['DQ']);
		$this->data['condition_2_fulfilled'] = ($this->data['ranked'][0]['name'] === $this->data['compromise_solution']['condition_2']['v_1'][0]['name'] && $this->data['compromise_solution']['condition_2']['v_1'][0]['name'] === $this->data['compromise_solution']['condition_2']['v_2'][0]['name']);
		
		$html = $this->load->view('print_report', $this->data, true);
    	$pdfFilePath = 'Report - ' . date('Y-m-d') . '.pdf';
    	$this->load->library('m_pdf');
    	$this->m_pdf->pdf->WriteHTML($html);
    	$this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}
}