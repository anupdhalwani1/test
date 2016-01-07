
<!-- Nav Bar -->


<div id="content">

	<div class="page-title">
		<div class="container">
			<h1>Contact</h1>
		</div>
	</div>

	<div class="container">
		<div class="row innerT">
			<div class="col-md-8">
				<p class="innerTB my_font">We would love to hear from you on how we
					can improve ourselves to serve you better..</p>
				<h3 id="successmsg">Send us a message</h3>
				<div class="separator"></div>


				<div class="box-generic bg-gray innerAll inner-2x">
					<form id="contactus">
						<div class="row margin-none">
							<div class="col-sm-8 col-xs-10 padding-none">
								<div class="input-group input-group-lg">
									<span class="input-group-addon"><i class="fa fa-user fa-fw"></i>
									</span> <input type="text" id="name" name="name"
										class="form-control" placeholder="Name" required="required">
								</div>
							</div>
							<div class="col-sm-4 col-xs-2 padding-none">
								<div class="innerAll">
									<!--<i class="fa fa-check-circle text-primary fa-2x"></i>-->
								</div>
							</div>
						</div>
						<div class="separator"></div>
						<div class="row margin-none">
							<div class="col-sm-8 col-xs-10 padding-none">
								<div class="input-group input-group-lg">
									<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i>
									</span> <input type="text" name="email_val" id="email_val"
										class="form-control" placeholder="Email">
								</div>
							</div>
							<div class="col-sm-4 col-xs-2 padding-none">
								<div class="innerAll">
									<!--<i class="fa fa-check-circle  text-primary fa-2x"></i>-->
								</div>
							</div>
						</div>
						<div class="separator"></div>
						<div class="row margin-none">
							<div class="col-sm-8 col-xs-10 padding-none">
								<div class="input-group input-group-lg">
									<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i>
									</span> <input type="text" name="phone" id="phone"
										class="form-control" placeholder="Phone Number" required>
								</div>
							</div>
							<div class="col-sm-4 col-xs-2 padding-none">
								<div class="innerAll">
									<!--<i class="fa fa-refresh fa-2x"></i>-->
								</div>
							</div>
						</div>
						<div class="innerTB">
							<textarea class="form-control" name="requirement"
								id="requirement" rows="3" placeholder="Type in your message..."
								required></textarea>
						</div>
						<button class="btn btn-primary btn-lg" type="submit"
							id="send_message">
							Send Message <i class="fa fa-chevron-right fa-fw"></i>
						</button>
				
				</div>
			</div>
			</form>
			<div class="col-md-4 sidebar">
				<div class="panel panel-primary innerT" style="border: none;">
					<div class="panel-heading strong"
						style="background-color: #1abc9c;">
						<i class="fa fa-building fa-3x pull-left"></i> OSPINET <br /> <small>Pune,
							Maharashtra</small>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title strong">More Information</h3>
					</div>
					<ul class="compny_info panel-body">
						<li><i class="fa fa-question-circle pull-left fa-2x"></i> <span>FAQs</span>
							</br> <a href="<?php echo base_url().'faqs';?>">Support Forums</a>
						</li>
						<!--           	<li>
		                	<i class="fa fa-clock-o pull-left fa-2x"></i>
			                <span>mosaicpro</span></br>
			                <a href="">09 AM - 05 PM </a> <small>(GMT+2)</small>
			            </li>  -->
						<li><i class="fa fa-envelope pull-left fa-2x"></i> <span>Email us</span></br>
							<a href="">contact.us@ospinet.com</a>
						</li>
					</ul>
				</div>
				<div class="well well-info">
					<div class="fa fa-facebook-square fa-background"></div>
					<h3>
						<i class="fa fa-facebook-square"></i> Get social with Ospinet
					</h3>
					<ul class="innerAll">
						<li>Easy record storage</li>
						<li>Easy record management</li>
						<li>Reliable and Secure</li>
						<li>Free Of Cost</li>
						<li>Wait no more...</li>
					</ul>
					<div class="text-center innerT">
						<a class="btn btn-default btn-lg strong"
							href="https://www.facebook.com/ospinet" target="_blank">Like us
							on facebook <i class="fa fa-thumbs-up myfont"></i> </a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(e) {
    $.validator.addMethod('integer', function(value, element, param) {
			return (value != 0) && (value == parseInt(value, 10));
		}, 'Please enter only numbers');
$("#contactus").validate({
			rules:{
				name:{required:true},
				email_val:{required:true,email:true},
				phone:{required:true,integer : true,maxlength : 10},
				requirement:{required:true}
			},
		messages: {
	   name: {required:"Please enter name"},
	   email_val: {required:"Please enter email",email:"Please enter valid email address" },
	   phone:{required:"please enter contact"},
	   requirement:{required:"Please enter your message"}
	   
		},
		submitHandler: function(form) {
  //submit the form				
                             $("#refresh_icon").show();
							
  								$.post("<?php echo base_url()?>contactus/sendmail",$("#contactus").serialize(),
										function (data)
										{ 
										   console.log(data);
										   $("#successmsg").html(data);
										   $("#email_val").val("");
										   $("#name").val("");
										   $("#phone").val("");
										   $("#requirement").val("");
										});
  
								}
			
});
 /* $("#send_message").click(function(e) {
   

  $.ajax({//4
							url: "<?php echo base_url().'contactus/sendmail';?>",
							type: 'POST',
							async : false,
							data: {"email":$("#email_val").val(),"name":$("#name").val(),"phone":$("#phone").val(),"requirement":$("#requirement").val()},
							success: function(msg)
											{//
											console.log(msg);
											   $("#successmsg").html(msg);
											}//5end
											
										
							});//ajax open bracket end*/
							 /*return false;*/
						 /*	});*/
							});
  </script>
