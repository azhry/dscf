<?php 

class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'admin';

		// $this->_check_privilege([ADMIN_PRIVILEGE]);
	}

	public function docs()
	{
		redirect('http://localhost/spk-vikor/assets/light-bootstrap-dashboard-master/examples/dashboard.html');
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'admin');
		$this->data['title'] 		= 'Dashboard Admin | ' . $this->title;
		$this->data['content']		= 'dashboard';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function list_users()
	{
		$this->load->model('M_Users');
		$this->data['user_id'] 	= $this->uri->segment(4);
		$this->data['action']	= $this->uri->segment(5);
		if (isset($this->data['user_id'], $this->data['action']) && $this->data['action'] == 'delete')
		{
			$user = M_Users::find($this->data['user_id']);
			if (!$user->delete())
			{
				echo json_encode(['status' => 'failed', 'message' => 'User data not found']);
				exit;
			}

			echo json_encode(['status' => 'success', 'message' => 'User successfully deleted']);
			exit;
		}

		$this->data['users'] = M_Users::with('role')->get();

		$this->breadcrumbs->push(1, 'List Users', 'admin');
		$this->data['title'] 		= 'List Users | ' . $this->title;
		$this->data['content']		= 'list_users';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function user_detail()
	{
		$this->data['user_id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['user_id']));

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::with('role')->find($this->data['user_id']);
		$this->check_allowance(!isset($this->data['user']), ['User data not found', 'danger']);

		$this->breadcrumbs->push(2, 'User Detail', 'admin');
		$this->data['title'] 		= $this->data['user']->name . ' | ' . $this->title;
		$this->data['content']		= 'user_detail';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function create_users()
	{
		if ($this->POST('submit'))
		{
			$password = $this->POST('password');
			$rpassword = $this->POST('rpassword');
			if ($password !== $rpassword)
			{
				$this->flashmsg('Password field must be equal to Re-type Password field', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->load->model('M_Users');
			
			$email = $this->POST('email');
			$checkUserByEmail = M_Users::where('email', $email)->first();
			if (isset($checkUserByEmail))
			{
				$this->flashmsg('Email ' . $email . ' is already used', 'danger');
				$this->go_back(-1);
				exit;
			}

			$username = $this->POST('username');
			$checkUserByUsername = M_Users::where('username', $username)->first();
			if (isset($checkUserByUsername))
			{
				$this->flashmsg('Username ' . $username . ' is already used', 'danger');
				$this->go_back(-1);
				exit;
			}

			$user = new M_Users();
			$user->email = $email;
			$user->username = $username;
			$user->password = md5($password);
			$user->name = $this->POST('name');
			$user->role_id = $this->POST('role_id');

			if (!$user->save())
			{
				$this->flashmsg('Something wrong when creating new user. Please try again.', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->flashmsg('Create new user success');
			redirect('admin/main/user-detail/' . $user->id);
		}

		$this->load->model('M_Roles');
		$this->data['roles'] = M_Roles::get();

		$this->breadcrumbs->push(1, 'Create New User', 'admin');
		$this->data['title'] 		= 'Create New User | ' . $this->title;
		$this->data['content'] 		= 'create_user_form';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function update_users()
	{
		$this->data['user_id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['user_id']));

		$this->load->model('M_Users');
		$this->data['user'] = M_Users::with('role')->find($this->data['user_id']);
		$this->check_allowance(!isset($this->data['user']), ['User data not found', 'danger']);

		if ($this->POST('submit'))
		{
			$password = $this->POST('password');
			if (isset($password) && !empty($password))
			{
				$rpassword = $this->POST('rpassword');
				if ($password !== $rpassword)
				{
					$this->flashmsg('Password field must be equal to Re-type Password field', 'danger');
					$this->go_back(-1);
					exit;
				}
			}

			$email = $this->POST('email');
			$checkUserByEmail = M_Users::where('email', '!=', $this->data['user']->email)
								->where('email', $email)
								->first();
			if (isset($checkUserByEmail))
			{
				$this->flashmsg('Email ' . $email . ' is already used', 'danger');
				$this->go_back(-1);
				exit;
			}

			$username = $this->POST('username');
			$checkUserByUsername = M_Users::where('username', '!=', $this->data['user']->username)
									->where('username', $username)
									->first();
			if (isset($checkUserByUsername))
			{
				$this->flashmsg('Username ' . $username . ' is already used', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->data['user']->name 		= $this->POST('name');
			$this->data['user']->email 		= $email;
			$this->data['user']->username 	= $username;
			$this->data['user']->role_id 	= $this->POST('role_id');
			if (isset($password) && !empty($password))
			{
				$this->data['user']->password = md5($password);
			}

			if (!$this->data['user']->save())
			{
				$this->flashmsg('Something wrong when editing user. Please try again.', 'danger');
				$this->go_back(-1);
				exit;
			}

			$this->flashmsg('Edit user success');
			redirect('admin/main/user-detail/' . $this->data['user']->id);
		}

		$this->data['roles'] = M_Roles::get();

		$this->breadcrumbs->push(2, 'Edit', 'admin');
		$this->data['title'] 		= $this->data['user']->name . ' | ' . $this->title;
		$this->data['content']		= 'update_user_form';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function list_layers()
	{
		$this->load->model('M_Layers');
		$this->data['layer_id'] 	= $this->uri->segment(4);
		$this->data['action']	= $this->uri->segment(5);
		if (isset($this->data['layer_id'], $this->data['action']) && $this->data['action'] == 'delete')
		{
			$layer = M_Layers::find($this->data['layer_id']);
			if (!$layer->delete())
			{
				echo json_encode(['status' => 'failed', 'message' => 'Layer data not found']);
				exit;
			}

			echo json_encode(['status' => 'success', 'message' => 'Layer successfully deleted']);
			exit;
		}

		$this->data['layers'] = M_Layers::get();

		$this->breadcrumbs->push(1, 'List Layers', 'admin');
		$this->data['title'] 		= 'List Layers | ' . $this->title;
		$this->data['content']		= 'list_layers';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function layer_data()
	{
		$this->data['layer_id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['layer_id']));

		$this->load->model('M_Layers');
		$this->data['layer'] = M_Layers::find($this->data['layer_id']);
		$this->check_allowance(!isset($this->data['layer']), ['Layer data not found', 'danger']);

		$this->data['imports'] = $this->_check_import_status($this->data['layer']->import_id);
		if ($this->data['imports'] === false)
		{
			$this->flashmsg('Data could not be retrieved. Please contact administrator.', 'danger');
			$this->go_back(-1);
			exit;
		}

		$sql = 'SELECT * FROM lanskap2.' . $this->data['imports']->table_name;
		echo $sql;
		$response = $this->_carto_query($sql);
		$this->dump($response);
		exit;

		$this->breadcrumbs->push(2, 'Layer Data', 'admin');
		$this->data['title'] 		= $this->data['layer']->name . ' | ' . $this->title;
		$this->data['content']		= 'layer_data';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function layer_detail()
	{
		$this->data['layer_id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['layer_id']));

		$this->load->model('M_Layers');
		$this->data['layer'] = M_Layers::find($this->data['layer_id']);
		$this->check_allowance(!isset($this->data['layer']), ['Layer data not found', 'danger']);

		$this->breadcrumbs->push(2, 'Layer Detail', 'admin');
		$this->data['title'] 		= $this->data['layer']->name . ' | ' . $this->title;
		$this->data['content']		= 'layer_detail';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function create_layers()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('M_Layers');
			M_Layers::getConnectionResolver()->connection()->beginTransaction();

			try
			{
				$layer 				= new M_Layers();
				$layer->name 		= $this->POST('name');
				$layer->description = $this->POST('description');
				$layer->geotype 	= $this->POST('geotype');
				$layer->icon 		= '';

				if ($layer->save())
				{
					// upload icon
					$extension = pathinfo(strtolower($_FILES['icon']['name']), PATHINFO_EXTENSION);
					$filename = $layer->id . '.' . $extension;
					$this->upload_file($filename, 'assets/files/icons', 'icon');
					$layer->icon = $filename; // assign filename to icon field

					// upload shapefile
					$extension = pathinfo(strtolower($_FILES['shapefile']['name']), PATHINFO_EXTENSION);
					$filename = $layer->id . '.' . $extension;
					$shapefilesPath = 'assets/files/shapefiles';
					$this->upload_file($filename, 'assets/files/shapefiles', 'shapefile');

					if ($layer->save())
					{
						$result = $this->_import_shapefile(FCPATH . $shapefilesPath . '/' . $filename);
						if ($result === false)
						{
							M_Layers::getConnectionResolver()->connection()->rollback();
							$this->flashmsg('Something wrong when importing shapefile', 'danger');
							$this->go_back(-1);
							exit;
						}
						else
						{
							$layer->import_id = $result->item_queue_id;
							if ($layer->save())
							{
								M_Layers::getConnectionResolver()->connection()->commit();
								$this->flashmsg('New layer added');
							}
							else
							{
								M_Layers::getConnectionResolver()->connection()->rollback();
								$this->flashmsg('Something wrong when adding new layer', 'danger');
								$this->go_back(-1);
								exit;
							}
							
						}
						
					}
					else
					{
						M_Layers::getConnectionResolver()->connection()->rollback();
						$this->flashmsg('Something wrong when adding new layer', 'danger');
						$this->go_back(-1);
						exit;
					}
				}
				else
				{
					M_Layers::getConnectionResolver()->connection()->rollback();
					$this->flashmsg('Failed to add new layer', 'danger');
					$this->go_back(-1);
					exit;
				}
			}
			catch (Exception $e)
			{
				M_Layers::getConnectionResolver()->connection()->rollback();
				$this->flashmsg('Failed to add new layer', 'danger');
				$this->go_back(-1);
				exit;
			}
			
			redirect('admin/main/create_layers');
		}

		$this->breadcrumbs->push(0, 'Home', 'Create New Form');
		$this->data['title']		= 'Create New Layer | ' . $this->title;
		$this->data['content']		= 'create_layer_form';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function update_layers()
	{
		$this->data['layer_id'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['layer_id']));

		$this->load->model('M_Layers');
		$this->data['layer'] = M_Layers::find($this->data['layer_id']);
		$this->check_allowance(!isset($this->data['layer']), ['Layer data not found', 'danger']);

		$this->data['imports'] = $this->_check_import_status($this->data['layer']->import_id);

		if ($this->POST('submit'))
		{
			M_Layers::getConnectionResolver()->connection()->beginTransaction();

			try
			{
				$this->data['layer']->name 			= $this->POST('name');
				$this->data['layer']->description 	= $this->POST('description');
				$this->data['layer']->geotype 		= $this->POST('geotype');

				if ($this->data['layer']->save())
				{
					if (!empty($_FILES['icon']['name']))
					{
						// upload icon
						$extension = pathinfo(strtolower($_FILES['icon']['name']), PATHINFO_EXTENSION);
						$filename = $this->data['layer']->id . '.' . $extension;
						$this->upload_file($filename, 'assets/files/icons', 'icon');
						$this->data['layer']->icon = $filename; // assign filename to icon field
					}
					
					if (!empty($_FILES['shapefile']['name']))
					{
						// upload shapefile
						$extension = pathinfo(strtolower($_FILES['shapefile']['name']), PATHINFO_EXTENSION);
						$filename = $this->data['layer']->id . '.' . $extension;
						$shapefilesPath = 'assets/files/shapefiles';
						$this->upload_file($filename, 'assets/files/shapefiles', 'shapefile');
					}

					if ($this->data['layer']->save())
					{
						if (!empty($_FILES['shapefile']['name']))
						{
							$result = $this->_import_shapefile(FCPATH . $shapefilesPath . '/' . $filename);
							if ($result === false)
							{
								M_Layers::getConnectionResolver()->connection()->rollback();
								$this->flashmsg('Something wrong when importing shapefile', 'danger');
								$this->go_back(-1);
								exit;
							}
							else
							{
								$this->data['layer']->import_id = $result->item_queue_id;
								if ($this->data['layer']->save())
								{
									M_Layers::getConnectionResolver()->connection()->commit();
									$this->flashmsg('Layer successfully edited');
								}
								else
								{
									M_Layers::getConnectionResolver()->connection()->rollback();
									$this->flashmsg('Something wrong when editing layer', 'danger');
									$this->go_back(-1);
									exit;
								}
								
							}
						}
						else
						{
							M_Layers::getConnectionResolver()->connection()->commit();
							$this->flashmsg('Layer successfully edited');
						}
						
					}
					else
					{
						M_Layers::getConnectionResolver()->connection()->rollback();
						$this->flashmsg('Something wrong when adding new layer', 'danger');
						$this->go_back(-1);
						exit;
					}
				}
				else
				{
					M_Layers::getConnectionResolver()->connection()->rollback();
					$this->flashmsg('Failed to add new layer', 'danger');
					$this->go_back(-1);
					exit;
				}
			}
			catch (Exception $e)
			{
				M_Layers::getConnectionResolver()->connection()->rollback();
				$this->flashmsg('Failed to add new layer', 'danger');
				$this->go_back(-1);
				exit;
			}
			
			redirect('admin/main/layer-detail/' . $this->data['layer']->id);
		}

		$this->breadcrumbs->push(0, 'Home', 'Update Layer Form');
		$this->data['title']		= 'Update Layer | ' . $this->title;
		$this->data['content']		= 'update_layer_form';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	private function _check_import_status($importId)
	{
		$this->config->load('app');
		$apiKey = $this->config->item('CARTO_API_KEY');
		$client = new GuzzleHttp\Client([
			'headers' 		=> ['Content-Type' => 'multipart/form-data'],
			'base_uri'		=> $this->config->item('BASE_API_URL'),
			'http_errors'	=> false
		]);
		$response = $client->request('GET', '/user/lanskap2/api/v1/imports/' . $importId . '?api_key=' . $apiKey);
		if ($response->getStatusCode() == 404)
		{
			return false;
		}

		return $this->_is_json($response->getBody()->getContents(), true);
	}

	private function _carto_query($sql)
	{
		$this->config->load('app');
		$apiKey = $this->config->item('CARTO_API_KEY');
		$client = new GuzzleHttp\Client([
			'headers' 	=> ['Content-Type' => 'multipart/form-data'],
			'base_uri'	=> $this->config->item('BASE_API_URL')
		]);
		$response = $client->request('GET', '/user/lanskap2/api/v2/sql?api_key=' . $apiKey . '&q=' . $sql);

		return $this->_is_json($response->getBody()->getContents(), true);
	}

	private function _import_shapefile($path)
	{
		try
		{
			if (!file_exists($path))
			{
				throw new Exception('File does\'nt exist on ' . $path);
			}

			$file = fopen($path, 'r');
			if ($file === false)
			{
				throw new Exception('Failed to open stream ' . $path);
			}
		}
		catch (Exception $e)
		{
			return false;
		}
		

		$this->config->load('app');
		$apiKey = $this->config->item('CARTO_API_KEY');
		$client = new GuzzleHttp\Client([
			'headers' 	=> ['Content-Type' => 'multipart/form-data'],
			'base_uri'	=> $this->config->item('BASE_API_URL')
		]);
		$response = $client->request('POST', '/user/lanskap2/api/v1/imports?api_key=' . $apiKey, [
			'multipart' => [
				[
					'name'		=> 'file',
					'contents'	=> $file,
					'headers'	=> ['Content-Type' => 'application/zip']
				]
			]
		]);

		return $this->_is_json($response->getBody()->getContents(), true);
	}

	public function check_import_status()
	{
		$response = $this->_check_import_status('345d9faf-01bc-480b-9bff-28005943b494');
		$this->dump($response);
	}

	public function test()
	{
		
		$this->config->load('app');
		$apiKey = $this->config->item('CARTO_API_KEY');
		$client = new GuzzleHttp\Client([
			'defaults' => [
				'headers' => ['Content-Type' => 'multipart/form-data']
			]
		]);
		echo $apiKey . ' :: ' . 'file:///' . FCPATH . 'assets/files/shapefiles/bandara.zip';
		$response = $client->request('POST', 'http://layers.lanskap.id/user/lanskap2/api/v1/imports?api_key=' . $apiKey, [
			'multipart' => [
				[
					'name' 		=> 'file',
					'contents'	=> fopen(FCPATH . 'assets/files/shapefiles/bandara.zip', 'r'),
					'headers'	=> ['Content-Type' => 'application/zip']
				]
			]
		]);
		$this->dump($response->getBody()->getContents());

		// curl -v -F @file=C:/xampp/htdocs/siikon-plus/assets/files/shapefiles/bandara.zip http://layers.lanskap.id/user/lanskap2/api/v1/imports?api_key=f5963fc5b4028dd8e2f19982dbf16ba1c843f766

		// curl -v -H "Content-Type: application/json" -d '{"url":"http://si-ikon.sumselprov.go.id/v2/7.zip"}' "http://layers.lanskap.id/user/lanskap2/api/v1/imports?api_key=f5963fc5b4028dd8e2f19982dbf16ba1c843f766"

		// {"item_queue_id":"8dfa1670-8569-44d4-94c0-c8941cba65c1","success":true}
	}
}