<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Files_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("files_m");
		$this->load->model("member_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		$mem_id = $this->member_m->get_members();
		foreach ($mem_id as $member_id):
		$data = $this->files_m->get_file_details($member_id["id"]);
		if(count($data) != '0'){
			$i=0;
			foreach ($data as $file_id):
			$rec_id = $this->files_m->get_files_records($file_id['id']);
			$j=0;
			foreach ($rec_id as $id):
			$k=0;
			$l=0;
			foreach ($id as $record['record_id']):
			$file_id["records"][$j] = $this->files_m->get_records_of_files($record['record_id']);
			$file_id["records"][$j][$k]["tags"] = $this->files_m->get_tag_details($record['record_id']);
			$file_id["records"][$j][$l]["files"] = $this->files_m->get_files_details($record['record_id']);
			$j++;
			$k++;
			$l++;
			endforeach;
			endforeach;
			$val[$i++] = $file_id;
			endforeach;
		}
		endforeach;
		echo json_encode($val);
	}
	public function index_post()
	{
		// Delete File
		$memberid = $this->input->post('memberid');
		$fileid = $this->input->post('fileid');

		if($fileid != NULL && $memberid !=NULL){
			$delete_file = $this->files_m->delete_file($fileid,$memberid);
		}

		// Delete Record
		$record_id = $this->input->post('record_id');
		$member_id = $this->input->post('member_id');
		$file_id = $this->input->post('file_id');

		if($file_id != NULL && $member_id !=NULL && $record_id !=NULL){
			$delete = $this->files_m->delete_record($file_id,$member_id,$record_id);
		}
		if($file_id != NULL && $member_id !=NULL){
			$records = $this->files_m->count_records($file_id,$member_id);
			if(count($records) == 1)
			{
				echo "NO";
			}else{
				echo "YES";
			}
		}

		//Select records to add into file
		$rec = $this->input->post('record');

		if($rec == "select"){
			$records["rec"] = $this->files_m->select_records();
			echo json_encode($records);
		}

		$id    = $this->input->post('id');
		if($id != NULL){
		$record_ids = $this->files_m->get_files_records($id);
/*		$rs    = "";
		foreach ($record_ids as $rec_id):
		$rs .= $rec_id["record_id"] . " ,";
		endforeach; */
		echo count($record_ids);
		}
	}
}