<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Rec_file_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("files_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		$members_id = $this->files_m->get_members_id();
		$i=0;
		foreach($members_id as $mem_id){
		$val[$i++] = $this->files_m->get_records_of_member($mem_id['id']);
		}
		echo json_encode($val);
	}
	public function index_post()
	{
		// Get files of contacts
		$contact_id = $this->input->post('con_id');
		$data = $this->files_m->get_contact_file_details($contact_id);
		if(count($data) != '0'){
		$i=0;
		foreach($data as $file_details):
		$file_name = $file_details['file_name'];
		echo $msg = '<div class="active" id="contactfilelist" onclick="javascript:contact_file_details('.$file_details['file_id'].','."'$file_name'".','.$file_details['member_id'].',this)" style="width: 90px;"height: 90px;">
					<div class="innerAll" style="width: 84px; float: left;padding-left: 8px;height: 90px;" >
					<button  class="btn-primary btn-stroke btn-xs">
					<input type="hidden" value="'.$file_details["file_id"].'" id="file_id" />
					<img src="'. base_url().'assets/images/file_image/file.png" id= "file_'.$file_details["file_id"].'" class="pull-left thumb" width="65">				
					'.$file_details['file_name'].'
					</button>
					</div>
					</div>
					';
		endforeach;
		$i++;
		}else{
			$msg ='		<div class="No result" id="result_not_found" style="text-align: center;margin-top: 70px;">
						<h4>No Record shared</h4>
						</div>';
			echo $msg;
		}
		
	}
}