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
			 $("#forgotpwdfrm").validate(
			 {
					  validClass:'success',
					  error: function(element) {element.addClass("error");},
					  success: function(element) {
							 var $element = $(element);
							 $element.append('<label class="sign-up-field-succ-icon icon-ok-sign" for="login-name" id="succ"></label>');
						   },	
					 rules: {
					  email: {required: true,email: true,
							   "remote":
			                    {
			                      url: 'check_email_forgotpasswd',
			                      type: "post",
			                      data:
			                      {
			                          username: function()
			                          {
			                              return $("#forgotpwdfrm :input[name='email']").val();
			                          }
			                      }
			                    }  
							},
					  },
					  messages: {
	email: {required:"Please enter a email address",email:"Enter Valid Email Address",remote: jQuery.validator.format("This email address is not registered with ospinet.")},
					  },
					  errorLabelContainer: "#login_msg1",
					  before:function(){$('#ajax-loader').show();},
					  submitHandler: function(form) 
					  {
						   $.post("forgotpassword_mailsent", //post
								   $("#forgotpwdfrm").serialize(),
								   function(data)
								   {
									   
									   $("#forgotpwdfrm").hide();
									   $(".panel-default").removeClass("col-sm-6 col-sm-offset-3").addClass("col-sm-10 col-sm-offset-1");
										$("#login_msg1").show().html(data);
										console.log(data);

								   }
						   )
						   return false;
					  }
			 });
			 });
</script>

</head>
<body class=" loginWrapper">

	<!-- Main Container Fluid -->
	<div class="container-fluid menu-hidden">



		<!-- Content -->
		<div id="content">


			<div id="menu-top" align="center" style="height: 80px;">
				<a href="<?php echo base_url().'home';?>"> <img
					src="<?php echo base_url().'assets/images/b_400x100.png" style="height:70px; border:0px;';?>"
					alt=""> </a>
			</div>


			<div class="layout-app" style="bottom: 100px;">

				<!-- row-app -->
				<div class="row row-app">
					<div class="col-separator col-unscrollable box">

						<!-- col-table -->
						<div class="col-table">

							<h4
								class="innerAll margin-none border-bottom text-center bg-primary">
								<i class="fa fa-pencil"></i>&nbsp;&nbsp;Forgot Password
							</h4>

							<!-- col-table-row -->
							<div class="col-table-row">

								<!-- col-app -->
								<div class="col-app col-unscrollable">

									<!-- col-app -->
									<div class="col-app">

										<div class="login">

											<div class="placeholder text-center">
												<i class="fa fa-pencil"></i>
											</div>

											<div class="panel panel-default col-sm-6 col-sm-offset-3">

												<div class="panel-body">
													<div id="login_msg1" align="center"></div>
													<form id="forgotpwdfrm" action="" role="form" method="post">

														<div class="form-group">
															<label for="exampleInputEmail1">Email address</label> <input
																name="email" type="text" class="form-control" id="email"
																placeholder="Enter email">

														</div>

														<div class="form-group">
															<button type="submit"
																style="width: 100%; margin-bottom: 5px;"
																class="btn btn-primary">Send Password</button>
															<button type="reset"
																style="width: 100%; margin-bottom: 5px;"
																onClick="window.location.href='<?php echo base_url().'home';?>'"
																class="btn btn-primary btn-stroke">Back</button>

														</div>
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
