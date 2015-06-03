<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Contacts_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("contacts_m");
		$this->load->model("notification_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		 
		$data = array();
		$rec_id = array();
		$empty = array();
		 
		$data = $this->contacts_m->get_contacts();
		$j = 0;
		$k = 0;
		$i = 0;
		foreach ($data as $contact_id):
		$rec_id = $this->notification_m->get_mem_record_id($contact_id['id']);
		if (count($rec_id)!= 0)
		{
			foreach ($rec_id as $record_id):
			$tag =  $this->notification_m->get_tag_details($record_id['member_record_id'],$record_id['from_user_id']);
			$file_names =  $this->notification_m->get_files_details($record_id['member_record_id']);
			$rec_id[$k]["tags"] = $tag;
			$rec_id[$j]["files"] = $file_names;
			$data[$i]["records"] = $rec_id;
			$k++;
			$j++;
			endforeach;
		}
		$k = 0;
		$j = 0;
		if (count($rec_id)== 0)
		{
			$data[$i]["records"] = $empty;
		}
		$i++;
		endforeach;
		echo json_encode($data);
	}

}