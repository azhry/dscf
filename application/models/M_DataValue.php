<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_DataValue extends Eloquent
{
	protected $table		= 'data_value';
	protected $primaryKey	= 'id';

	public function criteria()
	{
		require_once __DIR__ . '/M_Criteria.php';
		return $this->hasOne('M_Criteria', 'id', 'criteria_id');
	}
}