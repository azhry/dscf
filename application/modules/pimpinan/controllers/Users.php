<?php 

class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'pimpinan';

		$this->_check_privilege([PIMPINAN_PRIVILEGE]);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'pimpinan');
		$this->breadcrumbs->push(1, 'Users', 'pimpinan/users');

		$this->load->model('M_Users');
		$this->data['users'] = M_Users::has('role')
							->where('role_id', 1)
							->orderBy('created_at', 'DESC')
							->get();

		$this->data['title'] 		= 'Users | ' . $this->title;
		$this->data['content']		= 'users';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function applicants()
	{
		$this->breadcrumbs->push(0, 'Home', 'pimpinan');
		$this->breadcrumbs->push(1, 'Users', 'pimpinan/users');
		$this->breadcrumbs->push(2, 'Users', 'pimpinan/users/applicants');

		$this->load->model('M_Users');
		$this->data['users'] = M_Users::with(['data' => function($query) {
			$query->where('status', '>', 0);
		}, 'role'])
							->where('role_id', 3)
							->orderBy('created_at', 'DESC')
							->get();

		$this->data['title'] 		= 'Pelamar | ' . $this->title;
		$this->data['content']		= 'applicants';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);	
	}

	public function approve_create_criteria()
	{
		$this->data['id'] = $this->POST('id');
		if (!isset($this->data['id']))
		{
			echo json_encode([
				'status'	=> 'failed',
				'message'	=> 'Required parameter is missing'
			]);
			exit;
		}

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::find($this->data['id']);
		if (!isset($this->data['user']))
		{
			echo json_encode([
				'status'	=> 'failed',
				'message'	=> 'Data not found'
			]);
			exit;
		}

		$this->data['user']->create_criteria_allowed = $this->data['user']->create_criteria_allowed ? 0 : 1;
		$this->data['user']->save();

		echo json_encode([
			'status'	=> 'success',
			'message'	=> 'Success',
			'data'		=> $this->data['user']->create_criteria_allowed		
		]);
	}

}