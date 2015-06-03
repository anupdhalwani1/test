<?php
class dashboard extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
			
	}
	public function index()
	{
		$this->data['subview'] ="dashboard";
		$this->load->view('_main_layout', $this->data);
	}
}
?>