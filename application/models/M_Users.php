<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Users extends Eloquent
{
	protected $table		= 'users';
	protected $primaryKey	= 'id';

	public function role()
	{
		require_once __DIR__ . '/M_Roles.php';
		return $this->hasOne('M_Roles', 'id', 'role_id');
	}

	public function data()
	{
		require_once __DIR__ . '/M_Data.php';
		return $this->hasOne('M_Data', 'user_id', 'id');	
	}
}