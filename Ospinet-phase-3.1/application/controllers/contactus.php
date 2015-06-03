<?php
class contactus extends Frontend_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		//$this->load->view('templates/contactus', $this->data);
		$this->data['subview'] ="contactus";
		$this->load->view('_main_layout', $this->data);
	}
	public function sendmail()
	{
		$name=$this->input->post("name");
		$email=$this->input->post("email_val");
		$phone=$this->input->post("phone");
		$requirement=$this->input->post("requirement");

		$to ="gaikwad.amol75@gmail.com";
		$subject = 'Contact Us Form - Ospinet Website';
		 
		$msg = "
               <html>
       <head>
               <title>Ospinet</title>
               </head>
       <body>
               <table width=\"100%\" style=\"border:1px solid #CCCCCC\" cellspacing=\"0\" cellpadding=\"4\" border=\"0\" align=\"center\">
         ";
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;padding-top: 12px;\"><a href='".base_url()."user/dashboard'><img src='".base_url()."assets/images/b_400x100.png' width='200' height='50' /></a></td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"></td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td width=\"80%\" style=\"padding-left: 12px;font-weight:bold;font-size: 16px;color:#222;\">
				    Contact Form</td>
         </tr>
         ";
		$msg.="
         <tr>
                   <td style=\"padding-top: 35px;padding-left: 12px;\" colspan=\"2\"></td>
         </tr>
         ";
		//  $msg .=$msg1;
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Name: ".$name."!</td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Phone: ".$phone."</td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Email: ".$email."</td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Message: ".$requirement ."</td>
         </tr>
         ";
		$msg .="
         <tr>
                   <td 
               style=\"padding-top: 20px;padding-left: 12px;padding-bottom: 20px;border-top:1px solid #CCCCCC;color:#888888;background-color:#F6F6F6\" 
               colspan=\"2\"> Copyright © Ospinet. All rights reserved.
             </td>
                 </tr>
         ";
		$msg .="
       </table>
               </body>
       </html>
               ";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:Ospinet<admin@ospinet.com>'. "\r\n";
		$headers .= 'Bcc:kashelani@gmail.com,gaikwad.amol75@gmail.com' . "\r\n";
		mail($to, $subject, $msg, $headers);
		echo  "Thank You for showing interest in Ospinet.";

	}
}
?>