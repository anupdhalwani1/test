<?php
class member_record_m extends MY_Model {
	public $_table_name = 'os-pii-member_record';
	protected $_order_by = 'os-pii-member_record.id asc';
	public  $_priamery_key = 'os-pii-member_record.id';


	public function get_new(){
		$member_record = new stdClass();
		$member_record->id ='';
		$member_record->title ='';
		$member_record->description ='';
		$member_record->member_id='';
		$member_record->record_file ='';
		$member_record->fname = '';
		$member_record->lname = '';
		$member_record->gender = '';
		$member_record->birth_info ='';
		$member_record->birth_day ='';
		$member_record->birth_month ='';
		$member_record->birth_year ='';
		$member_record->age ='';
		$member_record->active ='1';
		return $member_record;
	}
	public function delete($id)
	{
		//delete a member_record
		parent::delete($id);
	}
	public function get_record($id)
	{
		$record = "	SELECT `records`.`title`, `records`.`description`, `records`.`id`, `records`.`date`, `notif`.`to_user_id`, GROUP_CONCAT(CONCAT_WS('',user.fname,' ',user.lname)) as name
					FROM (`os-pii-member_record` records)
					LEFT JOIN `os-pii-request-notification` notif ON `notif`.`member_record_id` = `records`.`id`
				    LEFT JOIN `os-pii-user` user ON `user`.`id` = `notif`.`to_user_id`
					WHERE `records`.`member_id` =  ".$id."
					AND `records`.`active` =  1
					GROUP BY `records`.`id`
					ORDER BY `date` desc";
		return $this->db->query($record)->result_array();
	}
	public function get_records_for_android($id)
	{
		$this->db->select("records.title,records.description,records.id,records.date,group_concat(DISTINCT records_file.filename) as filename,group_concat(DISTINCT records_tag.tagid) as tagid,group_concat(DISTINCT master_tag.tagname) as tagname");
		$this->db->where("records.member_id",$id);
		$this->db->where("records.active",1);
		$this->db->order_by("date","desc");
		$this->db->from("os-pii-member_record records");
		$this->db->join("os-pii-member-record-files records_file","records_file.member_record_id = records.id",'left');
		$this->db->join("os-pii-records-tag records_tag","records_tag.recordid = records.id");
		$this->db->join("os-pii-tags_master master_tag","master_tag.id = records_tag.tagid");
		$this->db->group_by("records.id");
		return $this->db->get()->result_array();
	}
	public function get_record_files($id)
	{
		$this->db->select("*");
		$this->db->where("member_record_id",$id);
		$this->db->where("active",1);
		$this->db->from("os-pii-member-record-files");
		return $this->db->get()->result_array();
	}
	public function remove_file($filename,$record_id,$member_id)
	{
		$this->db->set("active", "0");
		$this->db->where("member_id", $member_id);
		$this->db->where("member_record_id",$record_id);
		$this->db->where("filename",$filename);
		$this->db->update("os-pii-member-record-files");
	}
	public function check_records($record_id,$member_id)
	{
		$this->db->select("*");
		$this->db->where("member_id", $member_id);
		$this->db->where("member_record_id",$record_id);
		$this->db->where("active","1");
		$this->db->from("os-pii-member-record-files");
		return $this->db->get()->result_array();
	}
	public function get_all_temp()
	{
		$this->db->select("*");
		return $this->db->get("os-pii-member-temp-record-file")->result_array();
	}

	public function get_record_tags($id)
	{
		$this->db->select("tags_master.tagname");
		$this->db->where("tags.recordid",$id);
		$this->db->from("os-pii-records-tag tags");
		$this->db->join("os-pii-tags_master tags_master","tags_master.id=tags.tagid");
		return $this->db->get()->result_array();
	}
	public function check_tagname($tagname)
	{
		$this->db->select("*");
		$this->db->where("tagname",$tagname);
		$this->db->where("userid",$this->session->userdata('id'));
		$this->db->from("os-pii-tags_master");

		return $this->db->get()->result_array();

	}
	public function get_tags()
	{
		$this->db->select("tagname");
		$this->db->where("userid",$this->session->userdata("id"));
		$this->db->from("os-pii-tags_master");
		return $this->db->get()->result_array();
	}
	public function find_records($mem_id,$type,$input)
	{
		if($type == "title")
		{
			$query = "SELECT `records`.`id`, `records`.`title`,`records`.`member_id`,`records`.`active`,group_concat(DISTINCT `user`.`fname`,' ', `user`.lname) as shared_with_name,
					group_concat(DISTINCT records.description) as description, `records`.`date`, group_concat(DISTINCT `record_tag`.`tagid`) as tagid, 
					group_concat(DISTINCT `master_tag`.`tagname`) as tagname, group_concat(DISTINCT `records_file`.`filename`) as filename 
					FROM (`os-pii-member_record` records) 
					LEFT JOIN `os-pii-member-record-files` records_file ON `records_file`.`member_record_id` = `records`.`id` 
					JOIN `os-pii-records-tag` record_tag ON `record_tag`.`recordid` = `records`.`id` 
					JOIN `os-pii-tags_master` master_tag ON `master_tag`.`id` = `record_tag`.`tagid` 
					LEFT JOIN `os-pii-request-notification` notif ON `notif`.`member_record_id` = `records`.`id` 
					LEFT JOIN `os-pii-user` user ON `user`.`id` = `notif`.`to_user_id` 
					WHERE `records`.`member_id` IN ('$mem_id')";
			if(count($input)){
				$query .=" AND ";
				for($i=0;$i<count($input);$i++){
					if($input[$i]!=""){
						$query .=($i>0)?" OR ":"";
						$query .=" `records`.`title` LIKE('%$input[$i]%') ";
					}
				}
			}
				
			$query .="GROUP BY `records`.`id`";
			return $this->db->query($query)->result_array();
		}
		if($type == "tag")
		{
			$query = "SELECT `records`.`id`, `records`.`title`,`records`.`member_id`,`records`.`active`,group_concat(DISTINCT `user`.`fname`,' ', `user`.lname) as shared_with_name,
					group_concat(DISTINCT records.description) as description, `records`.`date`, group_concat(DISTINCT `record_tag`.`tagid`) as tagid, 
					group_concat(DISTINCT `master_tag`.`tagname`) as tagname, group_concat(DISTINCT `records_file`.`filename`) as filename 
					FROM (`os-pii-member_record` records) 
					LEFT JOIN `os-pii-member-record-files` records_file ON `records_file`.`member_record_id` = `records`.`id` 
					JOIN `os-pii-records-tag` record_tag ON `record_tag`.`recordid` = `records`.`id` 
					JOIN `os-pii-tags_master` master_tag ON `master_tag`.`id` = `record_tag`.`tagid` 
					LEFT JOIN `os-pii-request-notification` notif ON `notif`.`member_record_id` = `records`.`id` 
					LEFT JOIN `os-pii-user` user ON `user`.`id` = `notif`.`to_user_id` 
					WHERE `records`.`member_id` IN ('$mem_id')";
			if(count($input)){
				$query .=" AND ";
				for($i=0;$i<count($input);$i++){
					if($input[$i]!=""){
						$query .=($i>0)?" OR ":"";
						$query .=" `master_tag`.`tagname` LIKE('%$input[$i]%') ";
					}
				}
			}
				
			$query .="GROUP BY `records`.`id`";
				
			return $this->db->query($query)->result_array();
		}
		if($type == "description")
		{
			$query = "SELECT `records`.`id`, `records`.`title`,`records`.`member_id`,`records`.`active`, group_concat(DISTINCT `user`.`fname`,' ', `user`.lname) as shared_with_name,
					group_concat(DISTINCT `records`.`description`) as description, `records`.`date`, group_concat(DISTINCT `record_tag`.`tagid`) as tagid, 
					group_concat(DISTINCT `master_tag`.`tagname`) as tagname, group_concat(DISTINCT `records_file`.`filename`) as filename 
					FROM (`os-pii-member_record` records) 
					LEFT JOIN `os-pii-member-record-files` records_file ON `records_file`.`member_record_id` = `records`.`id` 
					JOIN `os-pii-records-tag` record_tag ON `record_tag`.`recordid` = `records`.`id` 
					JOIN `os-pii-tags_master` master_tag ON `master_tag`.`id` = `record_tag`.`tagid` 
					LEFT JOIN `os-pii-request-notification` notif ON `notif`.`member_record_id` = `records`.`id` 
					LEFT JOIN `os-pii-user` user ON `user`.`id` = `notif`.`to_user_id` 
					WHERE `records`.`member_id` IN ('$mem_id')";
			if(count($input)){
				$query .=" AND ";
				for($i=0;$i<count($input);$i++){
					if($input[$i]!=""){
						$query .=($i>0)?" OR ":"";
						$query .=" `records`.`description` LIKE('%$input[$i]%') ";
					}
				}
			}
				
			$query .="GROUP BY `records`.`id`";
			return $this->db->query($query)->result_array();
		}
	}
	/*	public function get_names($id)
	 {
		$names = "SELECT GROUP_CONCAT(CONCAT_WS('',user.fname,' ',user.lname)) AS names
		FROM (`os-pii-request-notification` notif)
		JOIN `os-pii-user` user ON `user`.`id` = `notif`.to_user_id
		WHERE `notif`.`member_record_id` =  ".$id." ";
		return $this->db->query($names)->result();
		} */
}