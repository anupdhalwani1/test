<?php
class android_app_fun extends My_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('register_m');
		$this->load->model('member_m');
		$this->load->model('member_record_m');
		$this->load->model('notification_m');
		$this->load->model('files_m');
		$this->load->library('session');

	}
	public function login()
	{
		$email         = $this->input->post('email');
		$password      = $this->input->post('password');
		$loginmsg      = $this->register_m->login($email, $password, 'App');
		$fname         = "";
		$lname         = "";
		$email_address = "";
		$userid        = "";
		$roleid        = "";
		if ($loginmsg == "2") {
			$user = $this->register_m->get_single_row(array(
                'email' => $this->input->post('email'),
                'passwd' => $this->register_m->hash($this->input->post('password'))
			), "os-pii-user");
			if (count($user)) {
				$fname         = $user->fname;
				$lname         = $user->lname;
				$email_address = $user->email;
				$userid        = $user->id;
				$roleid        = $user->roleid;
			}
		}
		$json['loginmsg'][] = array(
            "loginstatus" => $loginmsg,
            "fname" => $fname,
            "lname" => $lname,
            "email" => $email_address,
            "userid" => $userid,
            "roleid" => $roleid
		);
		echo json_encode($json);
	}
	public function get_countmembers()
	{
		$user_id = $this->input->post("user_id");
		$this->db->where("userid", $user_id);
		$this->db->order_by("id", "asc");
		$array                 = $this->member_m->get();
		$response              = array();
		$response["memberCnt"] = count($array);

		echo json_encode($response);
	}
	public function get_members()
	{
		$user_id = $this->input->get('user_id');
		//$offset=$this->input->get('offset');
		//no of record per page
		//$no_of_rec=$this->input->get('no_of_rec');
		//$user_id=12;
		$this->db->where("userid", $user_id);
		$this->db->where("active", '1');
		$this->db->order_by("id", "asc");
		//$this->db->limit($no_of_rec,$offset);
		$array    = $this->member_m->get();
		// array for JSON response
		$response = array();
		if (count($array)) {
			$response["success"] = 1;
			$response["members"] = array();
			foreach ($array as $val) {
				$member                = array();
				$member["id"]          = $val->id;
				$member["name"]        = $val->fname . " " . $val->lname;
				$member["gender"]      = $val->gender;
				$member["age"]         = $val->age;
				$member["birth_info"]  = $val->birth_info;
				$member["birth_day"]   = $val->birth_day;
				$member["birth_month"] = $val->birth_month;
				$member["birth_year"]  = $val->birth_year;
				$member["userid"]      = $val->userid;
				$member["email"]       = $val->email;
				$member["profile_pic"] = $val->profile_pic;
				$member["type"]        = $val->type;
				// push single product into final response array
				array_push($response["members"], $member);
			}
		} else {
			$response["success"] = 0;
			$response["message"] = "No members found";
		}
		// $response["success"] =$offset."q".$this->db->last_query();
		echo json_encode($response);
	}
	// Get Members Details
	public function get_members_details()
	{
		$data      = array();
		$data1     = array();
		$member_id = $this->input->get("member_id");

		$this->db->where("id", $member_id);
		$this->db->order_by("id", "asc");
		$array = $this->member_m->get();
		if (count($array)) {
			$array1   = $this->member_record_m->get_records_for_android($member_id);
			$response = array();

			$response["success"]       = 1;
			$response["member_detail"] = array();
			error_reporting(E_ERROR | E_PARSE);

			$member = array();

			/*	 $member["id"]=$array1['id'];
			 $member["name"]=$array['name'];
			 $member["gender"]=$array['gender'];
			 $member["age"]=$array['age'];*/
			foreach ($array as $val) {
				$member["id"]          = $val->id;
				$member["fname"]       = $val->fname;
				$member["lname"]       = $val->lname;
				$member["email"]       = $val->email;
				$member["gender"]      = $val->gender;
				$member["age"]         = $val->age;
				$member["birth_day"]   = $val->birth_day;
				$member["birth_month"] = $val->birth_month;
				$member["birth_year"]  = $val->birth_year;
				$member["profile_pic"] = $val->profile_pic;
				$member["type"]  	   = $val->type;
				// push single product into final response array
				array_push($response["member_detail"], $member, $array1);

			}

		} else {
			$response["success"] = 0;
			$response["message"] = "No members found";
		}
		// $response["success"] =$offset."q".$this->db->last_query();
		echo json_encode($response);
	}

	public function signup()
	{
		$data                    = $this->register_m->array_from_post(array(
            'fname',
            'lname',
            'email',
            'passwd',
            'login_status'
            ));
            $data['passwd']          = $this->register_m->hash($data['passwd']);
            $data["roleid"]          = "2";
            $data["parentid"]        = "2";
            $data["first_member_id"] = "0";

            $this->db->where("email", $data["email"]);
            $email_cnt = $this->register_m->get_single_value(NULL, "os-pii-user", "email");

            //   echo var_dump($email_cnt);

            //adding first member
            //   echo var_dump($data);


            if ($email_cnt == "0") {
            	$user_id                 = $this->register_m->save($data, "", "os-pii-user");
            	$data_ul["userid"]       = $user_id;
            	$data_ul["email"]        = $data['email'];
            	$now                     = date("Y-m-d H:i:s");
            	$data_ul["log_datetime"] = $now;
            	$data_ul["user_status"]  = "register_mailsent";
            	$this->register_m->save($data_ul, "", "os-pii-user-log");
            	$data1["fname"]          = $data["fname"];
            	$data1["lname"]          = $data["lname"];
            	$data1["email"]          = $data["email"];
            	$data1["gender"]         = "0";
            	$data1["birth_info"]     = "0";
            	$data1["age"]            = "0";
            	$data1["birth_day"]      = "0";
            	$data1["birth_month"]    = "0";
            	$data1["birth_year"]     = "0";
            	$data1["userid"]         = $user_id;
            	$fm                      = $this->member_m->save($data1);
            	$data["first_member_id"] = $fm;
            	$dat                     = array(
                'first_member_id' => $fm
            	);

            	$this->db->where('id', $user_id);
            	$this->db->update('os-pii-user', $data);

            	//   $user_id=$this->register_m->update($data1, "","os-pii-user");
            	//Send Mail to Corsponding Email
            	$to      = $data["email"];
            	$subject = 'Ospinet Site Registration Confirmation Link';
            	$msg     = "<html><head><title>Ospinet</title></head><body><table cellspacing=\"4\" cellpadding=\"4\" border=\"0\" align=\"center\"><tr>";
            	$msg .= "<td>Welcome to Ospinet " . $data["fname"] . " " . $data["lname"] . "!</td></tr>";
            	$msg .= "<tr><td></td></tr>";
            	$msg .= "<tr><td>Please click on the link below to complete registration.</td></tr>";
            	$msg .= "<tr><td><a href='www.ospinet.com/register/confirmregistration/" . hash("sha1", $data["email"]) . "'>Ospinet Account Verification</a></td></tr>";
            	$msg .= "</table></body></html>";
            	// Make sure to escape quotes
            	$headers = 'MIME-Version: 1.0' . "\r\n";
            	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            	$headers .= 'From:admin@ospinet.com' . "\r\n";
            	$headers .= 'Bcc: kashelani@gmail.com' . "\r\n";
            	mail($to, $subject, $msg, $headers);
            	$json['signupmsg'][] = array(
                "signupstatus" => "Welcome " . $data["fname"] . ", " . $data["lname"] . "! Please click on the link that has been mailed to " . $data["email"] . " to complete registration."
                );
            } else {
            	$json['signupmsg'][] = array(
                "signupstatus" => "Email Address already exist"
                );
            }
            echo json_encode($json);
	}

	// Add Member or Update Member
	public function add_member()
	{		
		$response = array();

		require "class.validator.inc";
		$data1 = $_POST;

		// define the rules

		$rules = array(
            "fname" => "Require",
            "lname" => "Require",
            "gender" => "Require",
            "birth_info" => "Require"
            );

            $message = array(
            "fname" => "Invalid First Name", // if this field left empty this messege will show.
            "lname" => "Invalid Last Name", // if this field left empty this messege will show.
            "gender" => "Please Select Gender", // if this field left empty this messege will show.
            "birth_info" => "Please Enter Value" // if this field left empty this messege will show.
            );

            $objValidator = new Validator($rules, $message);
            $str_error    = "";
            error_reporting(E_ERROR | E_PARSE);

            $member_id = $this->input->post("member_id");
			$profile_pic = $this->input->post('profile_pic');
			$email = $this->input->post('email');
				
			if(isset($profile_pic)){				
				
			         $config['upload_path']   = 'profile_pic';
					// set the filter image types
					$config['allowed_types'] = 'gif|jpg|png';
					//load the upload library
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->set_allowed_types('*');
					$data['upload_data'] = $profile;
					//if not successful, set the error message
					if (!$this->upload->do_upload('profile_pic')) {
						$data = array(
			                'msg' => $this->upload->display_errors()
						);
					} else { //else, set the success message
						$data = array(
			                'msg' => "Upload success!"
			                );			
			                $data['upload_data'] = $this->upload->data();
					}					
				$dimension = "";
			if ($data['upload_data']['image_width'] >= $data['upload_data']['image_height']) {
				$dimension = $data['upload_data']['image_height'];
			} else {
				$dimension = $data['upload_data']['image_width'];
			}
			 
			$this->load->library('image_lib');
			//create square image
			$config1['image_library']  = 'GD2';
			$config1['new_image']      = 'profile_pic/member_pic/' . $data['upload_data']['raw_name'] . $dimension . $data['upload_data']['file_ext'];
			// $config1['create_thumb'] = TRUE;
			$config1['maintain_ratio'] = FALSE;
			$config1['quality']        = '100%';
			$config1['source_image']   = 'profile_pic/' . $data['upload_data']['file_name'];
			$opArray                   = $this->getOptimalCrop($dimension, $dimension, $data['upload_data']['image_width'], $data['upload_data']['image_height']);
			$config1['x_axis']         = (($opArray["optimalWidth"] / 2) - ($dimension / 2));
			$config1['y_axis']         = (($opArray["optimalHeight"] / 2) - ($dimension / 2));
			$config1['width']          = $dimension;
			$config1['height']         = $dimension;
			$this->image_lib->initialize($config1);
			$this->image_lib->crop();
			 
			//250 X 250
			$config2['image_library']  = 'GD2';
			$config2['new_image']      = 'profile_pic/member_pic_250/' . $data['upload_data']['raw_name'] . '_250' . $data['upload_data']['file_ext'];
			$config2['maintain_ratio'] = FALSE;
			$config2['quality']        = '100%';
			$config2['source_image']   = 'profile_pic/member_pic/' . $data['upload_data']['raw_name'] . $dimension . $data['upload_data']['file_ext'];
			$config2['width']          = '250';
			$config2['height']         = '250';
			$this->image_lib->initialize($config2);
			$this->image_lib->resize();
			 
			//80 X 80
			$config3['image_library']  = 'GD2';
			$config3['new_image']      = 'profile_pic/member_pic_80/' . $data['upload_data']['raw_name'] . '_80' . $data['upload_data']['file_ext'];
			$config3['maintain_ratio'] = FALSE;
			$config3['quality']        = '100%';
			$config3['source_image']   = 'profile_pic/member_pic/' . $data['upload_data']['raw_name'] . $dimension . $data['upload_data']['file_ext'];
			$config3['width']          = '80';
			$config3['height']         = '80';
			$this->image_lib->initialize($config3);
			$this->image_lib->resize();
			 
			//35 X 35
			$config4['image_library']  = 'GD2';
			$config4['new_image']      = 'profile_pic/member_pic_35/' . $data['upload_data']['raw_name'] . '_35' . $data['upload_data']['file_ext'];
			$config4['maintain_ratio'] = FALSE;
			$config4['quality']        = '100%';
			$config4['source_image']   = 'profile_pic/member_pic/' . $data['upload_data']['raw_name'] . $dimension . $data['upload_data']['file_ext'];
			$config4['width']          = '35';
			$config4['height']         = '35';
			$this->image_lib->initialize($config4);
			$this->image_lib->resize();		
					
				$profile = $data['upload_data']['orig_name'];
				$pic = explode(".", $profile);				
				$name = $pic[0];
				$type = $pic[1];								
			}else{
				$name == "NULL";
				$type == "NULL";
			}
			
			if(isset($email)){
				$mail = $email;
			}else{
				$mail == NULL;
			}
			
            $data1 = array(
            'profile_pic' => $name,
            'type' => $type,
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $mail,
            'gender' => $this->input->post('gender'),
            'birth_info' => $this->input->post('birth_info'),
            'birth_day' => $this->input->post('birth_day'),
            'birth_month' => $this->input->post('birth_month'),
            'birth_year' => $this->input->post('birth_year'),
            'userid' => $this->input->post('userid')
            );
            
            
            if ($objValidator->isValid($data1)) {
            	if ($this->input->post('birth_info') == 'age') {
            		$data1 += array(
                    "age" => $this->input->post('age')
            		);
            		//echo var_dump($data1);

            		if ($this->input->post('age') == '') {
            			echo "success = 0 ";
            			echo "\n";
            			echo "Data Not Saved ";
            			echo "\n";
            			echo "Age is Required";
            			break;
            		}
            	}
            	if ($this->input->post('birth_info') == 'dob') {
            		$data1 += array(
                    "birth_day" => $this->input->post('birth_day')
            		);
            		$data1 += array(
                    "birth_month" => $this->input->post('birth_month')
            		);
            		$data1 += array(
                    "birth_year" => $this->input->post('birth_year')
            		);

            		if ($this->input->post('birth_day') == '' || $this->input->post('birth_month') == '' || $this->input->post('birth_year') == '') {
            			echo "success = 0 ";
            			echo "\n";
            			echo "Data Not Saved ";
            			echo "\n";
            			echo "birth_day or birth_month or birth_year is Required";
            		} else {
            			$month1   = $data['birth_month'] + 1;
            			$birthday = new DateTime($data1['birth_year'] . '-' . $month1 . '-' . $data1['birth_day']);
            			$today    = new DateTime($this->getTimeZoneByIP());
            			$diff     = $birthday->diff($today);
            			$months   = $diff->format('%m') + 12 * $diff->format('%y');
            			$years    = $diff->format('%y');

            			$data1 += array(
                        "age" => $years
            			);
            		}
            	}
            	if ($this->input->post('birth_info') == 'unborn') {
            		$data1 += array(
                    "birth_day" => $this->input->post('birth_day')
            		);
            		$data1 += array(
                    "birth_month" => $this->input->post('birth_month')
            		);
            		$data1 += array(
                    "birth_year" => $this->input->post('birth_year')
            		);

            		if ($this->input->post('birth_day') == '' || $this->input->post('birth_month') == '' || $this->input->post('birth_year') == '') {
            			echo "success = 0 ";
            			echo "\n";
            			echo "Data Not Saved ";
            			echo "\n";
            			echo "birth_day or birth_month or birth_year is Required";
            		} else {
            			$month1   = $data['birth_month'] + 1;
            			$birthday = new DateTime($data1['birth_year'] . '-' . $month1 . '-' . $data1['birth_day']);
            			$today    = new DateTime($this->getTimeZoneByIP());
            			$diff     = $birthday->diff($today);
            			$months1  = $diff->format('%m') + 12 * $diff->format('%y');
            			$years    = $diff->format('%y');

            			$data1 += array(
                        "age" => 0
            			);
            		}
            	}

            	if ($member_id == NULL) {
            		$array = $this->member_m->save($data1);
            	} else {
            		$array = $this->member_m->edit_mem($member_id, $data1);
            	}
            	error_reporting(E_ERROR | E_PARSE);
            	$response["success"] = 1;
            	$response["members"] = array();

            	$member                = array();
            	$member["fname"]       = $data1['fname'];
            	$member["lname"]       = $data1['lname'];
            	$member["email"]       = $data1['email'];
            	$member["gender"]      = $data1['gender'];
            	$member["birth_info"]  = $data1['birth_info'];
            	$member["age"]         = $data1['age'];
            	$member["birth_day"]   = $data1['birth_day'];
            	$member["birth_month"] = $data1['birth_month'];
            	$member["birth_year"]  = $data1['birth_year'];
            	$member["profile_pic"] = $profile;

            	//$member["type"]=$data1['type'];
            	// push single product into final response array
            	array_push($response["members"], $member);

            } else {
            	// get the list of form fields which have errorful data
            	$errors = $objValidator->ErrorFields();

            	foreach ($errors as $key => $var) {
            		$str_error .= " Data Not Saved, " . $var . " :  ";
            		// collect error for each error full field
            		$value = $objValidator->getErrors($var);

            		if (is_array($value))
            		// if the field have more then one validation rule faild then an array will return
            		$str_error .= implode(" * ", $value);

            		else
            		$str_error .= $value;
            		$str_error .= "<br/>";
            	}
            	$response["success"] = 0;
            	$response["message"] = $str_error;
            }

            // $response["success"] =$offset."q".$this->db->last_query();
            echo json_encode($response);
	}

	// Delete Member
	public function delete_member()
	{
		$member_id = $this->input->post("member_id");

		If ($member_id != '') {

			$this->db->where("id", $member_id);
			$this->db->update('os-pii-member', array(
                "active" => "0"
                ));

                echo "success = 1 ";
                echo "\n";
                echo "Member Delete Successfully";
		} else {
			echo "success = 0 ";
			echo "\n";
			echo "member_id is : Require";
		}

	}

	//  Add or Update Records
	public function add_record()
	{
		$record_id = $this->input->post('record_id');
		$tagname   = $this->input->post('tagname');
		$filename=$this->input->post('filename');

		$response = array();
		require "class.validator.inc";

		// define the rules
		$rules = array(
            "title" => "Require",
            "description" => "Require"
            );

            $objValidator = new Validator($rules);
            error_reporting(E_ERROR | E_PARSE);
            $str_error = "";

            $data = array(
            'member_id' => $this->input->post('member_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'date' => $this->getTimeZoneByIP()
            );


            if ($objValidator->isValid($data)) {
            	if ($record_id == NULL) {
            		$array = $this->member_record_m->save($data);
            		// File save
            		$this->load->library('upload');
            		$config['upload_path']   = 'media_files'; //if the files does not exist it'll be created
            		$config['allowed_types'] = 'gif|jpg|png|bmp|pdf|jpeg';
            		//$config['allowed_types'] = '*';
            		$config['max_size']      = '5120'; //size in kilobytes
            		$config['encrypt_name']  = false;
            		$this->upload->initialize($config);
            		$uploaded = $this->upload->up(false); //Pass true if you want to create the index.php files
            		$fiels    = "";
            		$i        = 1;
            		foreach ($uploaded["success"] as $item => $v) {
            			$filename             = array();
            			$filename["filename"] = $v["file_name"];
            			//echo var_dump($filename);
            			$this->db->insert("os-pii-member-temp-record-file", $filename);
            		}

            		if ($filename != '') {
            			$pages = $this->member_record_m->get_all_temp();

            			$new_rec1 = array();
            			if (count($pages)):
            			foreach ($pages as $page):
            			$filename = $page["filename"];
            			// echo var_dump($filename);
            			$this->member_record_m->save(array(
                                "member_record_id" => $array,
                                "member_id" => $this->input->post('member_id'),
                                "filename" => $filename

            			), "", "os-pii-member-record-files");

            			$new_rec1 += array(
            			$i => array(
                                    "member_record_id" => $array,
                                    "member_id" => $this->input->post('member_id'),
                                    "filename" => $filename
            			)
            			);
            			$i++;
            			endforeach;
            			endif;
            			$data += array(
                        "recImage" => $new_rec1
            			);
            			$this->db->empty_table("os-pii-member-temp-record-file");
            			array_unshift($data["rec"], $data);
            		}
            		//Save tag
            		if ($record_id == NULL) {

            			$new_rec = array(
                        "recTags" => array()
            			);

            			$data_tag = explode(",", $tagname);
            			$i        = 0;
            			foreach ($data_tag as $tagname):
            			$new_rec["recTags"] += array(
            			$i => array(
                                "tagname" => $data_tag
            			)
            			);
            			$i++;

            			$tag_count = $this->member_record_m->check_tagname($tagname);

            			if (count($tag_count) == 0) {

            				$this->db->insert('os-pii-tags_master', array(
                                "tagname" => $tagname,
                                "userid" => $this->session->userdata('id')
            				));
            				$tag_id          = $this->db->insert_id();
            				$data_record_tag = array(
                                "tagid" => $tag_id,
                                "recordid" => $array
            				);
            				$this->db->insert('os-pii-records-tag', $data_record_tag);
            			} else {
            				foreach ($tag_count as $tags):
            				$data_record_tag = array(
                                    "tagid" => $tags["id"],
                                    "recordid" => $array
            				);
            				$this->db->insert('os-pii-records-tag', $data_record_tag);
            				endforeach;
            			}
            			endforeach;
            		}
            	}
            	//Update Tag
            	else {
            		$this->db->where("recordid", $record_id);
            		$this->db->delete("os-pii-records-tag");

            		$new_rec = array(
                    "recTags" => array()
            		);

            		$data_tag = explode(",", $tagname);
            		$i        = 0;
            		foreach ($data_tag as $tagname):
            		$new_rec["recTags"] += array(
            		$i => array(
                            "tagname" => $data_tag
            		)
            		);
            		$i++;

            		$tag_count = $this->member_record_m->check_tagname($tagname);

            		if (count($tag_count) == 0) {

            			$this->db->insert('os-pii-tags_master', array(
                            "tagname" => $tagname,
                            "userid" => $this->session->userdata('id')
            			));
            			$tag_id          = $this->db->insert_id();
            			$data_record_tag = array(
                            "tagid" => $tag_id,
                            "recordid" => $record_id
            			);
            			$this->db->insert('os-pii-records-tag', $data_record_tag);
            		} else {
            			foreach ($tag_count as $tags):
            			$data_record_tag = array(
                                "tagid" => $tags["id"],
                                "recordid" => $record_id
            			);
            			$this->db->insert('os-pii-records-tag', $data_record_tag);
            			endforeach;
            		}
            		endforeach;

            		$this->db->where('id', $record_id);
            		$this->db->update('os-pii-member_record', $data);
            		//Update file

            		if ($record_id != NULL) {
            			$this->load->library('upload');
            			$config['upload_path']   = 'media_files'; //if the files does not exist it'll be created
            			$config['allowed_types'] = 'gif|jpg|png|bmp|pdf|jpeg';
            			//$config['allowed_types'] = '*';
            			$config['max_size']      = '5120'; //size in kilobytes
            			$config['encrypt_name']  = false;
            			$this->upload->initialize($config);
            			$uploaded = $this->upload->up(false); //Pass true if you want to create the index.php files
            			$fiels    = "";
            			$i        = 1;
            			foreach ($uploaded["success"] as $item => $v) {

            				$filename["filename"] = $v["file_name"];
            				$this->db->insert("os-pii-member-temp-record-file", $filename);
            			}

            			if ($filename != '') {
            				$pages = $this->member_record_m->get_all_temp();

            				$new_rec1 = array();
            				if (count($pages)):
            				foreach ($pages as $page):
            				$filename = $page["filename"];
            				// echo var_dump($filename);
            				$this->member_record_m->save(array(
                                    "member_record_id" => $array,
                                    "member_id" => $this->input->post('member_id'),
                                    "filename" => $filename

            				), "", "os-pii-member-record-files");

            				$new_rec1 += array(
            				$i => array(
                                        "member_record_id" => $array,
                                        "member_id" => $this->input->post('member_id'),
                                        "filename" => $filename
            				)
            				);
            				$i++;
            				endforeach;
            				endif;
            				$data += array(
                            "recImage" => $new_rec1
            				);
            				$this->db->empty_table("os-pii-member-temp-record-file");
            				array_unshift($data["rec"], $data);

            			}
            		}
            	}
            	$response["success"]       = 1;
            	$response["member_detail"] = array();

            	$member                = array();
            	$member["title"]       = $data['title'];
            	$member["description"] = $data['description'];
            	$member["filename"]    = $filename;
            	$member["tagname"]     = $data_tag;
            	// push single product into final response array
            	array_push($response["member_detail"], $member);
            } else {
            	// get the list of form fields which have errorful data
            	$errors = $objValidator->ErrorFields();
            	// show the number of error
            	//  echo "<br/> you have total ".$objValidator->CountError()." errors.<br/>Fields are :".implode(",",$errors);
            	// echo "<br/><hr/>";

            	foreach ($errors as $key => $var) {
            		$str_error .= " Data Not Saved, " . $var . " :  ";
            		// collect error for each error full field
            		$value = $objValidator->getErrors($var);

            		if (is_array($value))
            		// if the field have more then one validation rule faild then an array will return
            		$str_error .= implode(" * ", $value);

            		else
            		$str_error .= $value;
            		$str_error .= " <br/>";
            	}
            	$response["success"] = 0;
            	$response["message"] = $str_error;
            }
            // $response["success"] =$offset."q".$this->db->last_query();
            echo json_encode($response);
	}
	// Search Records
	public function search_records()
	{
		$type      = $this->input->post('type');
		$search_of = $this->input->post('search');
		$member_id = $this->input->post('mem_id');

		if ($search_of != '') {
			if (strpos(trim($search_of), ' ') !== false) {
				$search = explode(" ", $search_of);
			} else {
				$search[0] = trim($search_of);
			}
			$data                = $this->member_record_m->find_records($member_id, $type, $search);
			$response["success"] = 1;
			$response["result"]  = array();
			if (count($data) != '0') {
				foreach ($data as $output) {
					if ($output['active'] == '1' && $output['member_id'] != '' && $output['member_id'] == $member_id) {
						array_push($response["result"], $output);
					}
				}
			} else {
				$response["success"] = 0;
				$response["message"] = "No record found";
			}
		} else {
			$response["success"] = 0;
			$response["message"] = "Enter text to search";
		}
		echo json_encode($response);
	}
	// Get files to share Records
	public function get_files()
	{
		$record_id = $this->input->post('record_id');
		$names     = $this->member_record_m->get_record_files($record_id);

		$response["success"] = 1;
		$response["result"]  = array();
		if (count($names) != '0') {
			array_push($response["result"], $names);
		} else {
			$response["success"] = 0;
			$response["message"] = "No Files to Share";
		}
		echo json_encode($response);
	}

	// Get contacts to share Records
	public function get_contacts()
	{
		$user_id = $this->input->post("user_id");
		 
		$contact = $this->member_m->get_contacts($user_id);

		$response["success"] = 1;
		$response["result"]  = array();
		foreach ($contact as $conatcts) {
			if (count($conatcts) != '0') {
				array_push($response["result"], $conatcts);
			} else {
				$response["success"] = 0;
				$response["message"] = "Please add contacts to use share feature";
			}
		}
		echo json_encode($response);
	}

	// share Records
	public function share_records()
	{
		$to_id     = $this->input->post("to_id");
		$from_id   = $this->input->post("from_id");
		$record_id = $this->input->post("record_id");

		if ($to_id != NULL && $from_id != NULL && $record_id != NULL) {
			$share_records       = $this->notification_m->add_to_notification($to_id, $from_id, $record_id);
			$response["success"] = 1;
			$response["message"] = "Record shared successfully";
		} else {
			$response["success"] = 0;
			$response["message"] = "Please check paramets";
		}
		echo json_encode($response);
	}

	//Delete Records
	public function delete_record()
	{
		$record_id = $this->input->post('record_id');

		if ($record_id != '') {

			$this->db->where("id", $record_id);
			$this->db->update('os-pii-member_record', array(
                "active" => "0"
                ));

                $this->db->where("recordid", $record_id);
                $this->db->delete('os-pii-records-tag');

                $this->db->where("member_record_id", $record_id);
                $this->db->update('os-pii-member-record-files', array(
                "active" => "0"
                ));

                echo "success = 1 ";
                echo "\n";
                echo "Record Delete Successfully";
		} else {
			echo "success = 0 ";
			echo "\n";
			echo "record_id is : Require";
		}
	}
	//Recover Password
	public function forgotpassword_mailsent()
	{
		$user = $this->register_m->get_by(array(
            'email' => $this->input->post('email')
		), TRUE);
		$this->register_m->save(array(
            "login_status" => 'passwordnotset'
            ), $user->id);
            //Send Mail to Corsponding Email
            echo 'An email has been sent to your email address. </br> Please check your email account to reset password.</br></br>
		  ';
            $now = Time();

            //new mail structure
            $msg     = "";
            $to      = $user->email;
            $subject = 'Ospinet - Reset Password';

            $msg = "
               <html>
       <head>
               <title>Ospinet</title>
               </head>
       <body>
               <table width=\"100%\" style=\"border:1px solid #CCCCCC\" cellspacing=\"0\" cellpadding=\"4\" border=\"0\" align=\"center\">
         ";
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;padding-top: 12px;\"><a href='" . base_url() . "user/dashboard'><img src='" . base_url() . "assets/images/b_400x100.png' width='200' height='50'/></a></td>
                 </tr>
         ";
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"></td>
                 </tr>
         ";
            $msg .= "
         <tr>
                   <td width=\"80%\" style=\"padding-left: 12px;font-weight:bold;font-size: 16px;color:#222;\">
				    Hello " . $user->fname . " " . $user->lname . ",</td>
                   <td ></td>
                 </tr>
         ";

            $msg .= "
         <tr>
					<td colspan=\"2\" style=\"padding-left: 12px;\"><a href='http://www.ospinet.com/app_ws/android_app_fun/update_pwd?ts=$now&email=" . hash("sha1", $user->email) . "'> Please click here to change your password.</a>
					</td>
         </tr>
         ";

            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"></td>
                 </tr>
         ";
            $msg .= "
         <tr>
                   <td 
               style=\"padding-top: 20px;padding-left: 12px;padding-bottom: 20px;border-top:1px solid #CCCCCC;color:#888888;background-color:#F6F6F6\" 
               colspan=\"2\">Copyright © Ospinet. All rights reserved.
             </td>
                 </tr>
         ";
            $msg .= "
       </table>
               </body>
       </html>
               ";
            // Make sure to escape quotes
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:Ospinet<admin@ospinet.com>' . "\r\n";
            $headers .= 'Bcc: kashelani@gmail.com' . "\r\n";
            mail($to, $subject, $msg, $headers);
            //			$array=array($data["fname"],$data["lname"],$data["email"]);
            //			$serialized = rawurlencode(serialize($array));
            // echo  "Welcome ".$data["fname"].", ".$data["lname"]."! Please click on the link that has been mailed to ".$data["email"]." to complete registration.";
            //  echo $serialized;
	}
	//Update Password
	public function update_pwd()
	{
		$ts       = $_GET['ts'];
		$t        = Time();
		$old_time = ($t - $ts); {
			$msg  = "";
			$user = $this->register_m->get_by(array(
                'sha1(email)' => ($this->input->get('email'))
			), TRUE);

			$this->load->view('templates/user/reset_android_password', $user);

		}
	}
	public function password_set()
	{
		$newpwd = $this->input->post('newpwd');

		$user = $this->register_m->get_by(array(
            'email' => $this->input->post('email')
		), TRUE);
		if (count($user) && $user->login_status == 'passwordnotset') {
			$this->register_m->save(array(
                "login_status" => 'confirm',
                "passwd" => $this->register_m->hash($this->input->post('newpwd'))
			), $user->id);
			$msg = 'The password has beeen successfully changed </br></br>
		  		<a href="' . base_url() . '"> 
		        <button type="reset" style="width:100%; margin-bottom:5px;" class="btn btn-primary btn-stroke">Back</button>
		  		</a>
		  ';
			echo $msg;
		} else {
			$msg = 'Your link is expired </br></br>
		  		<a href="' . base_url() . '"> 
		        <button type="reset" style="width:100%; margin-bottom:5px;" class="btn btn-primary btn-stroke">Back</button>
		  		</a>
		  		';
			echo $msg;
		}

	}
	// Friend search
	//**************************************************
	// IMPORTANT changes in register_m to make this run
	//**************************************************
	public function search_friends()
	{
		$email_id = $this->input->post("email");
		$user_id = $this->input->post("user_id");
		 
		if ($email_id != NULL) {
			if (filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
				$data = $this->register_m->do_search_email($email_id,$user_id);
				if (count($data) != '0') {

					$response["success"] = 1;
					$response["result"]  = array();
					array_push($response["result"], $data);
				}else {
					$response["success"] = 0;
					$response["message"] = "Sorry no result found";
				}
			} else {
				$response["success"] = 0;
				$response["message"] = "Invalid email Address";
			}
		} else {
			$response["success"] = 0;
			$response["message"] = "Enter email Address";
		}
		echo json_encode($response);
	}
	// Send Friend Request
	public function send_friend_request()
	{
		$to_userid = $this->input->post("to_userid");
		$from_userid = $this->input->post("user_id");

		$response["success"] = 1;

		if ($to_userid != NULL) {
			$data                = $this->notification_m->send_request($to_userid,$from_userid);
			$response["message"] = "friend request send successfully";
		} else {
			$response["success"] = 0;
			$response["message"] = "User Id is wrong";
		}
		echo json_encode($response);
	}
	// Get request count
	public function get_request_count()
	{
		$user_id = $this->input->post("user_id");
		 
		$data = $this->notification_m->get_request_count($user_id);

		$response["success"] = 1;
		$response["result"]  = $data;

		echo json_encode($response);
	}
	// Get Friend request
	public function get_Friend_request()
	{
		$user_id = $this->input->post("user_id");
		$data = $this->notification_m->get_request_popup($user_id);

		$response["success"] = 1;
		$response["result"]  = array();

		array_push($response["result"], $data);

		echo json_encode($response);
	}
	// Get notification count
	public function get_notification_count()
	{
		$user_id = $this->input->post("user_id");
		 
		$record_count  = count($this->notification_m->check_alerts_share($user_id));
		$request_count = count($this->notification_m->check_alerts_request($user_id));
		$count         = $record_count + $request_count;

		$response["success"] = 1;
		$response["result"]  = $count;

		echo json_encode($response);
	}
	// Get Notifications
	public function get_notifications()
	{
		$user_id = $this->input->post("user_id");
		 
		$request      = $this->notification_m->check_alerts_request($user_id);
		$record_share = $this->notification_m->check_alerts_share($user_id);

		$response["success"] = 1;
		$response["result"]  = array();

		if (count($record_share) == 0) {
			foreach ($request as $friend):
			$friends = $this->notification_m->alert_messages($friend['type_id'],$user_id);
			array_push($response["result"], $friends);
			endforeach;
		}
		if (count($request) == 0) {
			foreach ($record_share as $share):
			$doc = $this->notification_m->alert_messages($share['type_id'],$user_id);
			array_push($response["result"], $friends);
			endforeach;
		}
		if (count($request) != 0 && count($record_share) != 0) {
			foreach ($request as $friend):
			$friends = $this->notification_m->alert_messages($friend['type_id'],$user_id);
			foreach ($record_share as $share):
			$doc = $this->notification_m->alert_messages($share['type_id'],$user_id);
			endforeach;
			$popup = array_merge($doc, $friends);
			array_push($response["result"], $popup);
			endforeach;
		}
		echo json_encode($response);
	}
	// Show Notifications untill he click on it
	public function notifications_seen()
	{
		$request_id = $this->input->post('request_id');
		$type_id    = $this->input->post('type');
		$user_id = $this->input->post("user_id");

		$data = $this->register_m->close_seen_alert($request_id, $type_id,$user_id);

		$response["success"] = 1;
		$response["message"] = "Removed form notification.";

		echo json_encode($response);
	}
	// Accept Friend Request
	public function accept_request()
	{
		$confirm_value = $this->input->post('request_id');
		$user_id = $this->input->post("user_id");

		$response["success"] = 1;

		if ($confirm_value != NULL) {
			$data                = $this->register_m->confirm_request($confirm_value,$user_id);
			$add                 = $this->register_m->add_to_contacts($confirm_value,$user_id);
			$add_to_friend       = $this->register_m->add_to_friend_contact($confirm_value,$user_id);
			$response["message"] = "Successfully added to your contacts";
		} else {
			$response["success"] = 0;
			$response["message"] = "request_id is blank";
		}
		echo json_encode($response);
	}
	// Ignore Friend Request
	public function ignore_request()
	{
		$ignore_value = $this->input->post('request_id');
		$user_id = $this->input->post("user_id");

		$response["success"] = 1;

		if ($ignore_value != NULL) {
			$data                = $this->register_m->ignore_request($ignore_value,$user_id);
			$response["message"] = "You Ignore the request";
		} else {
			$response["success"] = 0;
			$response["message"] = "request_id is blank";
		}
		echo json_encode($response);
	}
	// Create files & add record
	public function create_file()
	{
		$file_name = $this->input->post("file_name");
		$member_id = $this->input->post('member_id');
		$record_id = $this->input->post('record_id');
		$user_id = $this->input->post("user_id");

		$response["success"] = 1;

		if($file_name != NULL ){
			if($record_id != NULL){
				$response["result"]  = array();
				$data                = $this->files_m->add_file($file_name,$member_id);
				$array = explode(",", $record_id);
				foreach ($array as $rec_id):
				$value               = $this->files_m->add_records($rec_id,$data[1]);
				endforeach;
				$response["result"]  = "File is created and record is added";
			}else {
				$response["success"] = 0;
				$response["message"] = "Please select atlest one record to create file.";
			}
		}else {
			$response["success"] = 0;
			$response["message"] = "Please enter file name";
		}
		echo json_encode($response);
	}
	//Edit Files
	public function edit_file()
	{
		$file_name = $this->input->post("file_name");
		$member_id = $this->input->post('member_id');
		$file_id = $this->input->post('file_id');
		$record_id = $this->input->post('record_id');

		if($file_name != NULL && $member_id != NULL && $file_id != NULL){
			$response["success"] = 1;
			$data                = $this->files_m->edit_file($file_name,$member_id,$file_id);
			if($record_id != NULL){
				$response["success"] = 1;
				$response["result"]  = array();
				$array = explode(",", $record_id);
				foreach ($array as $rec_id):
				$result                = $this->files_m->add_records($rec_id,$file_id);
				endforeach;
			}else {
				$response["message"] = "No records are edited.";
			}
			$response["result"]  = "File edited Successfully";
		}else {
			$response["success"] = 0;
			$response["message"] = "Please check file input again";
		}
		 
		echo json_encode($response);
	}
	//Delete Files
	public function delete_file()
	{
		$file_id = $this->input->post('file_id');
		$member_id = $this->input->post('member_id');
		 
		$response["success"] = 1;

		if($file_id != NULL && $member_id !=NULL){
	   		$records = $this->files_m->count_records($file_id,$member_id);
			if(count($records) == 1){
				$response["success"] = 0;
				$response["message"] = "Atlest one record is requird, so you cannot delete this record";
			}else{
				$delete = $this->files_m->delete_file($file_id,$member_id);
				$response["message"]  = "File deleted Successfully";
			}
		}else{
			$response["success"] = 0;
			$response["message"] = "Please check input value";
		}
		echo json_encode($response);
	}
	//Delete records from File
	public function delete_records()
	{
		$file_id = $this->input->post('file_id');
		$member_id = $this->input->post('member_id');
		$record_id = $this->input->post('record_id');
		 
		$response["success"] = 1;

		if($file_id != NULL && $member_id !=NULL && $record_id !=NULL){
			$delete = $this->files_m->delete_record($file_id,$member_id,$record_id);
			$response["message"]  = "Record deleted Successfully";
		}else{
			$response["success"] = 0;
			$response["message"] = "Please check input value";
		}
		echo json_encode($response);
	}
	//Get details of shared file with login user 
	public function get_contact_file_details()
	{
		$contact_id = $this->input->post('contact_id');
		$user_id = $this->input->post('user_id');
		
		$response["success"] = 1;
		$response["result"]  = array();
	  	
		$arry=array();
		$data = $this->files_m->get_contact_file_details($contact_id,$user_id);
		if(count($data) != '0'){
			$i=0;
			foreach ($data as $file_id):
			$file_id["record"]=array();
			$rec_id = $this->files_m->get_files_records($file_id['file_id']);
			$j=0;
			foreach ($rec_id as $id):
			foreach ($id as $record['record_id']):
			$record_id = $this->files_m->get_records($record['record_id']);
			$file_id["record"][$j++] = $record_id;
			endforeach;
			endforeach;
			$arry[$i]=$file_id;
			$i++;
			endforeach;
		 array_push($response["result"], $arry);
		} else{
			$response["success"] = 0;
			$response["message"] = "No file found.";
		}
		echo json_encode($response);	
	}
	//Get details of file (Owner of the file login user)
	public function get_file_details()
	{
		$member_id = $this->input->post('member_id');
		$response["success"] = 1;
		$response["result"]  = array();
	  
		$arry=array();
		$data = $this->files_m->get_file_details($member_id);
		if(count($data) != '0'){
			$i=0;
			foreach ($data as $file_id):
			$file_id["record"]=array();
			$rec_id = $this->files_m->get_files_records($file_id['id']);
			$j=0;
			foreach ($rec_id as $id):
			foreach ($id as $record['record_id']):
			$record_id = $this->files_m->get_records($record['record_id']);
			$file_id["record"][$j++] = $record_id;
			endforeach;
			endforeach;
			$arry[$i]=$file_id;
			$i++;
			endforeach;
		 array_push($response["result"], $arry);
		} else{
			$response["success"] = 0;
			$response["message"] = "No file found.";
		}
		echo json_encode($response);
	}
	//Share file
	public function share_file()
	{
		$toid     = $this->input->post("to_id");
		$fromid   = $this->input->post("from_id");
		$fileid = $this->input->post("file_id");
		
		if($toid != NULL & $fromid != NULL & $fileid != NULL)
		{
			$i = 0;
			$array_id = explode(" ", $toid);
			foreach ($array_id as $key=>$new_id):
			$count = $this->files_m->check_notification($new_id,$fromid,$fileid);
			if($count == 0)
			{
				$toids = explode(",", $toid);
				foreach ($toids as $key=>$to_id):
				$data = $this->files_m->add_to_notification($to_id,$fromid,$fileid);
				endforeach;
			}
			endforeach;
			$response["success"] = 1;
			$response["message"] = "File shared successfully";
		}else {
			$response["success"] = 0;
			$response["message"] = "Please check input paramets";
		}
		echo json_encode($response);
	}
	// Get time
	public function getTimeZoneByIP()
	{
		// timezone
		$timezone = false;
		// pass this lat and long to http://www.earthtools.org/ API to get Timezone Offset in xml
		//https: //maps.googleapis.com/maps/api/timezone/json?location=39.6034810,-119.6822510&timestamp=1331161200&sensor=true_or_false
		$tz_xml   = $this->file_get_contents_curl('http://www.earthtools.org/timezone-1.1/18.53497040/73.876302799999960000');
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
public function getOptimalCrop($newWidth, $newHeight, $orgWidth, $orgHeight)
	# Author:     Jarrod Oberto

	# Date:       17-11-09

	# Purpose:    Get optimal crop dimensions

	# Param in:   width and height as requested by user (fig 3)

	# Param out:  Array of optimal width and height (fig 2)

	# Reference:

	# Notes:      The optimal width and height return are not the same as the

	#       same as the width and height passed in. For example:

	#

	#

	#   |-----------------|     |------------|       |-------|

	#   |             |   =>  |**|      |**|   =>  |       |

	#   |             |     |**|      |**|       |       |

	#   |           |       |------------|       |-------|

	#   |-----------------|

	#        original                optimal             crop

	#              size                   size               size

	#  Fig          1                      2                  3

	#

	#       300 x 250           150 x 125          150 x 100

	#

	#    The optimal size is the smallest size (that is closest to the crop size)

	#    while retaining proportion/ratio.

	#

	#  The crop size is the optimal size that has been cropped on one axis to

	#  make the image the exact size specified by the user.

	#

	#               * represent cropped area

	#
	{

		// *** If forcing is off...

		// *** ...check if actual size is less than target size
		if ($orgWidth < $newWidth && $orgHeight < $newHeight) {
			return array(
                'optimalWidth' => $orgWidth,
                'optimalHeight' => $orgHeight
			);
		}


		$heightRatio = $orgHeight / $newHeight;
		$widthRatio  = $orgWidth / $newWidth;

		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}

		$optimalHeight = round($orgHeight / $optimalRatio);
		$optimalWidth  = round($orgWidth / $optimalRatio);

		return array(
            'optimalWidth' => $optimalWidth,
            'optimalHeight' => $optimalHeight
		);
	}
	public function upload_records()
	{
		$this->load->library('upload');
		$config['upload_path']   = 'media_files'; //if the files does not exist it'll be created
		//$config['allowed_types'] = 'gif|jpg|png|bmp|ppt|pptx|xls|xlsx|pdf|doc|docs|txt|jpeg';
		$config['allowed_types'] = '*';
		$config['max_size']      = '5120'; //size in kilobytes
		$config['encrypt_name']  = false;
		$this->upload->initialize($config);
		$uploaded = $this->upload->up(false); //Pass true if you want to create the index.php files
		$fiels    = "";
		//$fiels='<table cellpadding="3" width="90%" align="center"> ';
		$i        = 1;
		foreach ($uploaded["success"] as $item => $v) {

			echo $data["filename"] = $v["file_name"];
			$this->db->insert("os-pii-member-temp-record-file", $data);
		}
	}

}
?>
