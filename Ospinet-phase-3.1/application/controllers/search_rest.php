<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class search_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("register_m");
		$this->load->model("contacts_m");
		$this->load->model("notification_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		$search = $this->input->get('search');

		if(filter_var($search, FILTER_VALIDATE_EMAIL))
		{
			 
			$data = $this->register_m->do_search_email($search);
		}
		// ------------ Do NOT DELETE THIS -------------------

		/*    	 if(strpos(trim($search), ' ') !== false)
		 {
		 $search_sp = explode(" ", $search);
		 $data = $this->register_m->do_search($search_sp[0],$search_sp[1]);
		 //  echo $this->db->last_query();
		 }
		 elseif(filter_var($search, FILTER_VALIDATE_EMAIL))
		 {
		 $data = $this->register_m->do_search_email($search);
		 }
		 else
		 {
		 $data = $this->register_m->do_search_fname($search);
		 //echo $this->db->last_query();
		 }*/
		//------------------------------------------------------------
		echo json_encode($data);
	}
	public function index_post()
	{
		$confirm_value = $this->input->post('confirm_id');
		$value = $this->input->post('id');

		$alert_seen_id = $this->input->post('alert_ok_id');
		$alert_type = $this->input->post('alert_type');

		$id = $this->input->post('share_id');
		$toid = $this->input->post('to_ids');
		$fromid = $this->input->post('from_ids');
		$recid = $this->input->post('rec_ids');

		if($value != NULL)
		{
			$data = $this->register_m->ignore_request($value);
		}

		if($confirm_value != NULL)
		{
			$data = $this->register_m->confirm_request($confirm_value);
			$add = $this->register_m->add_to_contacts($confirm_value);
			$add_to_friend = $this->register_m->add_to_friend_contact($confirm_value);
		}

		if($alert_seen_id != NULL & $alert_type != NULL)
		{
			$data = $this->register_m->close_seen_alert($alert_seen_id,$alert_type);
		}

		if($id != NULL)
		{
			if(strpos(trim($id), ' ') !== false)
			{
				$data_ids = array();
				$chk_id = explode(",", $id);
				foreach($chk_id as $key=>$email_name):
				$act_email = explode(" ",$email_name);
				$data_ids1 = $this->register_m->get_contacts_id($act_email[3]);
				array_push($data_ids, $data_ids1[0]);
				$con = $data_ids1[0]['id'];
				$string = json_encode($data_ids1)." , ";
				$edit_str = preg_replace('/[^0-9\-]/', '',$string);
				if(count($con) == ''){
					echo "ERROR";
				}
				else{
					echo $edit_str.",";
				}
				endforeach;
			}
			else{
				echo "ERROR";
			}
		}
		if($toid != NULL & $fromid != NULL & $recid != NULL)
		{
			$i = 0;
			$array_id = explode(" ", $toid);
			foreach ($array_id as $key=>$new_id):
			$count = $this->notification_m->check_notification($new_id,$fromid,$recid);
			echo $count;
			if($count == 0)
			{
				$toids = explode(",", $toid);
				foreach ($toids as $key=>$to_id):
				$data = $this->notification_m->add_to_notification($to_id,$fromid,$recid);
				endforeach;
			}
			$data[$i]["test"] = $count;
			$i++;
			endforeach;
		}
		//	echo json_encode($data);
	}

}