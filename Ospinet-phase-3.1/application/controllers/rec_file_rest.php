<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Rec_file_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("files_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		$members_id = $this->files_m->get_members_id();
		$i=0;
		foreach($members_id as $mem_id){
		$val[$i++] = $this->files_m->get_records_of_member($mem_id['id']);
		}
		echo json_encode($val);
	}
}