<?php
class My_Controller extends CI_Controller {
	public $data = array ();
	function __construct() {

		parent::__construct ();

		$this->data ['errors'] = array ();
		$this->data ['sitename'] = config_item ( 'site_name' );
	}
}
?>