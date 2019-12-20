<?php 

class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'pimpinan';
		$this->data['user'] = $this->session->userdata(USER_INFO_KEY);

		$this->_check_privilege([PIMPINAN_PRIVILEGE]);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'pimpinan/main');

		$this->load->model('M_Settings');
		$this->data['settings'] = M_Settings::find(1);

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 1)
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

		$this->data['title'] 		= 'Dashboard Pimpinan | ' . $this->title;
		$this->data['content']		= 'dashboard';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function change_settings()
	{
		$this->load->model('M_Settings');
		$settings = M_Settings::find(1);
		$settings->value = $settings->value == 1 ? 0 : 1;
		$settings->save();

		$response = [
			'status'	=> 'success',
			'value'		=> $settings->value
		];

		echo json_encode($response);
	}

	public function diagram()
	{
		$this->breadcrumbs->push(0, 'Home', 'pimpinan/main');

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 1)
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

		$this->data['title'] 		= 'Dashboard Pimpinan | ' . $this->title;
		$this->data['content']		= 'diagram';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function real_values()
	{
		$this->breadcrumbs->push(0, 'Home', 'pimpinan/main');

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 1)
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

		$this->data['title'] 		= 'Dashboard Pimpinan | ' . $this->title;
		$this->data['content']		= 'real_values';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
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

		$this->breadcrumbs->push(0, 'Home', 'pimpinan');
		$this->breadcrumbs->push(1, 'Detail', 'pimpinan/data/detail/' . $this->data['id']);

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
		
		$html = $this->load->view('print_report', $this->data, true);
    	$pdfFilePath = 'Report - ' . date('Y-m-d') . '.pdf';
    	$this->load->library('m_pdf');
    	$this->m_pdf->pdf->WriteHTML($html);
    	$this->m_pdf->pdf->Output($pdfFilePath, "D");	
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
			if ($status == 3)
			{
				$link = base_url('login');
				$content = 'Selamat, anda lulus rekrutmen TVRI. Silahkan login pada ' . '<a href="' . $link . '">' . $link . '</a>';	
			}
			else
			{
				$content = 'Mohon maaf, anda tidak lulus. Tetap semangat ya';
			}

			$this->ci_phpmailer->setServer('smtp.gmail.com');
			$this->ci_phpmailer->setAuth('tvriplg@gmail.com', 'tvripalembang');
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
}