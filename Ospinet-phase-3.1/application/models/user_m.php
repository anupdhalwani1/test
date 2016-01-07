<?php
class user_m extends MY_Model {
	public $_table_name = 'os-pii-user';
	protected $_order_by = 'id';
	public  $_priamery_key = 'id';


	public function get_new(){
		$user = new stdClass();
		$user->fname = '';
		$user->lname = '';
		$user->email = '';
		$user->pwd ='';
		$user->id ='';
		$user->login_status ='';
		$user->roleid='';
		return $user;
	}

}