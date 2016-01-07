<?php
class Faqs extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		//$this->load->view('templates/contactus', $this->data);
		$this->data['subview'] ="faqs";
		$this->load->view('_main_layout', $this->data);
	}
}
?>