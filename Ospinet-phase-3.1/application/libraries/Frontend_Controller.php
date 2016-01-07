<?php
//Log out Back
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies

class Frontend_Controller extends My_Controller {
	function __construct() {
		parent::__construct ();
		//var_dump ( "Welcome form frontend controller" );
		$this->load->helper('form', 'url');
		$this->load->library('session');
		// Load stuff
		// Fetch navigation
		$this->data['meta_title'] = config_item('site_name');
		$this->load->model('register_m');
		//Login Cehck
		$exception_uris=array('home','register','contactus','faqs');
		$string_class=$this->router->fetch_class();
		if(in_array($string_class,$exception_uris)==FALSE ){
			if($this->register_m->loggedin()==FALSE){
				redirect(base_url());
			}
		}
		$this->load->model('member_m');
		$this->load->model("contacts_m");
		$this->load->model("notification_m");
		$this->data['linkname']="";
		$this->data["contactcount"] = $this->contacts_m->get_contacts_count();
		$this->data["get_frst_mmbr"]= $this->member_m->get_frst_mmbr();
		//        $this->data["profile_image"]= $this->member_m->get_image_name();
		$this->data["first_login_member"] = $this->register_m->get_first_member($this->session->userdata('email'));
		$this->data["contactcount"] = $this->contacts_m->get_contacts_count();
		$this->data["requestcount"] = $this->notification_m->get_request_count();
		$this->data["requestpopup"] = $this->notification_m->get_request_popup();
		//        var_dump($this->data["requestpopup"]);
		//        echo $this->db->last_query();
		$inactive_records = $this->notification_m->get_inactive_share_doc();
		if (Count($inactive_records) != 0) {
			foreach ($inactive_records as $key => $deleted_rec):
			$delete = $this->notification_m->delete_inactive_records($deleted_rec['member_record_id']);
			endforeach;
		}

		$record_count              = count($this->notification_m->check_alerts_share());
		$request_count             = count($this->notification_m->check_alerts_request());
		$count                     = $record_count + $request_count;
		$this->data["alertscount"] = $count;

		$request      = $this->notification_m->check_alerts_request();
		$record_share = $this->notification_m->check_alerts_share();

		$friends = array();
		$doc     = array();

		if (count($record_share) == 0) {
			foreach ($request as $friend):
			$friends                  = $this->notification_m->alert_messages($friend['type_id']);
			$this->data["alertpopup"] = $friends;
			endforeach;
		}
		if (count($request) == 0) {
			foreach ($record_share as $share):
			$doc                      = $this->notification_m->alert_messages($share['type_id']);
			$this->data["alertpopup"] = $doc;
			endforeach;
		}
		if (count($request) != 0 && count($record_share) != 0) {
			foreach ($request as $friend):
			$friends = $this->notification_m->alert_messages($friend['type_id']);
			foreach ($record_share as $share):
			$doc = $this->notification_m->alert_messages($share['type_id']);
			endforeach;
			$popup                    = array_merge($doc, $friends);
			$this->data["alertpopup"] = $popup;
			endforeach;
		}

		$request_id = $this->input->post('send_request_to');
		if ($request_id != NULL) {
			$data = $this->notification_m->send_request($request_id);
		}

	}
	public function get_contacts()
	{
		$names1 = $this->contacts_m->get_share_contacts();
		foreach ($names1 as $name_list):
		echo $str = $name_list["fname"] . " " . $name_list["lname"] . " [ " . $name_list["email"] . " ],";
		endforeach;
	}

}
?>