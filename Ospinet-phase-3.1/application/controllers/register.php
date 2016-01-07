<?php
class register extends Frontend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("member_m");
	}

	public function index()
	{
		//$this->data['subview'] ="user/register";
		$this->load->view('templates/user/register', $this->data);
	}
	public function login()
	{
		$msg = "";
		// Redirect a user if he's already logged in
		$this->register_m->loggedin() == FALSE || redirect('member');
		$msg = $this->register_m->login($this->input->post('email'), $this->input->post('passwd'), 'Website');

		echo $msg;
	}
	public function check_logout()
	{
		if ($this->register_m->loggedin())
		echo "yes";
		else
		echo "not";
	}
	public function check_user_log()
	{
		$email = $this->input->post("email");
		$data  = $this->member_m->user_first_login($email);
		echo count($data);
	}
	public function logout()
	{
		$this->register_m->logout();
		redirect(base_url());
	}

	public function resend_email()
	{
		$msg          = "";
		$fname        = "";
		$lname        = "";
		$email        = $this->input->post("email");
		$mmbr_details = $this->register_m->resend_mail_details($email);
		foreach ($mmbr_details as $details):
		$fname = $details['fname'];
		$lname = $details['lname'];
		endforeach;
		$to      = $this->input->post("email");
		$subject = 'Account Activation';

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
                   <td colspan=\"2\" style=\"padding-left: 12px;padding-top: 12px;\"><a href='" . base_url() . "user/dashboard'><img src='" . base_url() . "assets/images/b_400x100.png' width='200' height='50' /></a></td>
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
				    Account Activation</td>
         </tr>
         ";
		$msg .= "
         <tr>
                   <td style=\"padding-top: 35px;padding-left: 12px;\" colspan=\"2\"></td>
         </tr>
         ";
		//  $msg .=$msg1;
		$msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Welcome to Ospinet, " . $fname . " " . $lname . "!</td>
         </tr>
         ";
		$msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"><a href = ". base_url() ." 'register/confirmregistration/" . hash("sha1", $email) . "' >Please click here to activate your account.</a></td>
         </tr>
         ";
		$msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"></td>
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
               colspan=\"2\"> Copyright © Ospinet. All rights reserved.
             </td>
                 </tr>
         ";
		$msg .= "
       </table>
               </body>
       </html>
               ";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:Ospinet<admin@ospinet.com>' . "\r\n";
		$headers .= 'Bcc:kashelani@gmail.com' . "\r\n";
		mail($to, $subject, $msg, $headers);
		echo "A new email has been sent to the " . $to . " address.Please check your junk folder in case you do not receive the email.";
	}
	public function forgotpassword()
	{
		//$this->data['subview'] ="user/forgotpassword";
		$this->load->view('templates/user/forgotpassword', $this->data);
	}
	public function resetpassword()
	{

		$user = $this->register_m->get_by(array(
            'sha1(email)' => $this->uri->segment(3)
		), TRUE);
		if ($this->uri->segment(4) == "msg") {
			$this->data["pwdchange"] = "Please reset your password";
		}
		if (count($user)) {
			$this->data["email"] = $user->email;
			//$this->data['subview'] ="user/resetpassword";
		} else {
			$this->data["msg"] = "Email Id Is Wrong";
			//$this->data['subview'] ="error";
		}
		$this->load->view('templates/user/resetpassword', $this->data);
	}
	public function update_password()
	{
		$msg  = "";
		$user = $this->register_m->get_by(array(
            'email' => $this->input->post('email'),
            'passwd' => $this->register_m->hash($this->input->post('oldpwd'))
		), TRUE);
		if (count($user)) {
			$this->register_m->save(array(
                "login_status" => 'confirm',
                "passwd" => $this->register_m->hash($this->input->post('newpwd'))
			), $user->id);
			echo 'The password has beeen successfully changed </br></br>
		  <a href="' . base_url() . '"> 
		                            <button type="reset" style="width:100%; margin-bottom:5px;" class="btn btn-primary btn-stroke">Back</button>
		  </a>
		  ';
		} else {
			$linkfun = $this->input->post('email');
			$msg     = 'Current password is incorrect.</br></br> <a href="' . base_url("register/forgotpassword") . '">
		  <button type="reset" style="width:100%; margin-bottom:5px;" class="btn btn-primary btn-stroke">Back</button>
		  </a>';
		}
		echo $msg;
	}
	public function forgotpassword_mailsent()
	{
		$user    = $this->register_m->get_by(array(
            'email' => $this->input->post('email')
		), TRUE);
		$new_pwd = $this->generatePassword(8);
		$this->register_m->save(array(
            "login_status" => 'passwordnotset',
            "passwd" => $this->register_m->hash($new_pwd)
		), $user->id);
		//Send Mail to Corsponding Email
		echo 'An email has been sent to your email address. </br> Please check your email account to reset password.</br></br>
	  <a href="' . base_url() . 'home' . '"> <button type="reset" style="width:100%; margin-bottom:5px;" class="btn btn-primary btn-stroke">Back</button> </a>
	  ';
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
                   <td style=\"padding-top: 35px;padding-left: 12px;\" colspan=\"2\">Your current password is: " . $new_pwd . "</td>
                 </tr>
         ";
		//       $msg .= $msg1;
		$msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"><a href= '".base_url()."register/resetpassword/" . hash("sha1", $user->email) . "'> Please click here to change your password.</a></td>
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
		$array      = array(
		//           $data["fname"],
		//           $data["lname"],
		//          $data["email"]
		);
		$serialized = rawurlencode(serialize($array));
		// echo  "Welcome ".$data["fname"].", ".$data["lname"]."! Please click on the link that has been mailed to ".$data["email"]." to complete registration.";
		//  echo $serialized;
	}

	public function confirmregistration()
	{
		$data = array(
            "login_status" => "confirm"
            );
            $this->db->where("sha1(email)", $this->uri->segment(3));
            $this->db->update("os-pii-user", $data);
            $this->db->where("sha1(email)", $this->uri->segment(3));
            $row                     = $this->db->get("os-pii-user")->row();
            $data_ul["userid"]       = $row->id;
            $data_ul["email"]        = $row->email;
            $now                     = date("Y-m-d H:i:s");
            $data_ul["log_datetime"] = $now;
            $data_ul["user_status"]  = "reg_confirm";
            $this->register_m->save($data_ul, NULL, "os-pii-user-log");
            $this->data['subview'] = "user/home";
            $this->load->view('_main_layout', $this->data);
	}

	public function add_edit_register()
	{
		$id                      = NULL;
		$data                    = $this->register_m->array_from_post(array(
            'fname',
            'lname',
            'email',
            'passwd',
            'usertype',
            'login_status'
            ));
            $data['passwd']          = $this->register_m->hash($data['passwd']);
            $data["roleid"]          = "2";
            $data["parentid"]        = "2";
            $data["first_member_id"] = "0";

            /****************Send a Mail To mail id****************************************************/
            // create the instance
            $str_error               = "";
            // call the validation proce
            $user_id                 = $this->register_m->save($data, $id);
            $data_ul["userid"]       = $user_id;
            $data_ul["email"]        = $data['email'];
            $now                     = date("Y-m-d H:i:s");
            $data_ul["log_datetime"] = $now;
            $data_ul["user_status"]  = "register_mailsent";
            $this->register_m->save($data_ul, $id, "os-pii-user-log");
            //adding first member
            $data1["fname"]      = $data["fname"];
            $data1["lname"]      = $data["lname"];
            $data1["email"]      = $data["email"];
            $data1["gender"]     = "";
            $data1["birth_info"] = "";
            $data1['age']        = "";
            $data1["userid"]     = $user_id;
            $fm                  = $this->member_m->save($data1, $id, "os-pii-member");
            $dat                 = array(
            'first_member_id' => $fm
            );

            $this->db->where('id', $user_id);
            $this->db->update('os-pii-user', $dat);
            //Send Mail to Corsponding Email
            //new mail
            $msg     = "";
            $to      = $data["email"];
            $subject = 'Ospinet - Account Activation';
            $msg     = "
               <html>
       <head>
               <title>Ospinet</title>
               </head>
       <body>
               <table width=\"100%\" style=\"border:1px solid #CCCCCC\" cellspacing=\"0\" cellpadding=\"4\" border=\"0\" align=\"center\">
         ";
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;padding-top: 12px;\"><a href='" . base_url() . "user/dashboard'><img src='" . base_url() . "assets/images/b_400x100.png' width='200' height='50' /></a></td>
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
				    Account Activation</td>
         </tr>
         ";
            $msg .= "
         <tr>
                   <td style=\"padding-top: 35px;padding-left: 12px;\" colspan=\"2\"></td>
         </tr>
         ";
            //  $msg .=$msg1;
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\">Welcome to Ospinet, " . $data["fname"] . " " . $data["lname"] . "!</td>
         </tr>
         ";
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"><a href = '".base_url()."register/confirmregistration/" . hash("sha1", $data["email"]) . "' >Please click here to activate your account.</a></td>
         </tr>
         ";
            $msg .= "
         <tr>
                   <td colspan=\"2\" style=\"padding-left: 12px;\"></td>
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
            $array      = array(
            $data["fname"],
            $data["lname"],
            $data["email"]
            );
            $serialized = rawurlencode(serialize($array));
            // echo  "Welcome ".$data["fname"].", ".$data["lname"]."! Please click on the link that has been mailed to ".$data["email"]." to complete registration.";
            echo 'Please confirm your registration by clicking on the link sent to your registered email id.</br></br>
	  <a href="' . base_url() . '"> <button type="reset" style="margin-top:5px;" class="btn btn-primary btn-stroke">Back</button> </a>';

	}
	function generatePassword($length = 8)
	{

		// start with a blank password
		$password  = "";
		// define possible characters - any character in this string can be
		// picked for use in the password, so if you want to put vowels back in
		// or add special characters such as exclamation marks, this is where
		// you should do it
		$possible  = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		// we refer to the length of $possible a few times, so let's grab it now
		$maxlength = strlen($possible);
		// check for length overflow and truncate if necessary
		if ($length > $maxlength) {
			$length = $maxlength;
		}
		// set up a counter for how many characters are in the password so far
		$i = 0;
		// add random characters to $password until $length is reached
		while ($i < $length) {
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, $maxlength - 1), 1);
			// have we already used this character in $password?
			if (!strstr($password, $char)) {
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i++;
			}
		}
		// done!
		return $password;
	}
	function check_email()
	{
		$username = $this->input->post('username');
		$this->db->select("id");
		$this->db->where("email", $username);
		$sql = $this->db->get("os-pii-user")->result_array();
		//  $this->input->post('username');
		if (count($sql) == 0) {
			echo "true"; //good to use
		} else {
			echo "false"; //already registered
		}
	}
	function check_email_forgotpasswd()
	{
		$email = $this->input->post('email');
		$this->db->select("id");
		$this->db->where("email", $email);
		$sql = $this->db->get("os-pii-user")->result_array();
		//  $this->input->post('username');
		if (count($sql) == 0) {
			echo "false"; //good to use
		} else {
			echo "true"; //already registered
		}
	}
	public function login_redirect()
	{

		$email        = $this->input->post('email');
		$first_member = $this->register_m->get_first_member($email);
		foreach ($first_member as $fm):
		echo $fm['first_member_id'];
		endforeach;
	}
}
?>