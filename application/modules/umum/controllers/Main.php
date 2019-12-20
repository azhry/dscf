<?php 

class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$userInfo = $this->session->userdata(USER_INFO_KEY);
		if (isset($userInfo))
		{
			switch ($userInfo->{ROLE_ID_KEY})
			{
				case ADMIN_PRIVILEGE:
					redirect('admin/data');
					break;

				case JURI_PRIVILEGE:
					redirect('juri/data');
					break;

				case PELAMAR_PRIVILEGE:
					redirect('pelamar/main');
					break;

				case PIMPINAN_PRIVILEGE:
					redirect('pimpinan/main');
					break;

				case SYSTEM_PRIVILEGE:
					redirect('sistem/users');
					break;
			}
		}
	}

	public function index()
	{
		if ($this->POST('login'))
		{
			$username 	= $this->POST('username');
			$password	= $this->POST('password');
			
			$this->load->model('M_Users');
			$user = M_Users::where('username', $username)
					->where('password', md5($password))
					->first();
			if (isset($user))
			{
				$this->session->set_userdata(USER_INFO_KEY, (object)$user->toArray());
			}
			else
			{
				$this->flashmsg('Wrong email or password', 'danger');
			}

			redirect('login');
		}

		$this->load->model('M_Settings');
		$this->data['settings'] = M_Settings::find(1);

		$this->load->view('login', $this->data);
	}

	public function register()
	{
		if ($this->POST('register'))
		{
			$password 	= $this->POST('password');
			$rpassword 	= $this->POST('rpassword');
			if ($password !== $rpassword)
			{
				$this->flashmsg('Password harus sama dengan konfirmasi password', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->load->model('M_Users');

			M_Users::getConnectionResolver()->connection()->beginTransaction();

			$user = new M_Users();
			$user->role_id 	= 3;
			$user->username = $this->POST('email');
			$user->password = md5($password);
			$user->valid 	= 0;
			if (!$user->save())
			{
				M_Users::getConnectionResolver()->connection()->rollback();
				$this->flashmsg('Failed to save user data. Please try again', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->load->model('M_Data');
			$data = new M_Data();
			$data->name 					= $this->POST('name');
			$data->birthdate 				= $this->POST('birthdate');
			$data->birthplace 				= $this->POST('birthplace');
			$data->user_id 					= $user->id;

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
			$data->hobby 	= json_encode($this->POST('hobby'));
			$data->reason 	= $this->POST('reason');
			
			if ($data->save())
			{
				M_Users::getConnectionResolver()->connection()->commit();
				$this->upload($data->id, 'assets/img', 'image');
			}

			$this->flashmsg('Pendaftaran sukses. Silahkan login.');
			redirect('login');
		}

		$this->load->view('register');
	}

	public function reset_password()
	{
		$this->data['token'] = $this->GET('token');
		$this->check_allowance(!isset($this->data['token']));

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::where('reset_password_token', $this->data['token'])->first();
		$this->check_allowance(!isset($this->data['user']), ['User data not found', 'danger']);

		if ($this->POST('reset'))
		{
			$password 	= $this->POST('password');
			$rpassword 	= $this->POST('rpassword');
			if ($password !== $rpassword)
			{
				$this->flashmsg('Confirm password must be equal to password field', 'danger');
				redirect('umum/main/reset-password?token=' . $this->data['token']);
			}

			$this->data['user']->password 				= md5($password);
			$this->data['user']->reset_password_token 	= null;
			$this->data['user']->save();

			$this->flashmsg('Reset password success. Please login.');
			redirect('login');
		}

		$this->load->view('reset_password', $this->data);
	}

	public function send_reset_password()
	{
		if ($this->POST('submit'))
		{
			$email = $this->POST('email');
			$this->load->model('M_Users');
			$this->data['user'] = M_Users::where('username', $email)->first();
			$this->check_allowance(!isset($this->data['user']), ['User dengan email ' . $email . ' tidak ditemukan', 'danger']);

			$token = md5(date('YmdHis'));
			$this->data['user']->reset_password_token = $token;
			$this->data['user']->save();

			$link = base_url('umum/main/reset-password?token=' . $token);

			$this->load->library('CI_PHPMailer/ci_phpmailer');
			try 
			{
				$this->ci_phpmailer->setServer('smtp.gmail.com');
				$this->ci_phpmailer->setAuth('tvriplg@gmail.com', 'tvripalembang');
				$this->ci_phpmailer->setAlias('no-reply@spk-vikor.com', 'Reset Password - SPK Vikor');
				$this->ci_phpmailer->sendMessage($email, 'Reset Password', 'Anda dapat melakukan reset password dengan klik link <a href="' . $link . '">' . $link . '</a>');
			}
			catch (Exception $e)
			{
				$this->ci_phpmailer->displayError();
			}

			$this->flashmsg('Reset password request sent. Check your email.');
			redirect('umum/main/send-reset-password');
		}

		$this->load->view('send_reset_password');
	}
}