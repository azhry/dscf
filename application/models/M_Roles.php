<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Roles extends Eloquent
{
	protected $table		= 'roles';
	protected $primaryKey	= 'id';

	
}