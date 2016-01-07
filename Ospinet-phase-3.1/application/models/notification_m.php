<?php
class notification_m extends MY_Model
{
	public $_table_name = 'os-pii-request-notification';
	protected $_order_by = 'id asc';
	public $_priamery_key = 'id';


	public function get_new()
	{
		$notification                   = new stdClass();
		$notification->id               = '';
		$notification->type_id          = '';
		$notification->from_user_id     = '';
		$notification->to_user_id       = '';
		$notification->request_status   = '';
		$notification->is_seen          = '';
		$notification->member_record_id = '';
		return $notification;
	}
	public function get_request_count($userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->select("*");
		$this->db->where("notification.to_user_id", $user_id);
		$this->db->where("notification.request_status", "pending");
		$this->db->where("notification.type_id", "friend_request");
		$this->db->from("os-pii-request-notification notification");
		return $this->db->get()->num_rows();
	}
	public function get_request_popup($userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->select("notification.id,usr.fname,usr.lname,member.profile_pic,member.type,member.userid");
		$this->db->where("notification.to_user_id", $user_id);
		$this->db->where("notification.is_seen", '0');
		$this->db->where("notification.request_status", "pending");
		$this->db->where("notification.type_id", "friend_request");
		$this->db->from("os-pii-request-notification notification");
		$this->db->join("os-pii-user usr", "usr.id = notification.from_user_id", 'left');
		$this->db->join("os-pii-member member", "member.id = usr.first_member_id", 'left');
		return $this->db->get()->result();
	}
	public function send_request($id,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$send_request = "INSERT INTO `os-pii-request-notification`( `from_user_id`, `to_user_id`, `type_id`)
						VALUES (" . $user_id . "," . $id . ",'friend_request')";

		return $this->db->query($send_request);
	}
	public function alert_messages($type_id,$userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		if ($type_id == "friend_request") {
			$this->db->select("*");
			$this->db->where("from_user_id", $user_id);
			$this->db->where("is_seen", '0');
			$this->db->where("request_status", "confirm");
			$this->db->where("type_id", "friend_request");
			$this->db->from("os-pii-request-notification notification");
			$this->db->join("os-pii-user user", "user.id = notification.to_user_id");
			return $this->db->get()->result_array();
		}
		if ($type_id == "doc_share") {
			$this->db->select("*");
			$this->db->where("to_user_id", $user_id);
			$this->db->where("is_seen", '0');
			$this->db->where("request_status", "confirm");
			$this->db->where("type_id", "doc_share");
			$this->db->from("os-pii-request-notification notification");
			$this->db->join("os-pii-user user", "user.id = notification.from_user_id");
			return $this->db->get()->result_array();
		}

	}
	public function check_alerts_share($userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->select("*");
		$this->db->where("notification.to_user_id", $user_id);
		$this->db->where("notification.request_status", "confirm");
		$this->db->where("notification.type_id", "doc_share");
		$this->db->where("notification.is_seen", "0");
		$this->db->from("os-pii-request-notification notification");
		return $this->db->get()->result_array();
	}
	public function check_alerts_request($userid = NULL)
	{
		$user_id = ($userid == NULL)? $this->session->userdata("id") : $userid;
		 
		$this->db->select("*");
		$this->db->where("notification.from_user_id", $user_id);
		$this->db->where("notification.request_status", "confirm");
		$this->db->where("notification.type_id", "friend_request");
		$this->db->where("notification.is_seen", "0");
		$this->db->from("os-pii-request-notification notification");
		return $this->db->get()->result_array();
	}
	public function check_notification($to_id, $from_id, $rec_id)
	{
		$this->db->select("*");
		$this->db->where("from_user_id", $from_id);
		$this->db->where("to_user_id", $to_id);
		$this->db->where("member_record_id", $rec_id);
		$this->db->where("request_status", "confirm");
		$this->db->where("type_id", "doc_share");
		$this->db->from("os-pii-request-notification");
		return $this->db->get()->num_rows();
	}
	public function add_to_notification($to_id, $from_id, $rec_id)
	{
		$share_record = "INSERT INTO `os-pii-request-notification`( `from_user_id`, `to_user_id`, `type_id`,`member_record_id`,`request_status`)
						VALUES ($from_id,$to_id,'doc_share',$rec_id,'confirm')";

		return $this->db->query($share_record);
	}
	public function get_mem_record_id($contact_id)
	{
		$this->db->select("*");
		$this->db->where("from_user_id", $contact_id);
		$this->db->where("to_user_id", $this->session->userdata("id"));
		$this->db->where("type_id", "doc_share");
		$this->db->from("os-pii-request-notification nt");
		$this->db->join('os-pii-member_record rec', 'rec.id = nt.member_record_id', 'left');
		return $this->db->get()->result_array();
	}
	public function get_tag_details($member_record_id, $from_user_id)
	{
		$this->db->select("*");
		$this->db->where('tag.recordid', $member_record_id);
		$this->db->where('tag_m.userid', $from_user_id);
		$this->db->from("os-pii-records-tag tag");
		$this->db->join("os-pii-tags_master tag_m", 'tag_m.id = tag.tagid');
		return $this->db->get()->result_array();
	}
	public function get_files_details($member_record_id)
	{
		$this->db->select("*");
		$this->db->where('member_record_id', $member_record_id);
		$this->db->from("os-pii-member-record-files rec_files");
		return $this->db->get()->result_array();
	}
	public function get_share_rec_count($record_id)
	{
		$this->db->select("*");
		$this->db->where("notification.from_user_id", $this->session->userdata("id"));
		$this->db->where("notification.type_id", "doc_share");
		$this->db->where("notification.member_record_id", $record_id);
		$this->db->from("os-pii-request-notification notification");
		return $this->db->get()->num_rows();
	}
	public function get_inactive_share_doc()
	{
		$this->db->select("member_record_id");
		$this->db->where("notification.to_user_id", $this->session->userdata("id"));
		$this->db->where("notification.type_id", "doc_share");
		$this->db->where("mem_rec.active", "0");
		$this->db->from("os-pii-request-notification notification");
		$this->db->join("os-pii-member_record mem_rec", 'mem_rec.id = notification.member_record_id');
		return $this->db->get()->result_array();
	}
	public function delete_inactive_records($deleted_rec)
	{
		$delete = "DELETE FROM `os-pii-request-notification`
				   WHERE `to_user_id` = " . $this->session->userdata("id") . " 
				   AND `type_id` = 'doc_share' 
				   AND `member_record_id` = " . $deleted_rec . "";
		return $this->db->query($delete);
	}
	public function get_toids($id)
	{
		$this->db->select("to_user_id");
		$this->db->where("notification.from_user_id", $this->session->userdata("id"));
		$this->db->where("notification.type_id", "doc_share");
		$this->db->where("member_record_id", $id);
		$this->db->from("os-pii-request-notification notification");
		return $this->db->get()->result_array();
	}
	public function get_share_with_names($id)
	{
		$this->db->select("user.fname,user.lname");
		$this->db->where("user.id",$id);
		$this->db->from("os-pii-user user");
		return $this->db->get()->result_array();
	}
}