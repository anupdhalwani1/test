<?php
class register_m extends MY_Model
{
	public $_table_name = 'os-pii-user';
	protected $_order_by = 'id';
	public $_priamery_key = 'id';


	public function get_new()
	{
		$user               = new stdClass();
		$user->fname        = '';
		$user->lname        = '';
		$user->email        = '';
		$user->pwd          = '';
		$user->id           = '';
		$user->login_status = '';
		$user->roleid       = '';
		$user->usertype		= '';
		return $user;
	}
	public function delete($id)
	{
		//delete a user
		parent::delete($id);
	}
	public function hash($string)
	{
		return hash('sha1', $string . config_item('encryption_key'));
	}
	public function loggedin()
	{
		return (bool) $this->session->userdata('ospinet-loggedin');
		echo var_dump($this->session->userdata('ospinet-loggedin'));
	}
	public function login($email, $password, $from)
	{
		$user_email = $this->get_by(array(
            'email' => $email
		), TRUE);

		if (count($user_email)) {
			$user = $this->get_by(array(
                'email' => $email,
                'passwd' => $this->hash($password)
			), TRUE);
			if (count($user)) {
				if ($user->login_status == "mailsent") {
					return "4";
				} else if ($user->login_status == "passwordnotset") {
					return "5";
				} else {
					//log in user email
					if ($from == "Website") {
						$data = array(
                            'fname' => $user->fname,
                            'lname' => $user->lname,
                            'email' => $user->email,
                            'id' => $user->id,
                            'roleid' => $user->roleid,
                        	'usertype' => $user->usertype,
                            'ospinet-loggedin' => TRUE
						);
						$this->session->set_userdata($data);
					}
					$now = date("Y-m-d H:i:s");
					$this->save(array(
                        'userid' => $user->id,
                        'email' => $user->email,
                        'log_datetime' => $now,
                        'user_status' => 'User_Login'
                        ), NULL, "os-pii-user-log");
                        return "2";
				}
			} else {
				return "3";
			}
		} else {
			return "1";
		}
	}
	public function logout()
	{
		$now = date("Y-m-d H:i:s");
		$this->save(array(
            'userid' => $this->session->userdata('id'),
            'email' => $this->session->userdata('email'),
            'log_datetime' => $now,
            'user_status' => 'User_Logout'
            ), NULL, "os-pii-user-log");
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
            $this->session->sess_destroy();
	}
	public function get_first_member($email)
	{
		$this->db->select('first_member_id');
		$this->db->from('os-pii-user');
		$this->db->where('email', $email);
		return $this->db->get()->result_array();
	}
	public function resend_mail_details($email)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		return $this->db->get('os-pii-user')->result_array();

	}
	// ------------ Do NOT DELETE THIS -------------------

	/*	public function do_search($fname,$lname)
	 {
	 $where = "login_status='confirm' AND  (`fname`  = '$fname' AND  `lname`  = '$lname')";
	 $where1 = "user.id NOT IN (SELECT `friend_id` from `os-pii-contacts` WHERE `userid` = ".$this->session->userdata("id").")";
	 $this->db->select("user.id,user.fname,user.lname,user.email,user.login_status,notification.request_status ns,notification.to_user_id uid");
	 $this->db->where($where,NULL,false);
	 $this->db->from('os-pii-user user');
	 $this->db->where($where1,NULL,false);
	 $this->db->where("user.id !=",$this->session->userdata("id"));
	 $this->db->join("os-pii-request-notification notification","notification.to_user_id = user.id",'left');

	 return $this->db->get()->result_array();
	 }
	 public function do_search_fname($fname)
	 {
	 $where = "login_status='confirm' AND (`fname`  LIKE '%$fname%' OR  `lname`  LIKE '%$fname%')";
	 $where1 = "user.id NOT IN (SELECT `friend_id` from `os-pii-contacts` WHERE `userid` = ".$this->session->userdata("id").")";
	 $this->db->select("user.id,user.fname,user.lname,user.email,user.login_status,notification.request_status ns,notification.to_user_id uid");
	 $this->db->where($where,NULL,false);
	 $this->db->from('os-pii-user user');
	 $this->db->where($where1,NULL,false);
	 $this->db->where("user.id !=",$this->session->userdata("id"));
	 $this->db->join("os-pii-request-notification notification","notification.to_user_id = user.id",'left');

	 return $this->db->get()->result_array();
	 }
	 -----------------------------------------------------*/
	public function do_search_email($email,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;

		$where  = "login_status = 'confirm' AND  (`user`.`email`  = '".$email."')";
		$where1 = "user.id NOT IN (SELECT `friend_id` from `os-pii-contacts` WHERE `userid` = " . $user_id . ")";
		$this->db->select("user.id,user.fname,user.lname,user.email,user.login_status,member.profile_pic,member.type,member.id,notification.request_status ns,notification.to_user_id uid");
		$this->db->distinct();
		$this->db->where($where, NULL, false);
		$this->db->from('os-pii-user user');
		$this->db->where($where1, NULL, false);
		$this->db->where("user.id !=", $user_id);
		$this->db->join("os-pii-member member", "member.id = user.first_member_id", 'left');
		$this->db->join("os-pii-request-notification notification", "notification.to_user_id = user.id AND  notification.from_user_id = ". $user_id."", 'left');
		//   $this->db->join("os-pii-request-notification notification", "notification.to_user_id = user.first_member_id" AND " notification.from_user_id = ". $this->session->userdata("id")." ", 'left');

		return $this->db->get()->result_array();
	}
	public function ignore_request($value,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->set("request_status", "ignored");
		$this->db->where("from_user_id", $value);
		$this->db->where("to_user_id", $user_id);
		$this->db->update("os-pii-request-notification");
	}
	public function confirm_request($confirm_value,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->set("request_status", "confirm");
		$this->db->where("from_user_id", $confirm_value);
		$this->db->where("to_user_id", $user_id);
		$this->db->update("os-pii-request-notification");
	}
	public function add_to_contacts($confirm_value,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$add = "INSERT INTO `os-pii-contacts`(`userid`, `friend_id`)
		(SELECT `to_user_id`,`from_user_id` 
		FROM `os-pii-request-notification` 
		WHERE `request_status` = 'confirm' 
		AND `to_user_id` = " . $user_id . "  
		AND `from_user_id` = " . $confirm_value . ")";

		return $this->db->query($add);
	}
	public function add_to_friend_contact($confirm_value,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$add = "INSERT INTO `os-pii-contacts`( `friend_id`,`userid`)
		(SELECT `to_user_id`,`from_user_id` 
		FROM `os-pii-request-notification` 
		WHERE `request_status` = 'confirm' 
		AND `to_user_id` =  " . $user_id . "   
		AND `from_user_id` = " . $confirm_value . ")";

		return $this->db->query($add);
	}
	public function close_seen_alert($alert_seen_id, $alert_type,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		if ($alert_type == "doc_share") {
			$this->db->set("is_seen", "1");
			$this->db->set("request_status", "confirm");
			$this->db->where("from_user_id", $alert_seen_id);
			$this->db->where("to_user_id", $user_id);
			$this->db->where("type_id", "doc_share");
			$this->db->or_where("type_id", "friend_request");
			$this->db->update("os-pii-request-notification");
		} else {
			$this->db->set("is_seen", "1");
			$this->db->where("from_user_id", $user_id);
			$this->db->where("to_user_id", $alert_seen_id);
			$this->db->where("type_id", "$alert_type");
			$this->db->update("os-pii-request-notification");
		}
	}
	public function get_contacts_id($email)
	{
		$this->db->select("id");
		$this->db->where("email", $email);
		$this->db->from("os-pii-user");
		return $this->db->get()->result_array();
	}

}