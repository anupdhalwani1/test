<?php
class user extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_m');

	}
	public function index()
	{
		$this->data['subview'] ="user/index";
		$this->data['rc_list'] = $this->user_m->get();
		$this->load->view('_main_layout', $this->data);

	}
}
?>