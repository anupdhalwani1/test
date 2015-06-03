<?php
class member_record extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('member_record_m');
		$this->load->model('member_m');
	}

	public function index()
	{
		$parameters = $this->uri->uri_to_assoc();
		$mid=$parameters['m_id'];
		$id=NULL;
		$nooffiles=0;
		/*Member Record Edit*/
		if(count($parameters)==2)
		{
			$this->data['rc_list_one'] = $this->member_record_m->get($parameters['id']);
			$this->db->where("active","1");
			$this->data['mfiles']=$this->member_record_m->get_record("member_record_id",$parameters['id'],"os-pii-member-record-files");
			$nooffiles=count($this->data['mfiles']);
			$id=$parameters['id'];
		}
		else {
			$this->data['rc_list_one'] = $this->member_record_m->get_new();
		}
		$this->db->select("*,(SELECT count(id) FROM `os-pii-member-record-files` where member_record_id=`os-pii-member_record`.`id` and `os-pii-member-record-files`.active='1')as filecount");
		$this->db->where("member_id",$mid);
		$this->db->where("active","1");
		$this->data['rc_list']=$this->member_record_m->get();
		$this->data['rc_list_m']=$this->member_m->get($mid);
		$this->data['m_id']=$mid;
		if($this->input->post("submit_form"))
		{
			$data = $this->member_record_m->array_from_post(array('title', 'description','member_id'));
			$member_record_id=$this->member_record_m->save($data,$id);
			$pages=$this->member_m->get("","","os-pii-member-temp-record-file");
			if(count($pages)):foreach ($pages as $page):
			$nooffiles++;
			$filename=$page->filename;
			$arry= explode('.', $filename);
			$arry[0]=$this->data['rc_list_m']->fname."".$this->data['rc_list_m']->lname;
			$newfile=$arry[0]."_".$parameters['m_id']."_"."_".$member_record_id."_".$nooffiles.".".$arry[1];
			rename("member_record_file/".$filename, "member_record_file/".$newfile);
			$this->member_record_m->save(array("member_record_id"=>$member_record_id,"member_id"=>$mid,"filename"=>$newfile),"","os-pii-member-record-files");
			endforeach;
			endif;
			$this->db->empty_table("os-pii-member-temp-record-file");
			redirect('member_record/index/m_id/'.$mid);
		}
		/*end*/
		$this->data['subview'] ="member_record/index";
		$this->load->view('_main_layout', $this->data);
	}
	public function delete(){
		$parameters = $this->uri->uri_to_assoc();
		$data["active"]="0";
		$this->member_record_m->save($data,$parameters['id']);
		redirect('member_record/index/m_id/'.$parameters['m_id']);
	}
	public function delete_files(){
		$parameters = $this->uri->uri_to_assoc();
		$data["active"]="0";
		$this->db->where("id",$parameters['fileid']);
		$this->db->update("os-pii-member-record-files",$data);

		redirect('member_record/index/id/'.$parameters['id'].'/m_id/'.$parameters['m_id']);
	}
	public function delete_single_file(){
		$filename = $this->input->post('rec_name');
		$record_id = $this->input->post('rec_id');
		$member_id = $this->input->post('mem_id');

		$this->member_record_m->remove_file($filename,$record_id,$member_id);
		$result = $this->member_record_m->check_records($record_id,$member_id);
		$x = count($result);
		if($x == 0)
		{ echo "empty"; }// Do not remove it.
	}
	public function upload()
	{
		$this->load->library('upload');
		$config['upload_path']   = 'member_record_file'; //if the files does not exist it'll be created
		$config['allowed_types'] = '*';
		$config['max_size']   = '4000'; //size in kilobytes
		$config['encrypt_name']  = false;

		$this->upload->initialize($config);
		$uploaded = $this->upload->up(false); //Pass true if you want to create the index.php files

		$fiels=$uploaded;
		//$fiels='<table cellpadding="3" width="90%" align="center"> ';
		$i=1;
		foreach($uploaded["success"] as $item  => $v)
		{
			$this->member_record_m->save(array("filename"=>$v["file_name"]),"","os-pii-member-temp-record-file");
		}
		//$fiels.='</table>';
		$pages=$this->member_m->get("","","os-pii-member-temp-record-file");
		$fiels='<table><tbody><tr>';
		$counter = 1;
		if(count($pages)):foreach ($pages as $page):
		$fiels.="<td align='center' ><img style='max-width:100px;max-height:100px;' src=".base_url()."member_record_file/". $page->filename." />";
		$fiels.="</td>";
		if ($counter==4)
		{
			$fiels.="</tr><tr>";
			$counter = 0;
		}
		$counter++;
		endforeach;
		$fiels.='</tr>';
		else:
		$fiels.='<tr><td colspan="3">We could not find any Images</td></tr></tbody>';
		endif;
		$fiels.='</table>';
		echo $fiels;
	}
	public function edit ()
	{
		$parameters = $this->uri->uri_to_assoc();
		$id=NULL;
		if(count($parameters)==2)
		{
			$this->data['rc_list'] = $this->member_record_m->get($parameters['id']);
			$this->db->where("active","1");
			$this->data['mfiles']=$this->member_record_m->get_record("member_record_id",$parameters['id'],"os-pii-member-record-files");
			$id=$parameters['id'];
		}
		else {
			$this->data['rc_list'] = $this->member_record_m->get_new();
		}
		$this->data['rc_list_m']=$this->member_m->get($parameters['m_id']);
		if($this->input->post("submit_form"))
		{
			$data = $this->member_record_m->array_from_post(array('title', 'description','member_id'));
			$member_record_id=$this->member_record_m->save($data,$id);
			$pages=$this->member_m->get("","","os-pii-member-temp-record-file");
			$i=0;
			if(count($pages)):foreach ($pages as $page):
			$filename=$page->filename;
			$arry= explode('.', $filename);
			$arry[0]=$this->data['rc_list_m']->fname."".$this->data['rc_list_m']->lname;
			$newfile=$arry[0]."_".$parameters['m_id']."_"."_".$member_record_id."_".$i.".".$arry[1];
			rename("member_record_file/".$filename, "member_record_file/".$newfile);
			$this->member_record_m->save(array("member_record_id"=>$member_record_id,"member_id"=>$parameters['m_id'],"filename"=>$newfile),$id,"os-pii-member-record-files");
			$i++;
			endforeach;
			endif;
			redirect('member_record/index/'.$parameters['m_id']);
		}
		else
		{
			$this->db->empty_table("os-pii-member-temp-record-file");
			$this->data['subview'] = 'member_record/edit';
			$this->load->view('_main_layout', $this->data);
		}
	}

}
?>