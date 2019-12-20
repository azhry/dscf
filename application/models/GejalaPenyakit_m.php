<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class GejalaPenyakit_m extends Eloquent
{
	protected $table		= 'gejala_penyakit';
	protected $primaryKey	= 'id';
	protected $fillable 	= ['id', 'id_penyakit', 'id_gejala'];

	public function gejala()
	{
		require_once __DIR__ . '/Gejala_m.php';
		return $this->hasOne('Gejala_m', 'id', 'id_gejala');
	}

	public function penyakit()
	{
		require_once __DIR__ . '/Penyakit_m.php';
		return $this->hasOne('Penyakit_m', 'id', 'id_penyakit');
	}
}