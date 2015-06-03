<?php
class files_m extends MY_Model
{
	public $_table_name = 'os-pii-files';
	protected $_order_by = 'id asc';
	public $_priamery_key = 'id';

	public function add_file($file_name,$member_id)
	{
		$add_file = "INSERT INTO `os-pii-files`( `file_name`, `member_id`)
						VALUES ('" . $file_name . "','".$member_id."')";


		return array($this->db->query($add_file),$this->db->insert_id());
	}
	public function add_records($record_id,$file_id)
	{
		$add_records = "INSERT INTO `os-pii-files-records` (`record_id`, `file_id`)
        			VALUES ('" . $record_id . "','" . $file_id . "')";

		return $this->db->query($add_records);
	}
	public function edit_file($file_name,$member_id,$file_id)
	{
		$update_file = "UPDATE `os-pii-files` SET  `file_name` = '" . $file_name . "'
						WHERE `id` = '" . $file_id . "'
						AND `member_id` = '" . $member_id . "' ";

		return $this->db->query($update_file);
	}
	public function delete_file($file_id,$member_id)
	{
		$delete_file = "UPDATE `os-pii-files` SET  `active` = '0'
						WHERE `id` = '" . $file_id . "'
						AND `member_id` = '" . $member_id . "' ";

		return $this->db->query($delete_file);
	}
	public function delete_record($file_id,$member_id,$record_id)
	{
		$delete_record = "UPDATE `os-pii-files-records` SET  `active` = '0'
						WHERE `record_id` = '".$record_id."'
						AND `file_id` IN 
      					( SELECT  `id`
        				FROM `os-pii-files` 
        				WHERE `member_id` = '" . $member_id . "'
        				AND `id` = '" . $file_id . "'
      					) ";

		return $this->db->query($delete_record);
	}
	public function get_file_details($member_id)
	{
		$details = "SELECT `file`.`id`,`file`.`file_name`,`file`.`member_id`
					FROM (`os-pii-files` file)
					WHERE `file`.`member_id` = '".$member_id."'
					AND `file`.`active` =  '1' ";

		return $this->db->query($details)->result_array();
	}
	public function get_files_records($file_id)
	{
		$records = "SELECT `rec`.`record_id`
					FROM (`os-pii-files-records` rec)
					WHERE `rec`.`file_id` = '".$file_id."'
					AND `rec`.`active` =  '1' ";

		return $this->db->query($records)->result_array();
	}
	public function get_records($record_id)
	{
		$get_rec = "SELECT `rec`.`id`, `rec`.`title`, `rec`.`description`, `rec`.`date`, group_concat(DISTINCT records_tag.tagid) as tagid, group_concat(DISTINCT master_tag.tagname) as tagname, group_concat(DISTINCT records_file.filename) as filename
					FROM (`os-pii-member_record` rec)
					LEFT JOIN `os-pii-member-record-files` records_file ON `records_file`.`member_record_id` = `rec`.`id`
					JOIN `os-pii-records-tag` records_tag ON `records_tag`.`recordid` = `rec`.`id`
					JOIN `os-pii-tags_master` master_tag ON `master_tag`.`id` = `records_tag`.`tagid`
					WHERE `rec`.`id` = '".$record_id."'
					AND `rec`.`active` =  '1'
					GROUP BY `rec`.`id`
					ORDER BY `date` desc";

		return $this->db->query($get_rec)->result_array();
	}
	public function get_members_id()
	{
		$this->db->select("members.id");
		$this->db->where("members.userid",$this->session->userdata("id"));
		$this->db->where("members.active","1");
		$this->db->from("os-pii-member members");
		return $this->db->get()->result_array();
	}
	public function get_records_id($member_id)
	{
		$this->db->select("rec.id");
		$this->db->where("rec.member_id",$member_id);
		$this->db->where("rec.active","1");
		$this->db->from("os-pii-member_record rec");
		return $this->db->get()->result_array();
	}
	public function get_tag_details($member_record_id)
	{
		$this->db->select("*");
		$this->db->where('tag.recordid', $member_record_id);
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
	public function get_records_of_files($record_id)
	{
		$get_rec = "SELECT `rec`.`id`, `rec`.`title`, `rec`.`description`, `rec`.`date`
					FROM (`os-pii-member_record` rec)
					LEFT JOIN `os-pii-member-record-files` records_file ON `records_file`.`member_record_id` = `rec`.`id`
					JOIN `os-pii-records-tag` records_tag ON `records_tag`.`recordid` = `rec`.`id`
					JOIN `os-pii-tags_master` master_tag ON `master_tag`.`id` = `records_tag`.`tagid`
					WHERE `rec`.`id` = '".$record_id."'
					AND `rec`.`active` =  '1'
					GROUP BY `rec`.`id`
					ORDER BY `date` desc";

		return $this->db->query($get_rec)->result_array();
	}
	public function count_records($file_id,$member_id)
	{
		$count_file = " SELECT *
						FROM `os-pii-files-records`
						WHERE `active` = '1'
						AND `file_id` IN 
      					( SELECT  `id`
        				FROM `os-pii-files` 
        				WHERE `member_id` = '" . $member_id . "'
        				AND `id` = '" . $file_id . "'
      					) ";

		return $this->db->query($count_file)->result_array();
	}
	public function get_records_of_member($member_id)
	{
		$records = " Select `mem`.`id` as member_id,`rec`.`id` as record_id, `rec`.`title`, `rec`.`description`, `rec`.`date`
				 FROM (`os-pii-member_record` rec)
				 JOIN (`os-pii-member` mem) on `mem`.`id`=`rec`.`member_id`
				 WHERE `member_id` = '" . $member_id . "'
				 AND `rec`.`active` =  '1'
				 GROUP BY `rec`.`id`
				 ORDER BY `date` desc
				 ";

		return $this->db->query($records)->result_array();
	}
}