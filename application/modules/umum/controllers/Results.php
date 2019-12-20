<?php 

class Results extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('M_Settings');
		$this->data['settings'] = M_Settings::find(1);

		if ($this->data['settings'] && $this->data['settings']->value != 1)
		{
			redirect('login');
		}

		$this->load->model('M_Criteria');
		$this->load->model('M_Data');
		$this->data['data'] 	= M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 3)
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
		
		$this->load->view('results', $this->data);
	}
}