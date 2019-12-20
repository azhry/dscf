<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Criteria extends Eloquent
{
	protected $table		= 'criteria';
	protected $primaryKey	= 'id';
}