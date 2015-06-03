<?php
class home extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
		if($this->register_m->loggedin()==TRUE)
		redirect("member");
	}

	public function index()
	{
		$this->data['subview'] ="user/home";
		$this->load->view('_main_layout', $this->data);
	}

}
?>