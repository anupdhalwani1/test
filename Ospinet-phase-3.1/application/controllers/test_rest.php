<?php
error_reporting(E_ALL | E_STRICT);
require (APPPATH.'libraries/REST_Controller.php');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class test_rest extends REST_Controller{
	public function __construct() {
		parent::__construct ();

		$this->load->model("member_m");
		$this->load->model("member_record_m");
		$this->load->library('session');

	}

	public function index_get()
	{

		$data=array();
		$data1=array();
		if(isset($_POST["id"]))
		{
			$this->member_m->get($_POST["id"]);
		}
		else
		{
			$arr=$this->member_m->get_members();
			$i=0;
				
			foreach($arr as $row)
			{
				$arr1=$this->member_record_m->get_record($row["id"]);
				$str="rec";
				$data+=array($i=>array_merge($row,array($str=>$arr1)));
				$i++;
			}
			$i=0;
			foreach($data as $row)
			{
				$j=0;
				foreach($row["rec"] as $row1)
				{
					$str1="recImage";
					$arr2=$this->member_record_m->get_record_files($row1["id"]);
					$row["rec"][$j]+=array($str1=>$arr2);
					//							$row["rec"][$j]+=array("recImage"=>"aaa");
					$j++;
				}
					
				$data1+=array($i=>$row);
				$i++;
			}
		}
		echo json_encode($data1);
			
	}

	public function index_post()
	{
		//save data
	 $this->load->library('session');
		$data = $this->request->body;

		$data1= array(
		 
               'fname' => $data["fname"],
               'lname' => $data["lname"],
			   'email' => $data["email"],
               'gender' => $data["gender"],
			   'birth_info'=> $data["birth_info"],
		);
		$data1["userid"]=$this->session->userdata('id');
		if($data["birth_info"]=="Age")
		{
			$data1+=array('age' => $data["age"]);
			$year= date ( 'Y' , strtotime ( '-'.$data["age"].' year' , strtotime ( date("Y-m-d") ) ) );
			$data1+=array("birth_year"=>$year,"birth_month"=>"1","birth_day"=>"1");
		}
		if($data["birth_info"]=="Dob")
		{
			$age=(date("md", date("U", mktime(0, 0, 0, $data['bd_month'], $data['bd_day'], $data['bd_year']))) > date("md") ? ((date("Y")-$data['bd_year'])-1):(date("Y")-$data['bd_year']));
			$data1+= array('birth_year' =>$data["bd_year"],
			               'birth_month' =>$data["bd_month"]+1,
						   'birth_day' => $data["bd_day"],
						   'age' => $age
			);

		}
		if($data["birth_info"]=="Unborn")
		{
			$data1+=array('birth_year' =>$data["ub_year"],
			               'birth_month' =>$data["ub_month"],
						   'birth_day' => $data["ub_day"],
						   'age' => "0"
			
						   );
		}

		$data1["id"]=$this->member_m->save($data1);
		echo json_encode($data1);

	}

	public function index_put()
	{
		//update

		$data = $this->request->body;
		$data1 = array(
               'fname' => $data["fname"],
               'lname' => $data["lname"],
			   'email' => $data["email"],
               'gender' => $data["gender"],
			   'birth_info' => $data["birth_info"]
		);
		//soft delete record
		if($data["delete_report"]=="delete_".$data["record_id"])
		{
			//delete records
			$data_record=array("title"=>$data["title"],"description"=>$data["description"],"member_id"=>$data["id"],"active"=>0,"date" =>$this->getTimeZoneByIP());
			$this->db->where("id",$data["record_id"]);
			$this->db->update("os-pii-member_record",$data_record );
			foreach ($data["rec"] as $key => $value)
			{
				if($value["id"] == $data["record_id"]) { unset($data["rec"][$key]); }
			}
			//$delete_array=array("title"=>$data["title"],"description"=>$data["description"],"id"=>$data["record_id"]);
			//echo json_encode($data);
			//	echo $this->db->last_query();
		}
		//update member data
		else
		{
			if($data["title"]==NULL)
			{
				if($data["birth_info"]=="Dob")
				{
						
					$age=(date("md", date("U", mktime(0, 0, 0, $data['bd_month'], $data['bd_day'], $data['bd_year']))) > date("md") ? ((date("Y")-$data['bd_year'])-1):(date("Y")-$data['bd_year']));
					$data1+=array('birth_year' =>$data["bd_year"],
			               'birth_month' =>$data["bd_month"]+1,
						    'birth_day' => $data["bd_day"],
						   'age' => $age
					);
					unset($data["age"]);
					$data["age"] = (string)$age;
					unset($data["birth_day"]);
					$data["birth_day"] = $data["bd_day"];
					unset($data["birth_month"]);
					$data["birth_month"] = $data["bd_month"]+1;
					unset($data["birth_year"]);
					$data["birth_year"] = $data["bd_year"];
				}
				if($data["birth_info"]=="Age")
				{
					$data1+=array('age' => $data["age"]);
					$year= date ( 'Y' , strtotime ( '-'.$data["age"].' year' , strtotime ( date("Y-m-d") ) ) );
					$data1+=array("birth_year"=>$year,"birth_month"=>"1","birth_day"=>"1");
					unset($data["birth_day"]);
					$data["birth_day"] = "1";
					unset($data["birth_month"]);
					$data["birth_month"] = "1";
					unset($data["birth_year"]);
					$data["birth_year"] = (string)$year;
						
				}

				if($data["birth_info"]=="Unborn")
				{
					$data1+=array('birth_year' =>$data["ub_year"],
			               'birth_month' =>$data["ub_month"],
						   'birth_day' => $data["ub_day"],
						   'age' => "0"
						   );
						   unset($data["birth_day"]);
						   $data["birth_day"] = $data["ub_day"];
						   unset($data["birth_month"]);
						   $data["birth_month"] = $data["ub_month"]+1;
						   unset($data["birth_year"]);
						   $data["birth_year"] = $data["ub_year"];
				}

				$this->db->where('id', $data["id"]);
				$this->db->update('os-pii-member', $data1);
			}

			else
			{
					
				$data2 = array(
               'title' => $data["title"],
               'description' => $data["description"],
               'member_id' => $data["memberid"],
			   "active" =>"1",
			   "date" =>$this->getTimeZoneByIP()
				);
					
				//update records
				if($data["record_id"] != NULL)
			 {
			 	$this->db->where('id', $data["record_id"]);
			 	$this->db->update('os-pii-member_record', $data2);
			 	$pages1=$this->member_m->get("","","os-pii-member-temp-record-file");
			 	foreach($pages1 as $page1):
					//$data5=array("member_id"=>$data["memberid"],"member_record_id",$data["record_id"],"filename"=>$page1["filename"],"active"=>1);
					/*$this->db->save(array("member_record_id"=>$data["record_id"],"member_id"=>$data["id"],$page1["filename"]),"","os-pii-member-record-files");*/
			 		
			 	endforeach;
			  foreach($data["rec"] as $key =>$row1):
			  if($data["record_id"] == $row1["id"])
			  {
					 $data["rec"][$key]["title"]=$data["title"];
					 $data["rec"][$key]["description"]=$data["description"];
					 $data["rec"][$key]["date"]=$this->getTimeZoneByIP();
					 $data["rec"][$key]["id"]=$data["record_id"];
					 $data["rec"][$key]["recImage"]+=$data["rec"][$key]["recImage"];
			  }
			  endforeach;
				 // echo var_dump($data);

			 }
			 	

			 //save records
			 else
			 {
			 	$this->db->insert('os-pii-member_record', $data2);
			 	$member_record_id=$this->db->insert_id();
			 	$new_rec=array("title"=>$data["title"],"description"=>$data["description"],"id"=>$member_record_id,"date"=>$this->getTimeZoneByIP());
			 	$pages=$this->member_record_m->get_all_temp();
			 	$i=0;
			 	$new_rec1=array();
			 	if(count($pages)):foreach ($pages as $page):
			 	$filename=$page["filename"];
			 	$this->member_record_m->save(array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename),"","os-pii-member-record-files");
			 	$new_rec1+=array($i=>array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename));
			 	// $new_rec["recImage"][$i]+=array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename);
			 	//$new_rec1=array($i=>array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename));
			 	$i++;
			 	endforeach;
			 	endif;
			 	$new_rec+=array("recImage"=>$new_rec1);
			 	$this->db->empty_table("os-pii-member-temp-record-file");
			 	array_push($data["rec"],$new_rec);

			 }
			}
		}

		echo json_encode($data);
	}

	public function index_delete()
	{
		$data = $this->uri->segment("2");
		$this->db->where("id",$data);
		$this->db->update('os-pii-member',array("active"=>"0"));
		echo json_encode($data);

	}

	public function getTimeZoneByIP() {
		// timezone
		$timezone = false;
		 
		// pass this lat and long to http://www.earthtools.org/ API to get Timezone Offset in xml
		//                  https://maps.googleapis.com/maps/api/timezone/json?location=39.6034810,-119.6822510&timestamp=1331161200&sensor=true_or_false
		$tz_xml = $this->file_get_contents_curl('http://www.earthtools.org/timezone-1.1/18.53497040/73.876302799999960000');
		// lets parse out the timezone offset from the xml using regex
		if (preg_match("/<localtime>([^<]+)<\/localtime>/i", $tz_xml, $match)) {
			$timezone = $match[1];
		}
		 
		return $timezone;
	}
	function file_get_contents_curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

}