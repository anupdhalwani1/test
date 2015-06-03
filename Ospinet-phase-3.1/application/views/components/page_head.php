<!DOCTYPE html>

<head>
<title>Ospinet</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet"
	href="<?php echo base_url().'assets/css/front/module.front.page.index.sidebar_type.fusion.min.css';?>" />
<link rel="stylesheet"
	href="<?php echo base_url().'assets/components/library/icons/fontawesome/assets/css/font-awesome.min.css';?>" />
<script
	src="<?php echo base_url().'assets/components/library/jquery/jquery.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/js/jquery.validate.min.js';?>"></script>
<script src="<?php echo base_url().'assets/js/jquery.validate.js';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/modals/assets/js/bootbox.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/modals/assets/js/modals.init.js?v=v1.9.5';?>"></script>


</head>
<body>

	<div class="navbar navbar-coral navbar-fixed-top">
		<!-- Nav Bar Header -->
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle " data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="icon-bar "></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url('member');?>">
					<div id="logo_image"></div> </a>
			</div>
			<!-- Nav Bar Collapse -->
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav main-menu">
					<input type="hidden" id="url_seg"
						value="<?php echo $this->uri->segment(1);?>">
					<li class="home"><a href="<?php echo base_url('member');?>">Home</a>
					</li>
					<li class="blog"><a href="http://ospinet.com/blog/">Blog</a></li>
					<!-- <li><a href="http://ospinet.com/reviews/">Reviews</a></li>-->
					<li class="faqs"><a href="<?php echo base_url('faqs');?>">FAQs</a>
					</li>

					<li class="contact"><a href="<?php echo base_url('contactus');?>">Contact</a>
					</li>
				</ul>
			</div>
			<!-- NavBar Collapse -->
			<!-- Nav Bar Right -->
			<ul class="nav navbar-nav navbar-right right-side">
				<!-- User LogIn Button -->
				<li>
					<div class="btn-group">
						<a href="#login-menu" class="btn btn-login menu_login"
							data-toggle="collapse"> Login</a>
							<?php if($this->uri->segment(1)=="register"){ ?>
						<div class="in login" id="login-menu">
						<?php } else { ?>
							<div class="collapse login" id="login-menu">
							<?php } ?>
								<form id="loginfrm"
									action="<?php echo base_url().'register/login';?>"
									method="post">
									<div>
										<div class="input-group input-group-sm">
											<input type="text" id="email" name="email"
												class="form-control" placeholder="Email"> <span
												class="input-group-addon"><i></i> </span>
										</div>
										<div class="input-group input-group-sm">
											<input type="password" id="passwd" name="passwd"
												class="form-control" placeholder="Password"> <span
												class="input-group-addon"><i></i> </span>
										</div>
									</div>
									<div class="pull-right">
										<i class="fa fa-refresh fa-spin" id="refresh_icon"></i>
										<button id="login" type="submit" class="btn btn-login">Login</button>
									</div>
									<div class="center">
										<a href="<?php echo base_url().'register/forgotpassword';?>"
											class="recover-password">Recover Password <i
											class="fa fa-lock"></i> </a>
									</div>
								</form>
								<?php if($this->uri->segment(1)=="register"){ ?>
								<div class="welcome" style="color: #1BA0A2">Thank you for
									registration with Ospinet. Please login with your credentials</div>
									<?php } ?>
								<div id="error" align="center"></div>
								<div id="error1" align="center"></div>
							</div>
							<a href="<?php echo base_url().'register';?>"
								class="btn btn-signup glyphicons user_add"><i></i>Sign up</a>
						</div>
				
				</li>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
function resend_email(email)
{
	$.ajax({//4
			url: "register/resend_email",
			type: 'POST',
			async : false,
			data: {"email":email},
			success: function(msg)
							{//
								$("#error1").addClass("error").html(msg);
								return false;
							}//5end
			});//ajax open bracket end
}
    $(document).ready(function(e) {
		
		$("#refresh_icon").hide();
		//$(".input-group-addon").hide();
		$("#loginfrm").validate({
			rules:{
				email:{required:true,email: true},
				passwd:{required:true}
			},
		messages: {
	   email: {required:"Please enter email address",email:"Please enter valid email address"},
	   passwd: {required:"Please enter passwd"}
		},
		 errorLabelContainer: "#error",
		  submitHandler: function(form) {
  //submit the form				
                             $("#refresh_icon").show();
							
  								$.post("<?php echo base_url()?>register/login",$("#loginfrm").serialize(),
										function (data)
										{ 
										   console.log(data);
											//if message is sent
											var msg="";
											if(data=="1")
											{
											$("#email").val("").next().children().removeClass("fa-check fa");
											$("#passwd").val("").next().children().removeClass("fa-check fa fa fa-times");
											  msg="Please enter a registered email address.";
											  $("#refresh_icon").hide(2000);
											}
											else if(data=="2")
											{
												//$("#error1").css("display","none");
												 refreshpage();
												 $("#refresh_icon").hide(2000);
											}
											else if(data=="3")
											{
												$("#email").val("").next().children().removeClass("fa-check fa");
												$("#passwd").val("").next().children().removeClass("fa-check fa fa-times");
												
												msg="Incorrect username or Password. Please click recover password link to regenerate password.";
												$("#refresh_icon").hide(2000);
												 $("#email").next().children().removeClass("fa fa-check fa fa-times");
											}
											else if(data=="4")
											{
												$("#email").next().children().removeClass("fa fa-check");
												$("#passwd").next().children().removeClass("fa fa-check");
												linkfun='javascript:resend_email('+"'"+$("#email").val()+"'"+')';
												msg="Please confirm your registration by clicking on the link in a mail we've just sent.<br>";
												msg+='<a href="javascript:void(0);" onclick="'+linkfun+'" class="recover-password" id="hyp_resendemail"  >Click here if you have not recieved an email from Ospinet.</a>';
												$("#email").val("");
												$("#passwd").val("");
												$("#refresh_icon").hide(2000);
											}
											else if(data=="5")
											{
												var strsha1 = $().crypt({
														method: "sha1",
														source: $("#email").val()
													});
												window.location.href="register/resetpassword/"+strsha1+"/msg/1";
												$("#refresh_icon").hide(2000);
											}
											$("#error1").html("<label class='error1'>"+msg+"</label>");
										}
								);
  
								}
			
		});
		function refreshpage()
				{
					var first_member ='';
					$.ajax({//4
							url: "<?php echo base_url().'register/login_redirect';?>",
							type: 'POST',
							async : false,
							data: {"email":$("#email").val()},
							success: function(msg)
											{//
											console.log(msg);
											   first_member = msg;
												return false;	
											}//5end
										
							});//ajax open bracket end*/
					window.location.href="<?php echo base_url();?>member#memberid/"+first_member;
				}
		//$(".input-group-addon").hide();

		$("#email").blur(function(e) {
            var x=$(this).val();
			var atpos=x.indexOf("@");
			var dotpos=x.lastIndexOf(".");
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
			  {
			     $(this).next().children().addClass("fa fa-times");
			  }
			  else
			  {
				  $(this).next().children().removeClass("fa fa-times");
				  $(this).next().children().addClass("fa fa-check");
			  }
        });
		$("#passwd").blur(function(e) {
           
			if ($(this).val().length < 8)
			  {
			      $(this).next().children().addClass("fa fa-times");
			  }
			  else
			  {
				  $(this).next().children().removeClass("fa fa-times");
				  $(this).next().children().addClass("fa fa-check");
			  }
        });
		$(".menu_login").click(function(e) {
            $(".error").html("");
			$(".error1").html("");
			$("#email").val("");
			$("#passwd").val("");
        });
    });
	
if($("#url_seg").val()=="faqs")
{
	$(".faqs").addClass("active");
}
if($("#url_seg").val()=="contactus")
{
	$(".contact").addClass("active");
}
if($("#url_seg").val()=="" || $("#url_seg").val()=="home")
{
	$(".home").addClass("active");
}
</script>
	<style>
.error {
	color: #EB6A5A;;
	font-weight: normal !important;
}

.error1 {
	color: #EB6A5A;;
	font-weight: normal !important;
}
</style>