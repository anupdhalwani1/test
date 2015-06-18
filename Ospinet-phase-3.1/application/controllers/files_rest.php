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
		$this->load->model("register_m");
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
		$arry=array();
		$mem_id = $this->files_m->get_members_id();		
		if(count($mem_id) != '0'){
			$msg = "";
			foreach ($mem_id as $member_id):
			$records = $this->files_m->get_all_records($member_id['id']);
			foreach ($records as $rec_details):
			$msg.= '<div class="box-generic padding-none" id="'.$rec_details['id'].'" style="border:1px solid #CECECE">
						<a id='.$rec_details["id"].' class="report_edit_btn"><h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width: 380px;">'.$rec_details["title"].'
						<input type="checkbox" id="check_records" name="records" class="check_records" value="'.$rec_details['id'].'" style="float: right;">
								</h5>
								</a>								
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">';
									if($rec_details["date"] != "") {
						$msg.=  '<i class="fa fa-calendar fa-fw text-primary"></i> '.$rec_details["date"].' &nbsp;';
									 }
						$msg.=	'<i class="fa fa-tag fa-fw text-primary"></i>';
 									if($rec_details["tagname"] !="") {
 									$tagname = explode(",",$rec_details["tagname"]);
 									foreach($tagname as $tags):
						$msg.=	'<a id='.$rec_details["tagid"].' span class="label label-primary">'.$tags.'</span></a>&nbsp;';
 									endforeach;
 									}
						$msg.=	'</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									'.$rec_details["description"].'
									</p>
								</div>
					</div>';
			endforeach;			
			endforeach;
			echo $msg;
		}	
		}

		//Add file into DB	
		$selected_rec = $this->input->post('records');
		$file_name = $this->input->post('name');
		if($selected_rec != NULL){
		$data = $this->files_m->add_file($file_name);
		$sel_rec = rtrim($selected_rec,',');
		$array = explode(",", $sel_rec);
		foreach ($array as $rec_id):
		$value = $this->files_m->add_records($rec_id,$data[1]);
		endforeach;
		}
		
		// Share file with records
		$shareid = $this->input->post('share_id');
		$toid = $this->input->post('to_ids');
		$fromid = $this->input->post('from_ids');
		$fileid = $this->input->post('file_id');
		
		if($shareid != NULL)
		{
			if(strpos(trim($shareid), ' ') !== false)
			{
				$data_ids = array();
				$chk_id = explode(",", $shareid);
				foreach($chk_id as $key=>$email_name):
				$act_email = explode(" ",$email_name);
				$data_ids1 = $this->register_m->get_contacts_id($act_email[3]);
				array_push($data_ids, $data_ids1[0]);
				$con = $data_ids1[0]['id'];
				$string = json_encode($data_ids1)." , ";
				$edit_str = preg_replace('/[^0-9\-]/', '',$string);
				if(count($con) == ''){
					echo "ERROR";
				}
				else{
					echo $edit_str.",";
				}
				endforeach;
			}
			else{
				echo "ERROR";
			}
		}
		
		if($toid != NULL & $fromid != NULL & $fileid != NULL)
		{
			$i = 0;
			$array_id = explode(" ", $toid);
			foreach ($array_id as $key=>$new_id):
			$count = $this->files_m->check_notification($new_id,$fromid,$fileid);
			echo $count;
			if($count == 0)
			{
				$toids = explode(",", $toid);
				foreach ($toids as $key=>$to_id):
				$data = $this->files_m->add_to_notification($to_id,$fromid,$fileid);
				endforeach;
			}
			$data[$i]["test"] = $count;
			$i++;
			endforeach;
		}
	}
}