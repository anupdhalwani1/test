<?php
class MY_Model extends CI_Model {

	protected $_table_name = '';
	protected $_priamery_key = 'id';
	protected $_priamery_filter = 'intval';
	protected $_order_by = '';
	public $rules = array ();
	protected $_timestamps = FALSE;
	function function_name() {

		parent::__construct ();
			
	}
	public function array_from_post($fields){
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}
	public function single_from_post($field){
		return   $this->input->post($field);
	}
	public function get($id = NULL, $single = FALSE,$tablename=NULL) {

		if($tablename!=NULL)
		$this->_table_name=$tablename;

		if ($id != NULL) {
			$filter = $this->_priamery_filter;
			$id = $filter ( $id );
			$this->db->where ( $this->_priamery_key, $id );
			$method = "row";
		} elseif ($single == TRUE) {
			$method = "row";
		} else {
			$method = "result";
		}
		if (! count ( $this->db->ar_orderby )) {
			$this->db->order_by ( $this->_order_by );
		}
		return $this->db->get ( $this->_table_name )->$method ();
	}
	public function get_record($idcoumnname=NULL,$id = NULL,$tablename=NULL) {

		if($idcoumnname!=NULL)
		$this->db->where ( $idcoumnname, $id );
			
		$method = "result";
		return $this->db->get ( $tablename )->$method ();
	}
	public function  get_single_row($where,$tablename)
	{
		$this->db->where ( $where );
		return $this->db->get ( $tablename)->row();

	}
	public function  get_single_value($id=NULL,$tablename,$column)
	{
		$this->db->select($column);
		if($id!=NULL)
		$this->db->where ( $this->_priamery_key, $id );
		return $this->db->get ( $tablename)->num_rows();

	}
	public function get_by($where, $single = FALSE) {

		$this->db->where ( $where );
		//$this->get ( NULL, $single );
		return $this->get ( NULL, $single );
	}
	public function save($data, $id = NULL,$tablename=NULL) {

		if($tablename!=NULL)
		$this->_table_name=$tablename;

		// set timestamp
		if ($this->_timestamps == TRUE) {
			$now = date ( 'Y-m-d H:i:s' );
			$id || $data ['created'] = $now;
			$data ['modified'] = $now;
		}
		// insert
		if ($id == NULL) {
			! isset ( $data [$this->_priamery_key] ) || $data [$this->_priamery_key] = NULL;
			$this->db->set ( $data );
			$this->db->insert ( $this->_table_name );
			$id = $this->db->insert_id ();
		} 		// Update
		else {
			$filter = $this->_priamery_filter;
			$id = $filter ( $id );
			$this->db->set ( $data );
			$this->db->where ( $this->_priamery_key, $id );
			$this->db->update ( $this->_table_name );
		}
		return $id;
	}
	public function update_columnid($data, $id , $cloumnname = NULL,$tablename=NULL)
	{
		$this->db->set ( $data );
		$this->db->where( $cloumnname, $id );
		$this->db->update( $tablename);
	}
	public function delete($id,$tablename=NULL) {
		if($tablename!=NULL)
		$this->_table_name=$tablename;
		$filter = $this->_priamery_filter;
		$id = $filter ( $id );
		if (! $id) {
			return FALSE;
		}
		$this->db->where ( $this->_priamery_key, $id );
		$this->db->limit ( 1 );
		$this->db->delete ( $this->_table_name );
	}
}