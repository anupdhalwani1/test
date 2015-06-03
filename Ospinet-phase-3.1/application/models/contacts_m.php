<?php
class contacts_m extends MY_Model
{
	public $_table_name = 'os-pii-contacts';
	protected $_order_by = 'id asc';
	public $_priamery_key = 'id';


	public function get_new()
	{
		$contacts            = new stdClass();
		$contacts->id        = '';
		$contacts->userid    = '';
		$contacts->friend_id = '';
		return $contacts;
	}

	public function get_contacts()
	{
		$query = "select u.`fname`,m.`age`,m.`gender`,u.`id`, u.`email`, u.`lname`,m.`profile_pic`,m.`type`
					from `os-pii-contacts` con 
					join `os-pii-user` u on u.id = con.`friend_id` 
					join `os-pii-member` m on m.id = u.`first_member_id`
					where con.`userid` =" . $this->session->userdata('id') . " ORDER BY `u`.`fname` ASC";

		return $this->db->query($query)->result_array();

	}
	public function get_contacts_count()
	{
		$this->db->select("*");
		$this->db->where("contacts.userid", $this->session->userdata("id"));
		$this->db->from("os-pii-contacts contacts");
		return $this->db->get()->num_rows();
	}
	public function get_share_contacts()
	{
		$share = "select u.`fname`,con.`id`,con.`friend_id`,u.`email`, u.`lname`
					from `os-pii-contacts` con 
					join `os-pii-user` u on u.id = con.`friend_id` 
					join `os-pii-member` m on m.id = u.`first_member_id`
					where con.`userid` =" . $this->session->userdata('id') . " ORDER BY `u`.`fname` ASC";

		return $this->db->query($share)->result_array();
	}
	/*	public function check_id_in_contacts($id)
	 {
	 $this->db->select("*");
	 $this->db->where("contacts.userid",$this->session->userdata("id"));
	 $this->db->where("contacts.friend_id",$id);
	 $this->db->from("os-pii-contacts contacts");
	 return $this->db->get()->num_rows();
	 } */
	/*	public function get_request_count()
	 {
	 $this->db->select("*");
	 $this->db->where("contacts.userid",$this->session->userdata("id"));
	 $this->db->from("os-pii-contacts contacts");
	 return $this->db->get()->num_rows();
	 }*/
}