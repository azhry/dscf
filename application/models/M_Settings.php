<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Settings extends Eloquent
{
	protected $table		= 'settings';
	protected $primaryKey	= 'id';
}