<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Gejala_m extends Eloquent
{
	protected $table		= 'gejala';
	protected $primaryKey	= 'id';
	protected $fillable 	= ['id', 'nama_gejala', 'belief'];

	public function gejala_penyakit()
	{
		require_once __DIR__ . '/GejalaPenyakit_m.php';
		return $this->hasMany('GejalaPenyakit_m', 'id_gejala', 'id');
	}
}