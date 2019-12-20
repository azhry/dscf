<?php 

class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'sistem';

		$this->_check_privilege([SYSTEM_PRIVILEGE]);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'sistem');
		$this->breadcrumbs->push(1, 'Users', 'sistem/users');

		$this->load->model('M_Users');
		$this->data['users'] = M_Users::has('role')
							->where('role_id', '!=', 3)
							->orderBy('created_at', 'DESC')
							->get();

		$this->data['title'] 		= 'Users | ' . $this->title;
		$this->data['content']		= 'users';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function create()
	{
		$this->load->model('M_Roles');
		$this->data['roles'] = M_Roles::get();

		if ($this->POST('submit'))
		{
			$this->load->model('M_Users');

			$user = new M_Users();
			$user->username 	= $this->POST('username');
			$user->role_id 		= $this->POST('role_id');

			if (!$user->save())
			{
				$this->flashmsg('Failed to add new user', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->flashmsg('New user added');
			redirect('sistem/users');
		}

		$this->breadcrumbs->push(0, 'Home', 'sistem');
		$this->breadcrumbs->push(1, 'Users', 'sistem/users');
		$this->breadcrumbs->push(2, 'Create', 'sistem/users/create');

		$this->data['title'] 		= 'Create User | ' . $this->title;
		$this->data['content']		= 'create_user';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function update()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::find($this->data['id']);
		$this->check_allowance(!isset($this->data['user']), ['Data not found', 'danger']);

		$this->load->model('M_Roles');
		$this->data['roles'] = M_Roles::get();

		if ($this->POST('submit'))
		{
			$this->data['user']->username 	= $this->POST('username');
			$this->data['user']->role_id 	= $this->POST('role_id');

			$password = $this->POST('password');
			if (isset($password) && !empty($password))
			{
				$rpassword = $this->POST('rpassword');
				if ($password !== $rpassword)
				{
					$this->flashmsg('Failed to edit user. Password and confirm password must be equal', 'danger');
					$this->go_back(-1);
					exit;		
				}

				$this->data['user']->password = md5($password);
			}

			if (!$this->data['user']->save())
			{
				$this->flashmsg('Failed to edit user', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->flashmsg('User updated');
			redirect('sistem/users/update/' . $this->data['id']);
		}

		$this->breadcrumbs->push(0, 'Home', 'sistem');
		$this->breadcrumbs->push(1, 'Users', 'sistem/users');
		$this->breadcrumbs->push(2, 'Create', 'sistem/users/update/' . $this->data['id']);

		$this->data['title'] 		= 'Update User | ' . $this->title;
		$this->data['content']		= 'update_user';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function delete()
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::find($this->data['id']);
		$this->check_allowance(!isset($this->data['user']), ['Data not found', 'danger']);

		M_Users::where('id', $this->data['id'])->delete();
		$this->flashmsg('User deleted');
		redirect('sistem/users');
	}
}