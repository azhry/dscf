<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Penyakit_m extends Eloquent
{
	protected $table		= 'penyakit';
	protected $primaryKey	= 'id';
	protected $fillable 	= ['id', 'kode', 'nama_penyakit'];

	public function gejala_penyakit()
	{
		require_once __DIR__ . '/GejalaPenyakit_m.php';
		return $this->hasMany('GejalaPenyakit_m', 'id_penyakit', 'id');
	}
}