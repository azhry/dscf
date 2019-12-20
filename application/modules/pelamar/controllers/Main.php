<?php 

class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'pelamar';
		$this->data['user'] = $this->session->userdata(USER_INFO_KEY);
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'pelamar/main');
		$this->data['title'] 		= 'Dashboard Pelamar | ' . $this->title;
		$this->data['content']		= 'dashboard';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function announcement()
	{
		$this->load->model('M_Data');
		$this->load->model('M_Criteria');

		$this->data['criteria']		= M_Criteria::get();
		$this->data['user_data'] 	= M_Data::with(['values', 'values.criteria'])
										->where('user_id', $this->data['user']->id)
										->first();
		$this->data['data'] = M_Data::with(['values', 'values.criteria'])
								->where('status', '>=', 2)
								->orderBy('created_at', 'DESC')
								->get();

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

		$this->breadcrumbs->push(0, 'Home', 'pelamar/main');
		$this->breadcrumbs->push(1, 'Pengumuman', 'pelamar/main/announcement');
		$this->data['title'] 		= 'Announcement | ' . $this->title;
		$this->data['content']		= 'announcement';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function profile()
	{
		$this->load->model('M_Data');
		$this->data['data'] = M_Data::where('user_id', $this->data['user']->id)->first();
		$this->check_allowance(!isset($this->data), ['User data not found', 'danger']);

		$this->data['educational_background'] = json_decode($this->data['data']->educational_background);

		if ($this->POST('submit_final'))
		{
			$this->load->model('M_Data');

			$user = M_Data::where('user_id', $this->data['user']->id)->first();
			$user->submitted = 1;
			$user->save();

			$this->flashmsg('Data berhasil di-submit');
			redirect('pelamar/main/profile');
		}

		if ($this->POST('submit'))
		{
			$this->load->model('M_Users');

			M_Users::getConnectionResolver()->connection()->beginTransaction();

			$user = M_Users::find($this->data['user']->id);
			if (!isset($user))
			{
				$this->flashmsg('User data not found', 'danger');
				$this->go_back(-1);
				exit;
			}

			$data = M_Data::where('user_id', $this->data['user']->id)->first();
			if (!isset($data))
			{
				$data = new M_Data();
			}
			$data->name 		= $this->POST('name');
			$data->birthdate 	= $this->POST('birthdate');
			$data->birthplace 	= $this->POST('birthplace');
			$data->user_id 		= $user->id;

			$elementary = $this->POST('elementary');
			$junior 	= $this->POST('junior');
			$senior 	= $this->POST('senior');
			$university = $this->POST('university');

			$data->educational_background 	= json_encode([
				'elementary'	=> $elementary,
				'junior'		=> $junior,
				'senior'		=> $senior,
				'university'	=> $university
			]);
			$data->address 	= $this->POST('address');
			$data->reason 	= $this->POST('reason');

			$hobby = [];
			$lainnya = $this->POST('lainnya');
			if (isset($lainnya))
			{
				$hobby []= $this->POST('hobby');
			}
			
			$sport = $this->POST('sport');
			if (isset($sport))
			{
				$hobby []= 'Sport';
			}

			$food = $this->POST('food');
			if (isset($food))
			{
				$hobby []= 'Food';
			}

			$photograph = $this->POST('photograph');
			if (isset($photograph))
			{
				$hobby []= 'Photograph';
			}

			$travelling = $this->POST('travelling');
			if (isset($travelling))
			{
				$hobby []= 'Travelling';
			}
			
			$data->hobby = json_encode($hobby);
			
			if ($data->save())
			{
				if (!empty($_FILES['image']['name']))
				{
					$this->upload($data->id, 'assets/img', 'image');	
				}

				if (!empty($_FILES['ktp']['name']))
				{
					$this->upload('ktp-' . $data->id, 'assets/img', 'ktp');
				}

				if (!empty($_FILES['kk']['name']))
				{
					$this->upload('kk-' . $data->id, 'assets/img', 'kk');
				}

				M_Users::getConnectionResolver()->connection()->commit();
			}

			redirect('pelamar/main/profile');
		}

		$this->data['hobby'] = json_decode($this->data['data']->hobby);

		$this->breadcrumbs->push(0, 'Home', 'pelamar/main');
		$this->breadcrumbs->push(1, 'Profile', 'pelamar/main/profile');
		$this->data['title'] 		= 'Profile | ' . $this->title;
		$this->data['content']		= 'profile';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function certificate()
	{
		$this->data['certificates']	= glob(FCPATH . '/assets/img/certificate-' . $this->data['user']->id . '-*');
		if ($this->POST('submit'))
		{
			$uploadCount = $this->POST('upload_count');
			for ($i = 0; $i < $uploadCount; $i++)
			{
				if (!empty($_FILES['certificates_' . ($i + 1)]['name']))
				{
					$this->upload('certificate-' . $this->data['user']->id . '-' . ($i + count($this->data['certificates']) + 1), 'assets/img', 'certificates_' . ($i + 1));	
				}
			}
			redirect('pelamar/main/certificate');
			exit;
		}

		$this->breadcrumbs->push(0, 'Home', 'pelamar/main');
		$this->breadcrumbs->push(1, 'Certificate', 'pelamar/main/certificate');
		$this->data['title'] 		= 'Certificate | ' . $this->title;
		$this->data['content']		= 'certificate';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function setting()
	{
		if ($this->POST('submit'))
		{
			$oldPassword = $this->POST('old_password');
			$this->load->model('M_Users');
			$checkUser = M_Users::where('id', $this->data['user']->id)
							->where('password', md5($oldPassword))
							->first();

			if (!isset($checkUser))
			{
				$this->flashmsg('Wrong old password', 'danger');
				$this->go_back(-1);
				exit;
			}

			$newPassword 	= $this->POST('new_password');
			$newRpassword 	= $this->POST('new_rpassword');
			if ($newPassword !== $newRpassword)
			{
				$this->flashmsg('Password baru harus sama dengan password konfirmasi', 'danger');
				$this->go_back(-1);
				exit;	
			}

			$checkUser->password = md5($newPassword);
			$checkUser->save();
			$this->flashmsg('Password berhasil diubah');
			redirect('pelamar/main/setting');
			exit;
		}

		$this->breadcrumbs->push(0, 'Home', 'pelamar/main');
		$this->breadcrumbs->push(1, 'Setting', 'pelamar/main/setting');
		$this->data['title'] 		= 'Setting | ' . $this->title;
		$this->data['content']		= 'setting';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}
}