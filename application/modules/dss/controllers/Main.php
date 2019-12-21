<?php 

class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->module = 'dss';
	}

	public function index()
	{
		$this->breadcrumbs->push(0, 'Home', 'dss');

		$this->load->model('Gejala_m');
		$this->data['gejala']	= Gejala_m::get();

		if ($this->POST('process'))
		{
			$this->load->model('Penyakit_m');
			$knowledge = Penyakit_m::with(['gejala_penyakit', 'gejala_penyakit.gejala'])->get();

			$gejala = [];
			$userCertaintyFactor = [];
			$expertCertaintyFactor = [];

			$this->data['cfs'] = [];

			unset($_POST['process']);
			foreach ($_POST as $key => $value)
			{
				$token = explode('_', $key);
				$id = $token[1];
				
				$row = Gejala_m::with(['gejala_penyakit', 'gejala_penyakit.penyakit'])->find($id);
				if (isset($row))
				{
					$gejala []= $row;
					$expertCertaintyFactor[$row->nama_gejala] = (float)$row->belief;
					$cf = $this->POST('gejala_select_' . $id);
					$this->data['cfs'][$row->nama_gejala] = $cf;
					if (isset($cf))
					{
						$userCertaintyFactor[$row->nama_gejala] = (float)$cf;
					}
					else
					{
						$userCertaintyFactor[$row->nama_gejala] = 0;
					}
				}
			}

			$this->load->library('dss/DempsterShafer');
			$this->load->library('dss/CertaintyFactor');

			$this->certaintyfactor->setKnowledge($knowledge);
			$this->data['result_cf'] = $this->certaintyfactor->calculateDiseaseCertaintyFactor($userCertaintyFactor);
			$this->data['result_cf_keys'] 	= array_keys($this->data['result_cf']);
			$this->data['result_cf_values'] = array_values($this->data['result_cf']);

			$this->data['result'] 			= $this->dempstershafer->predict($gejala);
			$this->data['gejala_terpilih'] 	= $gejala;

			$this->data['penyakit'] = [];
			if (count($this->data['result']) > 0)
			{
				foreach ($this->data['result'][0]['kode'] as $kode)
				{
					$penyakit = Penyakit_m::where('kode', $kode)->first();
					if (isset($penyakit))
					{
						$this->data['penyakit'] []= $penyakit;
					}
				}
			}

			$this->data['penyakit_cf'] = [];
			if (count($this->data['result_cf']) > 0)
			{
				foreach ($this->data['result_cf_keys'] as $p)
				{
					$penyakit = Penyakit_m::where('nama_penyakit', $p)->first();
					if (isset($penyakit))
					{
						$this->data['penyakit_cf'] []= $penyakit;
					}
				}	
			}
		}

		$this->data['title'] 		= 'Dashboard | ' . $this->title;
		$this->data['content']		= 'dashboard';
		$this->data['breadcrumb'] 	= $this->breadcrumbs->show();
		$this->template($this->data, $this->module);
	}

	public function gejala()
	{
		$this->load->model('Gejala_m');
		$this->data['gejala']	= Gejala_m::get();
		$this->data['title']	= 'Menu Gejala';
		$this->data['content']	= 'menu_gejala';
		$this->template($this->data, $this->module);
	}

	public function input_gejala()
	{
		$this->load->model('Penyakit_m');
		$this->data['penyakit']	= Penyakit_m::get();

		if ($this->POST('submit'))
		{
			$this->load->model('Gejala_m');
			$gejala = new Gejala_m();
			$gejala->nama_gejala 	= $this->POST('nama_gejala');
			$gejala->belief 		= $this->POST('belief');
			$gejala->save();

			$idGejala = $gejala->id;
			$gejalaPenyakit = [];
			foreach ($this->data['penyakit'] as $penyakit)
			{
				if (isset($_POST[$penyakit->kode]))
				{
					$gejalaPenyakit []= [
						'id_gejala'		=> $idGejala,
						'id_penyakit'	=> $penyakit->id
					];
				}
			}

			$this->load->model('GejalaPenyakit_m');
			GejalaPenyakit_m::insert($gejalaPenyakit);

			$this->flashmsg('Gejala baru berhasil ditambahkan');
			redirect('dss/main/gejala');
		}

		$this->data['title']	= 'Input Gejala';
		$this->data['content']	= 'input_gejala';
		$this->template($this->data, $this->module);
	}

	public function edit_gejala()
	{
		$this->data['id'] = $this->uri->segment(3);
		$this->check_allowance(!isset($this->data['id']));

		$this->load->model('Gejala_m');
		$this->data['gejala'] = Gejala_m::find($this->data['id']);
		$this->check_allowance(!isset($this->data['gejala']), ['Data not found', 'danger']);

		$this->load->model('Penyakit_m');
		$this->data['penyakit']	= Penyakit_m::get();

		$this->load->model('GejalaPenyakit_m');
		$gejalaPenyakitLama = GejalaPenyakit_m::where('id_gejala', $this->data['id'])->get();
		$this->data['id_penyakit'] = array_column($gejalaPenyakitLama->toArray(), 'id_penyakit');

		if ($this->POST('submit'))
		{
			$gejala = Gejala_m::find($this->data['id']);
			$gejala->kode			= $this->POST('kode');
			$gejala->nama_gejala 	= $this->POST('nama_gejala');
			$gejala->belief 		= $this->POST('belief');
			$gejala->save();

			$idGejala = $gejala->id;
			$gejalaPenyakit = [];
			foreach ($this->data['penyakit'] as $penyakit)
			{
				if (isset($_POST[$penyakit->kode]))
				{
					$gejalaPenyakit []= [
						'id_gejala'		=> $idGejala,
						'id_penyakit'	=> $penyakit->id
					];
				}
			}

			GejalaPenyakit_m::where('id_gejala', $this->data['id'])->delete();
			GejalaPenyakit_m::insert($gejalaPenyakit);

			$this->flashmsg('Gejala baru berhasil ditambahkan');
			redirect('dss/main/gejala');
		}

		$this->data['title']	= 'Edit Gejala';
		$this->data['content']	= 'edit_gejala';
		$this->template($this->data, $this->module);
	}

	public function penyakit()
	{
		$this->load->model('Penyakit_m');
		$this->data['penyakit']	= Penyakit_m::get();
		$this->data['title']	= 'Menu Penyakit';
		$this->data['content']	= 'menu_penyakit';
		$this->template($this->data, $this->module);
	}

	public function input_penyakit()
	{
		$this->load->model('Penyakit_m');

		if ($this->POST('submit'))
		{
			$penyakit = new Penyakit_m();
			$penyakit->nama_penyakit 	= $this->POST('nama_penyakit');
			$penyakit->kode 			= $this->POST('kode');
			$penyakit->saran_penanganan = $this->POST('saran_penanganan');
			$penyakit->save();

			$this->flashmsg('Penyakit baru berhasil ditambahkan');
			redirect('dss/main/penyakit');
		}

		$this->data['title']	= 'Input Penyakit';
		$this->data['content']	= 'input_penyakit';
		$this->template($this->data, $this->module);
	}

	public function tambah_gejala_penyakit()
	{
		$this->data['id_penyakit'] = $this->uri->segment(4);
		$this->check_allowance(!isset($this->data['id_penyakit']));

		$this->load->model('Gejala_m');
		$this->load->model('Penyakit_m');
		$this->data['penyakit'] = Penyakit_m::with(['gejala_penyakit', 'gejala_penyakit.gejala'])
									->find($this->data['id_penyakit']);
		$this->check_allowance(!isset($this->data['penyakit']), ['Data not found', 'danger']);

		if ($this->POST('submit'))
		{
			$this->db->trans_start();
			
			$gejala 						= new Gejala_m();
			$gejala->nama_gejala 			= $this->POST('nama_gejala');
			$gejala->belief 				= $this->POST('belief');
			$gejala->save();

			$gejalaPenyakit 				= new GejalaPenyakit_m();
			$gejalaPenyakit->id_penyakit 	= $this->data['id_penyakit'];
			$gejalaPenyakit->id_gejala 		= $gejala->id;
			$gejalaPenyakit->save();

			$this->db->trans_complete();

			$this->flashmsg('Gejala penyakit berhasil ditambah');
			redirect('dss/main/tambah-gejala-penyakit/' . $this->data['id_penyakit']);
			exit;
		}

		$this->data['title']	= 'Form Tambah Gejala Penyakit';
		$this->data['content']	= 'form_tambah_gejala_penyakit';
		$this->template($this->data, $this->module);
	}

	public function hapus_gejala_penyakit()
	{
		$this->data['id_penyakit'] 	= $this->GET('id_penyakit');
		$this->check_allowance(!isset($this->data['id_penyakit']));

		$this->load->model('Penyakit_m');
		$this->data['penyakit'] = Penyakit_m::find($this->data['id_penyakit']);
		$this->check_allowance(!isset($this->data['penyakit']), ['Data not found', 'danger']);

		$this->data['id_gejala']	= $this->GET('id_gejala');
		$this->check_allowance(!isset($this->data['id_gejala']));

		$this->load->model('Gejala_m');
		$this->data['gejala'] = Gejala_m::find($this->data['id_gejala']);
		$this->check_allowance(!isset($this->data['gejala']), ['Data not found', 'danger']);

		$this->load->model('GejalaPenyakit_m');
		GejalaPenyakit_m::where('id_penyakit', $this->data['id_penyakit'])
						->where('id_gejala', $this->data['id_gejala'])
						->delete();

		$this->flashmsg('Gejala penyakit berhasil dihapus');
		redirect('dss/main/tambah-gejala-penyakit/' . $this->data['id_penyakit']);
		exit;

	}
}