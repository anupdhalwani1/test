<?php
class test extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model("member_m");

	}

	public function index()
	{
		$this->data["amol"]=$this->member_m->get();
		//$this->data['subview'] ="test";
		$this->load->view('test', $this->data);
	}
	function test123()
	{
		$this->db->select("*");
		$this->db->order_by("fname");
		$arr=$this->db->get("os-pii-member")->result_array();
		echo json_encode($arr);
	}

	public function save_member($id=NULL)
	{
		$data["fname"] = $this->input->post("fname");
		$data["lname"] = $this->input->post("lname");
		$data["gender"] = $this->input->post("gender");
		$data["age"] = $this->input->post("age");
		$data["birth_day"] = $this->input->post("birth_day");
		$data["birth_info"] = "age";
		$data["birth_month"] = "7";
		$data["birth_year"] = "1989";
		$data["active"] = "1";
		$data["userid"] = $this->session->userdata("id");
		$sa=$this->member_m->save($data,$id);
		echo $sa;
	}

}