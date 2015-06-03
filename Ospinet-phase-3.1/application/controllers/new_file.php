<?php
class new_file extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('member_m');

	}

	public function index()
	{
		$this->db->where("active","1");
		$this->db->where("userid",$this->session->userdata('id'));
		$this->data['rc_list_count']=$this->member_m->get();
		$this->load->view('templates/demo', $this->data);
	}
	public function export_excel()
	{
		header('Content-Type: application/force-download');
		header('Content-disposition: attachment; filename=export.xls');
		// Fix for crappy IE bug in download.
		header("Pragma: ");
		header("Cache-Control: ");
		echo $_REQUEST['datatodisplay'];
	}
}
?>