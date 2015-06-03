<?php
class contacts extends Frontend_Controller
{

	public function __construct()
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		parent::__construct();
		$this->load->model("contacts_m");
		$this->load->model("notification_m");
	}

	public function index()
	{
		$this->data['subview'] = "member/contacts";
		$this->data['linkname']="contact";
		$this->load->view('_member_layout', $this->data);

		//		$this->data['do_search'] = $this->contacts_m->do_search($this->input->post('search'));
	}

}
