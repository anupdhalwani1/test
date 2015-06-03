<?php
class demo extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		//$this->data['subview'] ="contactus";
		$this->load->view('templates/demo', $this->data);	}
}
?>