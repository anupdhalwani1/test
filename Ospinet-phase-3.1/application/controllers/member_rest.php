<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class member_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("member_m");
		$this->load->model("member_record_m");
		$this->load->model("notification_m");
		$this->load->library('session');
	}
	public function index_get()
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		$data  = array();
		$data1 = array();
		if ($this->uri->segment(2)) {
			$data1 = $this->member_m->get($this->uri->segment(2));
		} else {
			$total_tags = "";
			$arr        = $this->member_m->get_members();
			foreach ($this->member_record_m->get_tags() as $tgs):
			$total_tags .= $tgs['tagname'] . ",";
			endforeach;
			$i = 0;
			$j = 0;
			foreach ($arr as $row){
				$arr1 = $this->member_record_m->get_record($row["id"]);
				$str  = "rec";
				$row += array(
                    "rec_tag" => $this->member_record_m->get_tags()
				);
				$data += array(
				$i => array_merge($row, array(
				$str => $arr1
				))
				);
				$i++;
			}
			$i = 0;
			$tgs_arr = $this->member_record_m->get_tags();
			foreach ($data as $row) {
				if ($row['birth_month'] != 0) {
					$Bday     = $row['birth_day'];
					$Bmonth   = $row['birth_month'];
					$Byear    = $row['birth_year'];
					$birthday = new DateTime($Bday . '-' . $Bmonth . '-' . $Byear);
					$today    = new DateTime($this->getTimeZoneByIP());
					$diff     = $birthday->diff($today);
					$months   = $diff->format('%m') + 12 * $diff->format('%y');
					if ($row['birth_info'] == "Unborn") {
						$row['months'] = $months . ' month';
					} else {
						$row['months'] = $months . ' months old';
					}
				}
				$row["tagnamess"] = $total_tags;
				$j  = 0;
				foreach ($row["rec"] as $row1) {
					$str1 = "recImage";
					$arr2 = $this->member_record_m->get_record_files($row1["id"]);
					$row["rec"][$j] += array(
					$str1 => $arr2
					);
					$str2 = "recTags";
					$arr3 = $this->member_record_m->get_record_tags($row1["id"]);
					$row["rec"][$j] += array(
					$str2 => $arr3
					);
					$j++;
				}
				/*$k=0;
				 foreach($row["rec"] as $row2)
				 {
				 $str2="recTags";
				 $arr3=$this->member_record_m->get_record_tags($row2["id"]);
				 $row["rec"][$k]+=array($str2=>$arr3);
				 $k++;
				 }*/
				$data1 += array(
				$i => $row
				);
				$i++;
			}
		}
		//  $this->db->empty_table("os-pii-member-temp-record-file");
		echo json_encode($data1);
	}

	public function index_post()
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		//save data
		$this->load->library('session');
		$data = $this->request->body;
		if (isset($data['fileAttachment'])) {
			$file = $data['fileAttachment'];
			$profile_pic = explode(".", $file);
/*		if($data["education"] == NULL && $data["university_name"] == NULL && $data["graduation_year"] == NULL && $data["specialization"] == NULL){
				$data["education"] = "NULL";
				$data["university_name"] = "NULL";
				$data["graduation_year"] = "NULL";
				$data["specialization"] = "NULL";
			} */
			$data1       = array(
                'fname' => $data["fname"],
                'lname' => $data["lname"],
                'email' => $data["email"],
            	'education' => $data["education"],
            	'university_name' => $data["university_name"],
            	'graduation_year' => $data["graduation_year"],
            	'specialization' => $data["specialization"],
                'gender' => $data["gender"],
                'birth_info' => $data["birth_info"],
                'profile_pic' => $profile_pic[0],
                'type' => $profile_pic[1]
			);
		} else {
			$data1 = array(
                'fname' => $data["fname"],
                'lname' => $data["lname"],
                'email' => $data["email"],
            	'education' => $data["education"],
            	'university_name' => $data["university_name"],
            	'graduation_year' => $data["graduation_year"],
            	'specialization' => $data["specialization"],
                'gender' => $data["gender"],
                'birth_info' => $data["birth_info"]
			);
		}
		$data1["userid"] = $this->session->userdata('id');
		if ($data["birth_info"] == "Age") {
			$data1 += array(
                'age' => $data["age"]
			);
			$year = date('Y', strtotime('-' . $data["age"] . ' year', strtotime(date("Y-m-d"))));
			$data1 += array(
                "birth_year" => $year,
                "birth_month" => "1",
                "birth_day" => "1"
                );
                $data1['id'] = $this->member_m->save($data1);
		}
		if ($data["birth_info"] == "Dob") {
			$month1   = $data['bd_month'] + 1;
			$birthday = new DateTime($data['bd_year'] . '-' . $month1 . '-' . $data['bd_day']);
			$today    = new DateTime($this->getTimeZoneByIP());
			$diff     = $birthday->diff($today);
			$months   = $diff->format('%m') + 12 * $diff->format('%y');
			$years    = $diff->format('%y');
			//$age=(date("md", date("U", mktime(0, 0, 0, $data['bd_month'], $data['bd_day'], $data['bd_year']))) > date("md") ? ((date("Y")-$data['bd_year'])-1):(date("Y")-$data['bd_year']));
			$data1 += array(
                'birth_year' => $data["bd_year"],
                'birth_month' => $month1,
                'birth_day' => $data["bd_day"],
                'age' => $years
			);
			$data1['id']     = $this->member_m->save($data1);
			$data1["age"]    = $years;
			$data1['months'] = $months . ' months old';
		}
		if ($data["birth_info"] == "Unborn") {
			$month1   = $data['ub_month'] + 1;
			$birthday = new DateTime($data['ub_year'] . '-' . $month1 . '-' . $data['ub_day']);
			$today    = new DateTime($this->getTimeZoneByIP());
			$diff     = $birthday->diff($today);
			$months1  = $diff->format('%m') + 12 * $diff->format('%y');
			$years    = $diff->format('%y');
			$data1 += array(
                'birth_year' => $data["ub_year"],
                'birth_month' => $month1,
                'birth_day' => $data["ub_day"],
                'age' => "0"
                );
                $data1['id']     = $this->member_m->save($data1);
                $data1['months'] = $months1 . ' month';
		}
		echo json_encode($data1);
	}

	public function index_put()
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		//update		
		$data = $this->request->body;
		var_dump($data);
		if (isset($data['fileAttachment'])) {
			$file = $data['fileAttachment'];
			$profile_pic = explode(".", $file);
/*			if($data["education"] == "" && $data["university_name"] == "" && $data["graduation_year"] == "" && $data["specialization"] == ""){
				$data["education"] = "NULL";
				$data["university_name"] = "NULL";
				$data["graduation_year"] = "NULL";
				$data["specialization"] = "NULL";
			} 
*/
			$data1       = array(
                'fname' => $data["fname"],
                'lname' => $data["lname"],
                'email' => $data["email"],
            	'education' => $data["education"],
            	'university_name' => $data["university_name"],
            	'graduation_year' => $data["graduation_year"],
            	'specialization' => $data["specialization"],
                'gender' => $data["gender"],
                'birth_info' => $data["birth_info"],
                'profile_pic' => $profile_pic[0],
                'type' => $profile_pic[1]
			);
		} else {
			$data1 = array(
                'fname' => $data["fname"],
                'lname' => $data["lname"],
                'email' => $data["email"],
            	'education' => $data["education"],
            	'university_name' => $data["university_name"],
            	'graduation_year' => $data["graduation_year"],
            	'specialization' => $data["specialization"],
                'gender' => $data["gender"],
                'birth_info' => $data["birth_info"]
			);
		}
		//soft delete record
		if ($data["delete_report"] == "delete_report") //if-1
		{
			//delete records
			$data_record = array(
                "title" => $data["title"],
                "description" => $data["description"],
                "member_id" => $data["id"],
                "active" => 0,
                "date" => $this->getTimeZoneByIP()
			);
			$this->db->where("id", $data["record_id"]);
			$this->db->update("os-pii-member_record", $data_record);
			foreach ($data["rec"] as $key => $value) {
				if ($value["id"] == $data["record_id"]) {
					unset($data["rec"][$key]);
				}
			}
			$this->db->empty_table("os-pii-member-temp-record-file");
			//$delete_array=array("title"=>$data["title"],"description"=>$data["description"],"id"=>$data["record_id"]);
			//echo json_encode($data);
			//	echo $this->db->last_query();
		}
		//update member data
		else {
			if ($data["title"] == NULL) {
				if ($data["birth_info"] == "Dob") {
					$month1   = $data['bd_month'] + 1;
					$birthday = new DateTime($data['bd_year'] . '-' . $month1 . '-' . $data['bd_day']);
					$today    = new DateTime($this->getTimeZoneByIP());
					$diff     = $today->diff($birthday);
					$months   = $diff->format('%m') + 12 * $diff->format('%y');
					$years    = $diff->format('%y');
					//$age=(date("md", date("U", mktime(0, 0, 0, $data['bd_month'], $data['bd_day'], $data['bd_year']))) > date("md") ? ((date("Y")-$data['bd_year'])-1):(date("Y")-$data['bd_year']));
					$data1 += array(
                        'birth_year' => $data["bd_year"],
                        'birth_month' => $data["bd_month"] + 1,
                        'birth_day' => $data["bd_day"],
                        'age' => $years
					);
					unset($data["age"]);
					$data["age"] = (string) $years;
					unset($data["birth_day"]);
					$data["birth_day"] = $data["bd_day"];
					unset($data["birth_month"]);
					$data["birth_month"] = $month1;
					unset($data["birth_year"]);
					$data["birth_year"] = $data["bd_year"];
					$data['months']     = $months . ' months old';
				} else if ($data["birth_info"] == "Age") {
					$data1 += array(
                        'age' => $data["age"]
					);
					$year = date('Y', strtotime('-' . $data["age"] . ' year', strtotime(date("Y-m-d"))));
					$data1 += array(
                        "birth_year" => $year,
                        "birth_month" => "1",
                        "birth_day" => "1"
                        );
                        unset($data["birth_day"]);
                        $data["birth_day"] = "1";
                        unset($data["birth_month"]);
                        $data["birth_month"] = "1";
                        unset($data["birth_year"]);
                        $data["birth_year"] = (string) $year;
				} else if ($data["birth_info"] == "Unborn") {
					$month1   = $data['ub_month'] + 1;
					$birthday = new DateTime($data['ub_year'] . '-' . $month1 . '-' . $data['ub_day']);
					$today    = new DateTime($this->getTimeZoneByIP());
					$diff     = $today->diff($birthday);
					$months   = $diff->format('%m') + 12 * $diff->format('%y');
					$data1 += array(
                        'birth_year' => $data["ub_year"],
                        'birth_month' => $month1,
                        'birth_day' => $data["ub_day"],
                        'age' => "0"
                        );
                        unset($data["birth_day"]);
                        $data["birth_day"] = $data["ub_day"];
                        unset($data["birth_month"]);
                        $data["birth_month"] = $data["ub_month"] + 1;
                        unset($data["birth_year"]);
                        $data["birth_year"] = $data["ub_year"];
                        $data['months']     = $months . " month";
                        $data['age']        = "0";
				}
				$this->db->where('id', $data["id"]);
				$this->db->update('os-pii-member', $data1);
			} else {
				$data2       = array(
                    'title' => $data["title"],
                    'description' => $data["description"],
                    'member_id' => $data["memberid"],
                    "active" => "1",
                    "date" => $this->getTimeZoneByIP()
				);
				//update records
				$tagname_new = array();
				if ($data["record_id"] != NULL) {
					$this->db->where("recordid", $data["record_id"]);
					$this->db->delete("os-pii-records-tag");
					//$data_tag=array("tagname"=>$data["selected_tag"]);
					$data_tag = explode(",", $data["selected_tag"]);
					$i        = 0;
					foreach ($data_tag as $tags_insert):
					$tagname_new += array(
					$i => array(
                                "tagname" => $tags_insert
					)
					);
					$i++;
					$tg_count = $this->member_record_m->check_tagname($tags_insert);
					if (count($tg_count) == 0) {
						$this->db->insert('os-pii-tags_master', array(
                                "tagname" => $tags_insert,
                                "userid" => $this->session->userdata("id")
						));
						$tag_id          = $this->db->insert_id();
						$data_record_tag = array(
                                "tagid" => $tag_id,
                                "recordid" => $data["record_id"]
						);
						$this->db->insert('os-pii-records-tag', $data_record_tag);
						$data["rec_tag"] += array(
						count($data["rec_tag"]) => array(
                                    "tagname" => $tags_insert
						)
						);
					} else {
						foreach ($tg_count as $tags):
						$data_record_tag = array(
                                    "tagid" => $tags["id"],
                                    "recordid" => $data["record_id"]
						);
						$this->db->insert('os-pii-records-tag', $data_record_tag);
						// echo $this->db->last_query();
						endforeach;
					}
					endforeach;

					$this->db->where('id', $data["record_id"]);
					$this->db->update('os-pii-member_record', $data2);
					//get new images
					$pages_up    = $this->member_record_m->get_all_temp();
					$i           = 0;
					$new_rec1_up = array();
					if (count($pages_up)):
					foreach ($pages_up as $page_up):
					$filename = $page_up["filename"];
					$this->member_record_m->save(array(
                                "member_record_id" => $data["record_id"],
                                "member_id" => $data["id"],
                                "filename" => $filename
					), "", "os-pii-member-record-files");
					array_push($new_rec1_up, array(
                                "id" => $page_up["id"],
                                "member_record_id" => $data["record_id"],
                                "member_id" => $data["id"],
                                "filename" => $filename,
                                "active" => 1
					));
					// $new_rec["recImage"][$i]+=array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename);
					//$new_rec1=array($i=>array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename));
						
					$i++;
					endforeach;
					endif;
					//echo var_dump($new_rec1_up);
					$ind = '';
					foreach ($data["rec"] as $key => $row1):
					if ($data["record_id"] == $row1["id"]) {
						// $data["rec"][$key]["recTags"]=array();
						$data["rec"][$key]["title"]       = $data["title"];
						$data["rec"][$key]["description"] = $data["description"];
						$data["rec"][$key]["date"]        = $this->getTimeZoneByIP();
						$data["rec"][$key]["id"]          = $data["record_id"];
						$data["rec"][$key]["recTags"]=$tagname_new;
						// $data["rec"][$key]["recImage"]+=$new_rec1_up;
						$ind=$key;
						if (!empty($new_rec1_up)) {
							// $data["rec"][$ind]["recImage"] += array(
							//   count($data["rec"][$ind]["recImage"]) => $new_rec1_up  );
							$data["rec"][$ind]["recImage"]=array_merge($data["rec"][$ind]["recImage"],$new_rec1_up);

						}
						//   $data["rec"][$key]["recTags"] = $tagname_new;
						// echo var_dump($new_rec1_up);
					}
					endforeach;
					//array_unshift( $data["rec"],$new_rec);
					$data["rec"];
					$out = array_splice($data["rec"],$ind, 1);
					array_splice($data["rec"], 0, 0, $out);
				}
				//save records
				else {
					$this->db->insert('os-pii-member_record', $data2);
					$member_record_id = $this->db->insert_id();
					$new_rec          = array(
                        "title" => $data["title"],
                        "description" => $data["description"],
                        "recTags" => array(),
                        "id" => $member_record_id,
                        "date" => $this->getTimeZoneByIP()
					);
					$data_tag         = explode(",", $data["selected_tag"]);
					$i                = 0;
					foreach ($data_tag as $tags_insert):
					//$tagname_new["recTag"][$i]+=array("tagname"=>$tags_insert);
					$new_rec["recTags"] += array(
					$i => array(
                                "tagname" => $tags_insert
					)
					);
					//$tagname_new1+=array($i=>array("tagname"=>$tags_insert));
					$i++;
					$tg_count = $this->member_record_m->check_tagname($tags_insert);
					if (count($tg_count) == 0) {
						$this->db->insert('os-pii-tags_master', array(
                                "tagname" => $tags_insert,
                                "userid" => $this->session->userdata("id")
						));
						$tag_id          = $this->db->insert_id();
						$data_record_tag = array(
                                "tagid" => $tag_id,
                                "recordid" => $member_record_id
						);
						$this->db->insert('os-pii-records-tag', $data_record_tag);
					} else {
						foreach ($tg_count as $tags):
						$data_record_tag = array(
                                    "tagid" => $tags["id"],
                                    "recordid" => $member_record_id
						);
						$this->db->insert('os-pii-records-tag', $data_record_tag);
						// echo $this->db->last_query();
						endforeach;
					}
					endforeach;
					$pages = $this->member_record_m->get_all_temp();

					$i        = 0;
					$new_rec1 = array();
					if (count($pages)):
					foreach ($pages as $page):
					$filename = $page["filename"];
					$this->member_record_m->save(array(
                                "member_record_id" => $member_record_id,
                                "member_id" => $data["id"],
                                "filename" => $filename
					), "", "os-pii-member-record-files");
					$new_rec1 += array(
					$i => array(
                                    "member_record_id" => $member_record_id,
                                    "member_id" => $data["id"],
                                    "filename" => $filename
					)
					);
					// $new_rec["recImage"][$i]+=array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename);
					//$new_rec1=array($i=>array("member_record_id"=>$member_record_id,"member_id"=>$data["id"],"filename"=>$filename));
					$i++;
					endforeach;
					endif;
					$new_rec += array(
                        "recImage" => $new_rec1
					);
					$this->db->empty_table("os-pii-member-temp-record-file");
					array_unshift($data["rec"], $new_rec);
					//array_push($data["rec"],$new_rec);
					//array_push($data["rec"],$tagname_new);
				}
			}
		}

		echo json_encode($data);
	}

	public function index_delete()
	{
		$data = $this->uri->segment("2");
		$this->db->where("id", $data);
		$this->db->update('os-pii-member', array(
            "active" => "0"
            ));
            $this->db->empty_table("os-pii-member-temp-record-file");
            echo json_encode($data);
	}
	public function getTimeZoneByIP()
	{
		// timezone
		$timezone = false;
		// pass this lat and long to http://www.earthtools.org/ API to get Timezone Offset in xml
		//https: //maps.googleapis.com/maps/api/timezone/json?location=39.6034810,-119.6822510&timestamp=1331161200&sensor=true_or_false
		$tz_xml = $this->file_get_contents_curl('http://www.earthtools.org/timezone-1.1/18.53497040/73.876302799999960000');
		// lets parse out the timezone offset from the xml using regex
		if (preg_match("/<localtime>([^<]+)<\/localtime>/i", $tz_xml, $match)) {
			$timezone = $match[1];
		}
		return $timezone;
	}
	function file_get_contents_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

}