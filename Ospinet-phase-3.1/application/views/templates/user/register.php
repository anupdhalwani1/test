<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 app"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 app"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 app"> <![endif]-->
<!--[if gt IE 8]> <html class="ie app"> <![endif]-->
<!--[if !IE]><!-->
<html class="app">
<!-- <![endif]-->
<head>
<title>Ospinet</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

<link rel="stylesheet"
	href="<?php echo base_url().'assets/css/admin/module.admin.page.signup.sidebar_type.discover.min.css';?>" />

<script
	src="<?php echo base_url().'assets/components/library/jquery/jquery.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/library/modernizr/modernizr.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.9.5';?>"></script>
<script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/validator/assets/lib/jquery-validation/dist/jquery.validate.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/validator/assets/custom/form-validator.init.js?v=v1.9.5';?>"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
		
	 $.validator.addMethod("lettersonly", function(value, element) {
		  return this.optional(element) || /^[a-z]+$/i.test(value);
	  }, "Letters only please");

	  $.validator.addMethod("pwdreg", function(value, element) {
	  return this.optional(element) || /^[a-z0-9]+$/i.test(value);
	  }, "Password must contain only letters, numbers.");
	
	  $.validator.addMethod('passwordnumber', function(value, element) {
	  return this.optional(element) || (value.match(/[0-9]/));
	  },'Password must contain at least one number.');
	
	  $.validator.addMethod('passwordletter', function(value, element) {
	  return this.optional(element) || (value.match(/[a-zA-Z]/) );
	  }, 'Password must contain at least one alphabet.');

	  //form validation rules
	  $("#signup").validate({
	  validClass:'success',
	  rules: {
	  fname: {required:true, lettersonly:true},
	  lname: {required:true, lettersonly:true},
	  usertype: {required: true},
	  email: {required: true,email:true,
	           "remote":
                    {
                      url: 'register/check_email',
                      type: "post",
                      data:
                      {
                          username: function()
                          {
                              return $("#signup :input[name='email']").val();
                          }
                      }
                    }
	  },
	  reemail: {required: true,email: true,equalTo:"#email" },
	  passwd:{required: true,minlength: 8,pwdreg:true,passwordnumber:true,passwordletter:true},
	  repasswd: {required: true,equalTo:"#passwd" }
	  },
	  
	  messages: {
	  fname: {required:"Please enter first name",lettersonly:"Enter only alphabates"},
	  lname: {required:"Please enter last name",lettersonly:"Enter only alphabates"},
	  email: {required:"Please enter a email address",email:"Enter Valid Email Address",remote: jQuery.validator.format("This email address is already taken.")},
	  reemail: {required:"Please enter a re-email address",email:"Email Address does not match",equalTo:"Please match the Email address"},
	  usertype: {required:"Please select any one"},
	  passwd:{required:"Please enter a password",minlength: "Password length must be at least 8 characters",pwdreg:"Password must contain only letters,number" },
	  repasswd: {required:"Please enter a re-password",equalTo:"Password does not match"}
	  },
	 success: function(element) {
		 var $element = $(element);
		 $element.append('');
	   }	,
	  submitHandler: function(form) {
			  //submit the form
			  $.post("register/add_edit_register", //post
				  $("#signup").serialize(),
				  function(data){
				  console.log($("#signup").serialize());
				  //if message is sent
				  $("#reg_msg").css("display","block");
				   //window.location.href="<?php echo base_url();?>/home/msg/registerdone";
					    $("#signup").hide();
						$(".panel-default").removeClass("col-sm-6 col-sm-offset-3").addClass("col-sm-10 col-sm-offset-1");
						$(".success_msg").html(data);
						$(".change_icon").removeClass("fa fa-pencil").addClass("fa fa-check");
						$("#register_heading").html('<i class="change_icon fa fa-check"></i> Registration Successful');
 			 });
  	return false; //don't let the page refresh on submit.
  }
  });
    
}); 	
</script>
</head>
<body class="loginWrapper">

	<!-- Main Container Fluid -->
	<div class="container-fluid menu-hidden">
		<!-- Content -->
		<div id="content">
			<div id="menu-top" align="center" style="height: 80px;">
				<a href="<?php echo base_url().'';?>"> <img
					src="assets/images/b_400x100.png"
					style="height: 70px; border: 0px;" alt=""> </a>
			</div>
			<div class="layout-app">

				<!-- row-app -->
				<div class="row row-app">
					<div class="col-separator col-unscrollable box">

						<!-- col-table -->
						<div class="col-table">

							<h4
								class="innerAll margin-none border-bottom text-center bg-primary"
								id="register_heading">
								<i class="fa fa-pencil"></i> Create a new Account
							</h4>

							<!-- col-table-row -->
							<div class="col-table-row">

								<!-- col-app -->
								<div class="col-app col-unscrollable">

									<!-- col-app -->
									<div class="col-app" id="col-app" style="overflow: auto;">

										<div class="login">

											<div class="placeholder text-center">
												<i class="fa fa-pencil change_icon"></i>
											</div>

											<div class="panel panel-default col-sm-6 col-sm-offset-3">

												<div class="panel-body">
													<div class="success_msg" align="center"></div>
													<form
														action="<?php echo base_url().'register/add_edit_register'; ?>"
														id="signup" role="form" method="post">
														<div class="form-group">
															<label for="radio">I am an</label></br> <input
																type="radio" name="usertype" value="Individual">&nbsp;&nbsp;Individual
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input
																type="radio" name="usertype" value="Doctor">&nbsp;&nbsp;Doctor
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">First Name</label> <input
																type="text" name="fname" class="form-control" id="fname"
																placeholder="Your first name">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">Last Name</label> <input
																type="text" name="lname" class="form-control" id="lname"
																placeholder="Your last name">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">Email address</label> <input
																name="email" type="text" class="form-control" id="email"
																placeholder="Enter email">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">Verify email address</label>
															<input type="text" name="reemail" class="form-control"
																id="reemail" placeholder="Verify email">
														</div>
														<div class="form-group">
															<label for="exampleInputPassword1">Password</label> <input
																type="password" name="passwd" class="form-control"
																id="passwd" placeholder="Password">
														</div>
														<div class="form-group">
															<label for="exampleInputPassword1">Confirm Password</label>
															<input type="password" name="repasswd"
																class="form-control" id="repasswd"
																placeholder="Retype Password">
														</div>
														<input type="hidden" id="login_status" name="login_status"
															value="mailsent">
														<button type="submit"
															style="width: 100%; margin-bottom: 5px;"
															class="btn btn-primary">Create Account</button>
														<button type="reset"
															style="width: 100%; margin-bottom: 5px;"
															onClick="window.location.href='<?php echo base_url().'home';?>'"
															class="btn btn-primary btn-stroke">Back</button>
													</form>
												</div>
												<div class="clearfix"></div>
											</div>

										</div>
										<!-- // END col-app -->

									</div>
									<!-- // END col-app.col-unscrollable -->

								</div>
								<!-- // END col-table-row -->

							</div>
							<!-- // END col-table -->

						</div>
						<!-- // END col-separator.box -->


					</div>
				</div>
				<!-- // END row-app -->


			</div>
		</div>
		<!-- Global -->
	</div>
	<style>
.error {
	font-weight: normal;
	margin-bottom: 0px;
}
</style>
	<script>
	
	var basePath = '',
		commonPath = '../assets/',
		rootPath = '../',
		DEV = false,
		componentsPath = '../assets/components/';
	
	var primaryColor = '#1BA0A2',
		dangerColor = '#b55151',
		successColor = '#609450',
		infoColor = '#4a8bc2',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';
	
	var themerPrimaryColor = primaryColor;
	</script>

	<script
		src="<?php echo base_url().'assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.9.5';?>"></script>
	<script
		src="<?php echo base_url().'assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.9.5';?>"></script>
	<script
		src="<?php echo base_url().'assets/components/plugins/breakpoints/breakpoints.js?v=v1.9.5';?>"></script>
	<script
		src="<?php echo base_url().'assets/components/core/js/core.init.js?v=v1.9.5';?>"></script>
	<script
		src="<?php echo base_url().'assets/components/core/js/animations.init.js?v=v1.9.5';?>"></script>

</body>
</html>
