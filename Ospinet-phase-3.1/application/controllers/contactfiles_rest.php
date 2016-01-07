<?php
error_reporting(E_ALL | E_STRICT);
require(APPPATH . 'libraries/REST_Controller.php');
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Contactfiles_rest extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("files_m");
		$this->load->model("register_m");
		$this->load->library('session');
	}
	public function index_post()
	{
		// Get files details of contacts
		$file_id = $this->input->post('file_id');
		$file_name = $this->input->post('file_name');
		$contact_id = $this->input->post('contact_id');
		
		$owner_name = $this->files_m->get_contact_name($contact_id);
		
		$msg = '<div id="details" class="innerAll">
						<div class="media">			        						
						<img src="'.base_url().'assets/images/file_image/file.png" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
           
                        <div class="media-body innerAll half">
                        <h4 class="media-heading text-large">'.$file_name.'</a></a></h4>
						File Owner : ('.$owner_name[0]['name'].')
 						</div>
						</div>			
                        </div> 
						<!-- /* values for date of birth*/-->
                        <div class="col-separator-h box"></div>

		<h4 class="innerAll margin-none bg-white">File Records</h4>';
		
		if(count($file_id) != '0'){
			$rec_id = $this->files_m->get_files_records($file_id);	
			foreach ($rec_id as $id):
			$record_id = implode(":",$id);
			$rec_details1 = $this->files_m->get_records($record_id);
			foreach($rec_details1 as $rec_details):
			 $msg.= '<div class="box-generic padding-none" id="'.$rec_details['id'].'" style="border:1px solid #CECECE">
						<a id='.$rec_details["id"].' class="report_edit_btn"><h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width: 570px;">'.$rec_details["title"].'
								</h5>
								</a>
								
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">';
									if($rec_details["date"] != "") {
						$msg.=  '<i class="fa fa-calendar fa-fw text-primary"></i> '.$rec_details["date"].' &nbsp;';
									 }
						$msg.=	'<i class="fa fa-tag fa-fw text-primary"></i>';
 									if($rec_details["tagname"] !="") {
 									$tagname = explode(",",$rec_details["tagname"]);
									$k=0;
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
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR"  style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>'; 
							if($rec_details['filename'] != ''){
							$files = explode(",",$rec_details['filename']);
							$i=0;
							foreach($files as $name):
							$type = explode(".",$name);
							if($type[1]=='pdf')
							{
								$msg .= '<a data-url="'. base_url().'media_files/'.$name.'" id="'.$name.'" class="pdf_file strong text-regular" rel="media-gallery">'.$name.'</a>,&nbsp;';
								$i++;
							}
							else{
								$msg .= '<a id="'.$rec_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href="'. base_url().'media_files/'.$name.'" rel="media-gallery"> '.$name.'</a>,&nbsp;';
								$i++;
							}
							endforeach;
						}else{
							$msg .= '<a id="'.$rec_details['id'].'" class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" rel="media-gallery">No Files Found</a>';
						}
						$msg.='</div>
												<div id="attachments_'.$rec_details['id'].'" style="display:none;">												
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
			endforeach;
		endforeach;	
		echo $msg;
		}
	}
}