<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
use Mpdf\Mpdf;

class M_pdf 
{
    public $param;
    public $pdf;
 
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
        $this->param = $param;
        $this->pdf = new Mpdf();
    }
}