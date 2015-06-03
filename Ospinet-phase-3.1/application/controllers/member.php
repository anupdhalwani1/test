<?php
class member extends Frontend_Controller
{

	public function __construct()
	{
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		$this->load->model('member_m');
		$this->load->model('member_record_m');
	}

	public function index($start = 0)
	{
		$this->data['linkname']="member";
		$this->data["user_first_login"]   = $this->member_m->user_first_login();
		$this->data["first_login_member"] = $this->member_m->get_members();
		$this->data["tags"]               = $this->member_record_m->get_tags();
		//$this->data["get_frst_mmbr"]      = $this->member_m->get_frst_mmbr();
		$this->data['subview']            = "member/index";
		$this->load->view('_member_layout', $this->data);

		//	$this->db->empty_table("os-pii-member-temp-record-file");
	}


	public function edit($id = NULL)
	{
		if ($id) {
			$this->data['rc_list'] = $this->member_m->get($id);
		} else {
			$this->data['rc_list'] = $this->member_m->get_new();
		}
		if ($this->input->post("submit_form")) {
			$data = $this->member_m->array_from_post(array(
                'fname',
                'lname',
                'gender',
                'birth_info'
                ));
                if ($data["birth_info"] == "Dob") {
                	$data += $this->member_m->array_from_post(array(
                    'bd_year',
                    'bd_month',
                    'bd_day'
                    ));
                    $data['birth_year'] = $data['bd_year'];
                    unset($data['bd_year']);
                    $data['birth_month'] = $data['bd_month'];
                    unset($data['bd_month']);
                    $data['birth_day'] = $data['bd_day'];
                    unset($data['bd_day']);
                    $data["birth_month"] = $data["birth_month"] + 1;
                    $age                 = (date("md", date("U", mktime(0, 0, 0, $data['birth_month'], $data['birth_day'], $data['birth_year']))) > date("md") ? ((date("Y") - $data['birth_year']) - 1) : (date("Y") - $data['birth_year']));
                    $data["age"]         = $age;
                }
                if ($data["birth_info"] == "Age") {
                	$data += $this->member_m->array_from_post(array(
                    'age'
                    ));
                    $year = date('Y', strtotime('-' . $data["age"] . ' year', strtotime(date("Y-m-d"))));
                    $data += array(
                    "birth_year" => $year,
                    "birth_month" => "1",
                    "birth_day" => "1"
                    );
                }
                if ($data["birth_info"] == "Unborn") {
                	$data += $this->member_m->array_from_post(array(
                    'ub_year',
                    'ub_month',
                    'ub_day'
                    ));
                    $data['birth_year'] = $data['ub_year'];
                    unset($data['bd_year']);
                    $data['birth_month'] = $data['ub_month'];
                    unset($data['bd_month']);
                    $data['birth_day'] = $data['ub_day'];
                    unset($data['bd_day']);
                    $data["birth_month"] = $data["birth_month"] + 1;
                    $age                 = "0";
                }
                $data["userid"] = $this->session->userdata('id');
                $this->member_m->save($data, $id);
                redirect('member');
		} else {
			$this->data['subview'] = 'member/edit';
			$this->load->view('_main_layout', $this->data);
		}
	}
	public function delete($id)
	{
		$data["active"] = "0";
		$this->member_m->save($data, $id);
		redirect('member');
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

			$data["filename"] = $v["file_name"];
			$this->db->insert("os-pii-member-temp-record-file", $data);
			echo $this->db->last_query();
			/*$page_id=$this->media_m->save($data, "","images");
			 $config1['ima/resize a image
			 $this->load->library('image_lib');ge_library'] = 'gd2';
			 $config1['source_image']	= 'media_files/'.$v["file_name"];
			 $config1['create_thumb'] = TRUE;
			 $config1['maintain_ratio'] = TRUE;
			 $config1['width']	 = 100;
			 $config1['height']	= 60;
			 $this->image_lib->initialize($config1);
			 $this->image_lib->resize();*/
		}
	}
	public function upload_file()
	{
		$config['upload_path']   = 'profile_pic';
		// set the filter image types
		$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|xlxs|ppt|pptx|bmp|rtf|doc|docx';
		//load the upload library
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->set_allowed_types('*');
		$data['upload_data'] = '';
		//if not successful, set the error message
		if (!$this->upload->do_upload('userfile')) {
			$data = array(
                'msg' => $this->upload->display_errors()
			);
			var_dump($data);
		} else { //else, set the success message
			$data = array(
                'msg' => "Upload success!"
                );

                $data['upload_data'] = $this->upload->data();
                var_dump($this->upload->data());
		}
	}
	public function delete_temp_file()
	{
		$this->db->empty_table("os-pii-member-temp-record-file");
		$main_tags = $this->member_record_m->get_tags();
		foreach ($main_tags as $tags):
		echo $tags["tagname"] . ",";
		endforeach;
	}
	public function get_records()
	{
		$id    = $this->input->post('id');
		$names = $this->member_record_m->get_record_files($id);
		$rs    = "";
		foreach ($names as $name_list):
		$rs .= $name_list["filename"] . " ,";
		endforeach;
		echo ($rs);
	}
	public function filter_records()
	{
		$type    = $this->input->post('type');
		$input    = $this->input->post('input');
		$mem_id    = $this->input->post('member_id');
		 
		if(strpos(trim($input), ' ') !== false)
		{
			$search = explode(" ", $input);
		}else{
			$search[0]=trim($input);
		}
		if($type == "title")
		{
			$data = $this->member_record_m->find_records($mem_id,$type,$search);
			//echo $this->db->last_query();
			if(count($data) != '0')
			{
				$j=0;
				foreach ($data as $mem_details)
				{
					if($mem_details['member_id'] == $mem_id && $mem_details['member_id'] != '' && $mem_details['active'] == '1'){
						$output ='	<div style="border:1px solid #CECECE; border-radius: 5px; margin: 0 0 10px;">
						<div class="box-generic padding-none" id="record_delete_'.$mem_details['id'].'">
							
							<a class="share_demo" id="'.$mem_details['id'].'">
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="'.$mem_details['id'].'" class="btn btn-default"><i class="fa fa-share-square-o"></i> Share</button>
								</div>
							</a>
								
								<a id="'.$mem_details['id'].'" class="report_edit_btn">
								<button id="'.$mem_details['id'].'" class="report_edit_btn btn btn-default btn-sm" style="height: 30px; margin-top: 10px; float: right;"><i class="fa fa-fw fa-edit"></i> Edit</button>
								<h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width:450px;">'.$mem_details['title'].'</h5>
								</a>
			
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i>'.$mem_details['date'].'&nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>';
							
						$tagname = explode(",",$mem_details['tagname']);
						$k=0;
						foreach($tagname as $tags):
						$output.= '<span class="label label-primary">'.$tags.'</span>&nbsp;';
						$k++;
						endforeach;
							
						$output.= '</div>
								<div id="shared_with_'.$mem_details['id'].'">';
						if($mem_details['shared_with_name'] != ''){
							$output.= '
								<div id ="shared_names" class="innerAll half border-bottom" style="background-color:#1ba0a2;">
								<i id="'.$mem_details['id'].'" class="fa fa-share-square-o" style="padding-left: 10px; color: white;"> Shared with &nbsp;'.$mem_details['shared_with_name'].'</i>';
						}
						$output.= '</div>
								</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									'.$mem_details['description'].'
									</p>
								</div>
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR" style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>';
						if($mem_details['filename'] != ''){
							$files = explode(",",$mem_details['filename']);
							$i=0;
							foreach($files as $name):
							$type = explode(".",$name);
							if($type[1]=='pdf')
							{
								$output .= '<a data-url="'. base_url().'media_files/'.$name.'" id="'.$name.'" class="pdf_file strong text-regular" rel="media-gallery">'.$name.'</a>,&nbsp;';
								$i++;
							}
							else{
								$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href="'. base_url().'media_files/'.$name.'" rel="media-gallery"> '.$name.'</a>,&nbsp;';
								$i++;
							}
							endforeach;
						}else{
							$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" rel="media-gallery">No Files Found</a>';
						}
						$output .='</div>
												<div id="attachments_'.$mem_details['id'].'" style="display:none;">												
												</div>												
											</div>
											<div class="clearfix"></div>
										</div> 
									</div>
									<div class="media inline-block margin-none">
										<!--<div class="innerLR border-left">
											<i class="fa fa-bar-chart-o pull-left text-primary fa-2x"></i>
											<div class="media-body">
												<div><a href="" class="strong text-regular">Report</a></div>
												<span>244 KB</span>
											</div> 
											<div class="clearfix"></div>
										</div>-->
									</div>
								</div>
							</div>
							</div>';						                          
						echo $output;
						$j++;
					}
				}
			}else {
				$sorry='	</div>
							<div form class="No result" id="result_not_found" style="text-align: center;" >
							&nbsp;&nbsp;&nbsp;<h1>Sorry, no such record found.</h1>
							</div>';
				echo $sorry;
			}
		}
		if($type == "tag")
		{
			$data = $this->member_record_m->find_records($mem_id,$type,$search);
			//echo $this->db->last_query();
			if(count($data) != '0')
			{
				$j=0;
				foreach ($data as $mem_details)
				{
					if($mem_details['member_id'] == $mem_id && $mem_details['member_id'] != '' && $mem_details['active'] == '1'){
						$output ='	<div style="border:1px solid #CECECE; border-radius: 5px; margin: 0 0 10px;">
						<div class="box-generic padding-none" id="record_delete_'.$mem_details['id'].'">
							
							<a class="share_demo" id="'.$mem_details['id'].'">
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="'.$mem_details['id'].'" class="btn btn-default"><i class="fa fa-share-square-o"></i> Share</button>
								</div>
							</a>
								
								<a id="'.$mem_details['id'].'" class="report_edit_btn">
								<button id="'.$mem_details['id'].'" class="report_edit_btn btn btn-default btn-sm" style="height: 30px; margin-top: 10px; float: right;"><i class="fa fa-fw fa-edit"></i> Edit</button>
								<h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width:450px;">'.$mem_details['title'].'</h5>
								</a>
			
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i>'.$mem_details['date'].'&nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>';
							
						$tagname = explode(",",$mem_details['tagname']);
						$k=0;
						foreach($tagname as $tags):
						$output.= '<span class="label label-primary">'.$tags.'</span>&nbsp;';
						$k++;
						endforeach;
							
						$output.= '</div>
								<div id="shared_with_'.$mem_details['id'].'">';
						if($mem_details['shared_with_name'] != ''){
							$output.= '
								<div id ="shared_names" class="innerAll half border-bottom" style="background-color:#1ba0a2;">
								<i id="'.$mem_details['id'].'" class="fa fa-share-square-o" style="padding-left: 10px; color: white;"> Shared with &nbsp;'.$mem_details['shared_with_name'].'</i>';
						}
						$output.= '</div>
								</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									'.$mem_details['description'].'
									</p>
								</div>
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR" style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>';
						if($mem_details['filename'] != ''){
							$files = explode(",",$mem_details['filename']);
							$i=0;
							foreach($files as $name):
							$type = explode(".",$name);
							if($type[1]=='pdf')
							{
								$output .= '<a data-url="'. base_url().'media_files/'.$name.'" id="'.$name.'" class="pdf_file strong text-regular" rel="media-gallery">'.$name.'</a>,&nbsp;';
								$i++;
							}
							else{
								$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href="'. base_url().'media_files/'.$name.'" rel="media-gallery"> '.$name.'</a>,&nbsp;';
								$i++;
							}
							endforeach;
						}else{
							$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" rel="media-gallery">No Files Found</a>';
						}
						$output .='</div>
												<div id="attachments_'.$mem_details['id'].'" style="display:none;">												
												</div>												
											</div>
											<div class="clearfix"></div>
										</div> 
									</div>
									<div class="media inline-block margin-none">
										<!--<div class="innerLR border-left">
											<i class="fa fa-bar-chart-o pull-left text-primary fa-2x"></i>
											<div class="media-body">
												<div><a href="" class="strong text-regular">Report</a></div>
												<span>244 KB</span>
											</div> 
											<div class="clearfix"></div>
										</div>-->
									</div>
								</div>
							</div>
							</div>';						                          
						echo $output;
						$j++;
					}
				}
			}else {
				$sorry='	</div>
							<div form class="No result" id="result_not_found" style="text-align: center;" >
							&nbsp;&nbsp;&nbsp;<h1>Sorry, no such record found.</h1>
							</div>';
				echo $sorry;
			}
		}
		if($type == "description")
		{
			$data = $this->member_record_m->find_records($mem_id,$type,$search);
			//echo $this->db->last_query();
			if(count($data) != '0')
			{
				$j=0;
				foreach ($data as $mem_details)
				{
					if($mem_details['member_id'] == $mem_id && $mem_details['member_id'] != '' && $mem_details['active'] == '1'){
						$output ='	<div style="border:1px solid #CECECE; border-radius: 5px; margin: 0 0 10px;">
						<div class="box-generic padding-none" id="record_delete_'.$mem_details['id'].'">
							
							<a class="share_demo" id="'.$mem_details['id'].'">
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="'.$mem_details['id'].'" class="btn btn-default"><i class="fa fa-share-square-o"></i> Share</button>
								</div>
							</a>
								
								<a id="'.$mem_details['id'].'" class="report_edit_btn">
								<button id="'.$mem_details['id'].'" class="report_edit_btn btn btn-default btn-sm" style="height: 30px; margin-top: 10px; float: right;"><i class="fa fa-fw fa-edit"></i> Edit</button>
								<h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width:450px;">'.$mem_details['title'].'</h5>
								</a>
			
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i>'.$mem_details['date'].'&nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>';
							
						$tagname = explode(",",$mem_details['tagname']);
						$k=0;
						foreach($tagname as $tags):
						$output.= '<span class="label label-primary">'.$tags.'</span>&nbsp;';
						$k++;
						endforeach;
							
						$output.= '</div>
								<div id="shared_with_'.$mem_details['id'].'">';
						if($mem_details['shared_with_name'] != ''){
							$output.= '
								<div id ="shared_names" class="innerAll half border-bottom" style="background-color:#1ba0a2;">
								<i id="'.$mem_details['id'].'" class="fa fa-share-square-o" style="padding-left: 10px; color: white;"> Shared with &nbsp;'.$mem_details['shared_with_name'].'</i>';
						}
						$output.= '</div>
								</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									'.$mem_details['description'].'
									</p>
								</div>
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR" style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>';
						if($mem_details['filename'] != ''){
							$files = explode(",",$mem_details['filename']);
							$i=0;
							foreach($files as $name):
							$type = explode(".",$name);
							if($type[1]=='pdf')
							{
								$output .= '<a data-url="'. base_url().'media_files/'.$name.'" id="'.$name.'" class="pdf_file strong text-regular" rel="media-gallery">'.$name.'</a>,&nbsp;';
								$i++;
							}
							else{
								$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href="'. base_url().'media_files/'.$name.'" rel="media-gallery"> '.$name.'</a>,&nbsp;';
								$i++;
							}
							endforeach;
						}else{
							$output .= '<a id="'.$mem_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" rel="media-gallery">No Files Found</a>';
						}
						$output .='</div>
												<div id="attachments_'.$mem_details['id'].'" style="display:none;">												
												</div>												
											</div>
											<div class="clearfix"></div>
										</div> 
									</div>
									<div class="media inline-block margin-none">
										<!--<div class="innerLR border-left">
											<i class="fa fa-bar-chart-o pull-left text-primary fa-2x"></i>
											<div class="media-body">
												<div><a href="" class="strong text-regular">Report</a></div>
												<span>244 KB</span>
											</div> 
											<div class="clearfix"></div>
										</div>-->
									</div>
								</div>
							</div>
							</div>';						                          
						echo $output;
						$j++;
					}
				}
			}else {
				$sorry='	</div>
							<div form class="No result" id="result_not_found" style="text-align: center;" >
							&nbsp;&nbsp;&nbsp;<h1>Sorry, no such record found.</h1>
							</div>';
				echo $sorry;
			}
		}
	}
	public function media_files($record)
	{
		$file ='media_files/'.$record;
		// echo error_reporting(E_ALL | E_STRICT);
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// ob_clean();
			flush();
			readfile($file);
			exit;
		} else {
			echo "File Not Found";
		}
	}
}
?>