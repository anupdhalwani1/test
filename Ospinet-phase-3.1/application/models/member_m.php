<?php
class member_m extends MY_Model {
	public $_table_name = 'os-pii-member';
	protected $_order_by = 'id asc';
	public  $_priamery_key = 'id';


	public function get_new(){
		$member = new stdClass();
		$member->id ='';
		$member->fname = '';
		$member->lname = '';
		$member->gender = '';
		$member->birth_info ='';
		$member->birth_day ='';
		$member->birth_month ='';
		$member->birth_year ='';
		$member->age ='';
		$member->active ='1';
		$member->userid ='';
		return $member;
	}
	public function delete($id)
	{
		//delete a member
		parent::delete($id);
	}
	public function get_members()
	{
		$this->db->select("members.*");
		$this->db->where("members.userid",$this->session->userdata("id"));
		$this->db->where("members.active","1");
		$this->db->from("os-pii-member members");
		//$this->db->join("os-pii-user-log userlog","members.userid = userlog.userid","left");
		return $this->db->get()->result_array();
	}
	public function user_first_login()
	{
		$this->db->select("*");
		$this->db->where("userid",$this->session->userdata("id"));
		$this->db->where("user_status","User_Login");
		return $this->db->get("os-pii-user-log")->result_array();
	}
	public function get_frst_mmbr()
	{
		$this->db->select("user.first_member_id,member.profile_pic,member.type,member.id");
		$this->db->join("os-pii-member member", "member.id = user.first_member_id");
		$this->db->where("user.id",$this->session->userdata("id"));
		return $this->db->get("os-pii-user user")->result_array();
	}
	public function edit_mem($member_id, $data1)
	{
		$this->db->where('id', $member_id);
		$this->db->update('os-pii-member', $data1);
	}
	public function get_contacts($userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->select("contacts.friend_id,member.fname,member.lname,member.email");
		$this->db->where("contacts.userid",$user_id);
		$this->db->where("contacts.confirm_status","1");
		$this->db->join("os-pii-member member","member.id = contacts.friend_id");
		$this->db->order_by("fname", "asc");
		return $this->db->get("os-pii-contacts contacts")->result_array();
	}

}