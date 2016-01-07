<?php
class Admin_Controller extends My_Controller {
	public function __construct() {

		parent::__construct ();

		$this->data ["meta_title"] = "Ospinet";
		$this->load->helper('form', 'url');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_m');
		//Login Cehck
		$exception_uris=array('admin/user/login','admin/user/logout');
		if(in_array(uri_string(),$exception_uris)==FALSE){
			if($this->user_m->loggedin()==FALSE){
				redirect('admin/user/login');
			}
		}

	}
}