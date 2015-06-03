<?php
class register_m extends MY_Model {
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
	public function delete($id)
	{
		//delete a user
		parent::delete($id);
	}
	public function hash($string){
		return  hash('sha1',$string.config_item('encryption_key'));
	}
	public function loggedin(){
		return (bool) $this->session->userdata('ospinet-loggedin');
	}
	public function login()
	{
		$user_email=$this->get_by(array('email'=>$this->input->post('email')),TRUE);
		if(count($user_email)){
			$user=$this->get_by(array('email'=>$this->input->post('email'),'passwd'=>$this->hash($this->input->post('passwd'))),TRUE);
			if(count($user)){
				if($user->login_status=="mailsent")
				{
					return "4";
				}
				else
				{
					//log in user email
					$data=array('fname'=>$user->fname,'lname'=>$user->lname,'email'=>$user->email,'id'=>$user->id,'roleid'=>$user->roleid,'ospinet-loggedin'=>TRUE);
					$this->session->set_userdata($data);
					$now=date("Y-m-d H:i:s");
					$this->save(array('userid'=>$user->id,'email'=>$user->email,'log_datetime'=>$now,'user_status'=>'User_Login'), NULL,"os-pii-user-log");
					return "2";
				}
			}
			else
			{
				return "3";
			}
		}
		else
		{
			return "1";
		}
	}
	public function logout(){
		$now=date("Y-m-d H:i:s");
		$this->save(array('userid'=>$this->session->userdata('id'),'email'=>$this->session->userdata('email'),'log_datetime'=>$now,'user_status'=>'User_Logout'), NULL,"os-pii-user-log");
		$this->session->sess_destroy();
	}
}