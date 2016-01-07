<?php
require (APPPATH.'libraries/REST_Controller.php');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class record_rest extends REST_Controller{
	public function __construct() {
		parent::__construct ();
		error_reporting(E_ALL | E_STRICT);
		$this->load->model("member_record_m");
		$this->load->model("notification_m");
		$this->load->library('session');
	}

	public function index_get()
	{
		$arr=$this->member_m->get_members();
		echo json_encode($arr);
	}

	public function index_post()
	{
		$record_id = $this->input->post('rec_id');
		if($record_id != NULL)
		{
			$data = $this->notification_m->get_share_rec_count($record_id);
		}
		//save data
		echo json_encode($data);

	}

	public function index_put()
	{

		echo json_encode($data);
	}

	public function index_delete()
	{

		echo $data;

	}
}