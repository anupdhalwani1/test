<?php

class Upload extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array(
            'form',
            'url'
            ));
	}

	function index()
	{
		//$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path']   = 'profile_pic';
		$config['allowed_types'] = 'gif|jpg|png';
		//load the upload library
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->set_allowed_types('*');
		$data['upload_data'] = '';

		if (! $this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			echo var_dump($error);
		}
		else
		{
			//if not successful, set the error message
			//$uploaded = $this->upload->up(false);
			//else, set the success message
			//$data = array('msg' => "Upload success!");
			 
			$data['upload_data'] = $this->upload->data();
			var_dump($data['upload_data']);
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
		}
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
}

?>