<div class="row" id="reg_msg" style="display: none">
	<div class="span6" id="welcome_msg"></div>
</div>
<div class="container-fluid">
	<div class="row-fluid" align="center">
		<div class="span6" style="float: none;">
			<div class="sign-up-form" align="center">
				<form id="signup" method="POST">
					<input type="hidden" id="login_status" name="login_status"
						value="mailsent">
					<legend>Sign Up</legend>
					<div class="control-group">
						<input type="text" class="sign-up-field" id="fname" name="fname"
							placeholder="First Name"> <label
							class="sign-up-field-icon icon-user" for="login-name"></label>
					</div>

					<div class="control-group">
						<input type="text" class="sign-up-field" id="lname" name="lname"
							placeholder="Last Name"> <label
							class="sign-up-field-icon icon-user" for="login-name"></label>
					</div>
					<div class="control-group">
						<input type="text" class="sign-up-field" id="email" name="email"
							placeholder="Email"> <label
							class="sign-up-field-icon icon-envelope" for="login-name"></label>
					</div>
					<div class="control-group">
						<input type="text" class="sign-up-field" id="reemail"
							name="reemail" placeholder="Re-enter Email"> <label
							class="sign-up-field-icon icon-envelope" for="login-name"></label>
					</div>
					<div class="control-group">
						<input type="Password" id="passwd" class="sign-up-field"
							name="passwd" placeholder="Password"> <label
							class="sign-up-field-icon icon-lock" for="login-name"></label>
					</div>
					<div class="control-group">
						<input type="Password" id="repasswd" class="sign-up-field"
							name="repasswd" placeholder="Re-enter Password"> <label
							class="sign-up-field-icon icon-lock" for="login-name"></label>
					</div>
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls">
							<button type="submit" class="btn btn-primary btn-large btn-block">Sign
								Up</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

		  vali.validator.addMethod("lettersonly", function(value, element) {
		  return this.optional(element) || /^[a-z]+$/i.test(value);
	  }, "Letters only please");

	  vali.validator.addMethod("pwdreg", function(value, element) {
	  return this.optional(element) || /^[a-z0-9]+$/i.test(value);
	  }, "Password must contain only letters, numbers.");
	
	  vali.validator.addMethod('passwordnumber', function(value, element) {
	  return this.optional(element) || (value.match(/[0-9]/));
	  },
	  'Password must contain at least one number.');
	
	  vali.validator.addMethod('passwordletter', function(value, element) {
	  return this.optional(element) || (value.match(/[a-zA-Z]/) );
	  },
	  'Password must contain at least one alphabet.');

	  //form validation rules
	  vali("#signup").validate({
	  validClass:'success',
	  rules: {
	  fname: {required:true, lettersonly:true},
	  lname: {required:true, lettersonly:true},
	  email: {required: true,email: true },
	  reemail: {required: true,email: true,equalTo:"#email" },
	  passwd:{required: true,minlength: 8,pwdreg:true,passwordnumber:true,passwordletter:true},
	  repasswd: {required: true,equalTo:"#passwd" },
	  },
	  error: function(element) {
            element.addClass("error");
        },
	  messages: {
	  fname: {required:"Please enter first name",lettersonly:"Enter only alphabates"},
	  lname: {required:"Please enter last name",lettersonly:"Enter only alphabates"},
	  email: {required:"Please enter a email address",email:"Enter Valid Email Address"},
	  reemail: {required:"Please enter a re-email address",email:"Enter Valid Re-Email Address",equalTo:"Please match the Email Addresses"},
	  passwd:{required: "Please enter a password",minlength: "Password length must be at least 8 characters",pwdreg:"Password must contain only letters,number" },
	  repasswd: {required:"Please enter a re-password",equalTo:"Password and Re-Password is not match"}
	  },
	 success: function(element) {
		 var $element = $(element);
		 $element.append('<label class="sign-up-field-succ-icon icon-ok-sign" for="login-name" id="succ"></label>');
	   }	,
	  submitHandler: function(form) {
			  //submit the form
			  $.post("register/add_edit_register", //post
				  $("#signup").serialize(),
				  function(data){
				  //if message is sent
				  $("#reg_msg").css("display","block");
				
				  if(data!="1")
				  {
					  $("#signup").css("display","none");
					  window.location.href="<?php echo base_url();?>/home/msg/registerdone";
				  }
				  else
				  {
					  $("#welcome_msg").html("Email Address already exits!Please try another");
				  }
 			 });
  	return false; //don't let the page refresh on submit.
  }
  });

</script>
