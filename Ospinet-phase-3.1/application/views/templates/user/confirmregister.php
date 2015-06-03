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

</head>
<body class=" loginWrapper">

	<!-- Main Container Fluid -->
	<div class="container-fluid menu-hidden">
		<!-- Content -->
		<div id="content">
			<div id="menu-top" align="center" style="height: 80px;">
				<a href="<?php echo base_url().'home';?>"> <img
					src="<?php echo base_url().'assets/images/b_400x100.png';?>"
					style="height: 70px; border: 0px;" alt=""> </a>
			</div>
			<div class="layout-app">

				<!-- row-app -->
				<div class="row row-app">
					<div class="col-separator col-unscrollable box">

						<!-- col-table -->
						<div class="col-table">

							<h4
								class="innerAll margin-none border-bottom text-center bg-primary">
								<i class="fa fa-pencil"></i> Confirm Account
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
													<div id="login_msg" class="success_msg"></div>

													<div class="form-group">
														Thank you for registering with Ospinet.com. Please login
														to access your account.</br> <a
															href="<?php echo base_url()?>">
															<button type="submit" style="margin-top: 5px;"
																class="btn btn-primary">Confirm</button> </a>
													</div>



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
		componentsPath = 'assets/components/';
	
	var primaryColor = '#1BA0A2',
		dangerColor = '#b55151',
		successColor = '#609450',
		infoColor = '#4a8bc2',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';
	
	var themerPrimaryColor = primaryColor;
	</script>
</body>
</html>
