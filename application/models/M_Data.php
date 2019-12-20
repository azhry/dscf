<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Data extends Eloquent
{
	use SoftDeletes;

	protected $table		= 'data';
	protected $primaryKey	= 'id';

	public function values()
	{
		require_once __DIR__ . '/M_DataValue.php';
		return $this->hasMany('M_DataValue', 'data_id', 'id');
	}

}