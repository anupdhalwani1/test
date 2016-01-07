<div class="container-fluid">
	<div class="row-fluid" align="center">
		<div class="span6" style="float: none;">
			<div class="sign-up-form" align="center">

			<?php echo form_open('member/edit',array('id'=>'addedit_member')); ?>
				<input type="hidden" id="submit_form" name="submit_form" value="1">
				<legend>
				<?php echo  empty($rc_list->id)? 'Add New member' :'Edit member '.$rc_list->fname." ".$rc_list->lname; ?>
				</legend>
				<div class="control-group">
					<input type="text" class="sign-up-field" id="fname" name="fname"
						placeholder="First Name" value="<?php echo $rc_list_one->fname;?>">
					<label class="sign-up-field-icon icon-user" for="login-name"></label>
				</div>
				<div class="errormsg"></div>
				<div class="control-group">
					<input type="text" class="sign-up-field" id="lname" name="lname"
						placeholder="Last Name" value="<?php echo $rc_list_one->lname;?>">
					<label class="sign-up-field-icon icon-user" for="login-name"></label>
				</div>
				<div class="errormsg"></div>
				<div class="control-group gender" style="margin-bottom: 18px;">
					<input type="radio" name="gender" id="Male" value="Male"
					<?php echo $rc_list_one->gender=="Male"? 'checked="checked"':''; ?> />
					<label for="Male" class="btn1 btnM"><i class="icon-male"></i>
					</label> <input type="radio" name="gender" id="Female"
						value="Female"
						<?php echo $rc_list_one->gender=="Female"? 'checked="checked"':''; ?> />
					<label for="Female" class="btn1 btnF"> <i class="icon-female"></i>
					</label>
				</div>
				<div class="errormsg"></div>
				<div class="control-group birthinfo" style="margin-bottom: 18px;">
					<input type="radio" name="birth_info" id="Dob" value="Dob"
					<?php echo $rc_list_one->birth_info=="Dob"? 'checked="checked"':''; ?> />
					<label for="Dob" class="btn1">DOB</label> <input type="radio"
						name="birth_info" id="Age" value="Age"
						<?php echo $rc_list_one->birth_info=="Age"? 'checked="checked"':''; ?> />
					<label for="Age" class="btn1">Age</label> <input type="radio"
						name="birth_info" id="Unborn" value="Unborn"
						<?php echo $rc_list_one->birth_info=="Unborn"? 'checked="checked"':''; ?> />
					<label for="Unborn" class="btn1">Unborn</label>
				</div>
				<div class="errormsg"></div>
				<div class="control-group birtdiv Dob"
				<?php echo $rc_list_one->birth_info=='Dob'? 'style="display:block;margin-bottom:18px;"':'style="display:none;margin-bottom:18px;"; '?>>
					<div style="width: 80%; height: 33px">
						<div class="span3 styled-select">
							<select name="bd_year" id="bd_year">
								<option value="">Year</option>
							</select>
						</div>
						<div class="span3 styled-select">
							<label> <select name="bd_month" id="bd_month" class="bd_month">
									<option value="">Month</option>
							</select> </label>
						</div>
						<div class="span3 styled-select">
							<label> <select name="bd_day" id="bd_day" class="bd_day">
									<option value="">Day</option>
							</select> </label>
						</div>
					</div>
				</div>

				<div class="control-group birtdiv Age"
				<?php echo $rc_list_one->birth_info=='Age'? 'style="display:block;"':'style="display:none;"; '?>>
					<input type="text" class="sign-up-field" id="age" name="age"
						placeholder="Age"
						value="<?php echo $rc_list_one->birth_info=='Age'?$rc_list_one->age:''?>">
				</div>
				<div class="control-group birtdiv Unborn"
				<?php echo $rc_list->birth_info=='Unborn'? 'style="display:block;margin-bottom:18px;"':'style="display:none;margin-bottom:18px;"; '?>>
					<div style="width: 80%; height: 33px" class="ubpdiv">
						<div class="span3 styled-select">
							<select name="ub_year" id="ub_year" class="bd_year" value="0">
								<option value="">Year</option>
							</select>
						</div>
						<div class="span3 styled-select">
							<label> <select name="ub_month" class="ub_month" value="0">
									<option value="">Month</option>
							</select> </label>
						</div>
						<div class="span3 styled-select">
							<label"> <select name="ub_day" class="ub_day" value="0">
									<option value="">Day</option>
							</select> </label>
						</div>
					</div>
				</div>
				<div class="errormsg erragediv" style="width: 80%;"></div>
				<div class="errormsg errbirtdiv" style="width: 80%;">
					<div id="err_bd_year" style="float: left; padding-right: 26px;"></div>
					<div id="err_bd_month" style="float: left; padding-right: 26px;"></div>
					<div id="err_bd_day" style="float: left;"></div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button type="submit" id="Save"
							class="btn btn-primary btn-large btn-block">Save</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
function fillyear_select(start_year,end_year,select_name,op)
{
	if(op=="--")
	{
		for (i = start_year; i > end_year; i--)
		{
			$("select[name='"+select_name+"']").append($('<option />').val(i).html(i));
		}	
	}
	else
	{
		for (i = start_year; i < end_year; i++)
		{
			$("select[name='"+select_name+"']").append($('<option />').val(i).html(i));
		}
	}
	
}
function fillmonth_select(year_dd_val,control_intial)
{
	var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$("select[name='"+control_intial+"_month']").empty();
	$("select[name='"+control_intial+"_day']").empty();
	$("select[name='"+control_intial+"_day']").append($('<option />').val(0).html("Day"));
	$("select[name='"+control_intial+"_month']").append($('<option />').val(-1).html("Month"));

	var no_of_month=12;
	var start_month=0;
	if(year_dd_val==new Date().getFullYear() && control_intial=="bd")//(this codition for "dob")if dd value is current year then shows month "upto" current month else shows all months
	{
		start_month=0;
		no_of_month= new Date().getMonth()+1;
	}
	else if(year_dd_val==new Date().getFullYear() && control_intial=="ub")//(this codition for "unborn")if dd value is current year then shows month "above" current month else shows all months
	{
	    start_month=new Date().getMonth();		
		no_of_month= 12
	}
	else
	{
		start_month=0;
		no_of_month=12;
	}
		console.log(start_month+" "+no_of_month);
	for (i = start_month; i < no_of_month; i++)
	{
		$("select[name='"+control_intial+"_month']").append($('<option />').val(i).html(months[i]));
	}
}
function fillday_select(month_dd_val,control_intial)
{
	$("select[name='"+control_intial+"_day']").empty();
	$("select[name='"+control_intial+"_day']").append($('<option />').val(0).html("Day"));
	
	var no_of_days=daysInMonth( parseInt(month_dd_val)+1,$("select[name='"+control_intial+"_year']").val());
	var start_day=1;
	if($("select[name='"+control_intial+"_year']").val()==new Date().getFullYear() && month_dd_val==new Date().getMonth()&& control_intial=="bd")
	{
		start_day=1;
		no_of_days=new Date().getDate();
	}
	else if($("select[name='"+control_intial+"_year']").val()==new Date().getFullYear() && month_dd_val==new Date().getMonth()&& control_intial=="ub")
	{
		start_day=new Date().getDate();
	}
	
	for (i = start_day; i <=no_of_days ; i++)
		{
			$("select[name='"+control_intial+"_day']").append($('<option />').val(i).html(i));
		}
}
function set_selected_date()
{
	var day,month,year,dd_intial;
	day='<?php echo $rc_list->birth_day;?>';
	month='<?php echo $rc_list->birth_month;?>';
	year='<?php echo $rc_list->birth_year;?>';
	$("#Dob").is(':checked')?dd_intial="bd":($("#Unborn").is(':checked')?dd_intial="ub":dd_intial="");
	$("select[name='"+dd_intial+"_year']").val(year);
	fillmonth_select(year,dd_intial);
	$("select[name='"+dd_intial+"_month']").val(month-1);
	fillday_select(month-1,dd_intial);
	$("select[name='"+dd_intial+"_day']").val(day);
}
$(function() 
{ 
	fillyear_select(new Date().getFullYear(),"1900","bd_year","--");
	fillyear_select(new Date().getFullYear(),parseInt(new Date().getFullYear())+5,"ub_year","++");
	set_selected_date();
	$("select[name='bd_year']").change(function(){fillmonth_select($(this).val(),'bd');})
	$("select[name='ub_year']").change(function(){fillmonth_select($(this).val(),'ub');})
	$("select[name='bd_month']").change(function(){fillday_select($(this).val(),'bd');})
	$("select[name='ub_month']").change(function(){fillday_select($(this).val(),'ub');})
	
	$("input[name='birth_info']").click(function(){
							var divid="."+$(this).attr("id");
							$(".birtdiv").hide();
							$(divid).show();
//							$(divid).css("visibility","visible");
		});
});
function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}
</script>
<script type="text/javascript">
var arr = [ "bd_year", "bd_month", "bd_day", "ub_year","ub_month","ub_day","err_bd_year", "err_bd_month", "err_bd_day","age"];
vali.validator.addMethod("lettersonly", function(value, element) {
		 	 return this.optional(element) || /^[a-z]+$/i.test(value);
												  }, "Letters only please");
function check_dob(element)
{
 if($('#Dob').is(':checked'))
 {
	 return true;
 }else{
	return false;
 }
}
function check_unborn(element)
{
 if($('#Unborn').is(':checked'))
 {
	 return true;
 }else{
	return false;
 }
}
function check_age(element)
{
 if($('#Age').is(':checked'))
 {
	 return true;
 }else{
	return false;
 }
}		
//form validation rules
vali("#addedit_member").validate({
	  errorPlacement: function(error, element) {
	    error.appendTo( element.parent(".control-group").next(".errormsg"));
		if($.inArray(element.attr("name"),arr)!=-1) 
		{
			if(element.attr("name")=="age")
			{
				$(".erragediv").html(error);
			}
			else
			{
				var error_id=element.attr("name").replace("ub","bd");
				errorid="#err_"+error_id;
				console.log(errorid);
				$(".errbirtdiv").find(errorid).html(error);
			}
		}
	  },
	  rules: {
	  fname: {required:true, lettersonly:true},
	  lname: {required:true, lettersonly:true},
	  gender:{required: true},
	  birth_info:{required:true},
	  bd_year:{required:{depends:check_dob(this)}},
	  bd_month:{required:{depends:check_dob(this)}},	
	  bd_day:{required:{depends:check_dob(this)}},
	  age:{required:{depends:check_age(this)}},
	  ub_year:{required:{depends:check_dob(this)}},
	  ub_month:{required:{depends:check_dob(this)}},	
	  ub_day:{required:{depends:check_dob(this)}},		
	  },
	  messages: {
	  fname: {required:"Please enter first name",lettersonly:"Enter only alphabates"},
	  lname: {required:"Please enter last name",lettersonly:"Enter only alphabates"},
	  gender:{required:"Please select a gender"},	
  	  birth_info:{required:"Please select birthtype"},
	  bd_year:{required:" select year "},
	  bd_month:{required:" select month "},	
  	  bd_day:{required:" select day "},
	  age:{required:"Please enter a age"}	,
	  ub_year:{required:" select year "},
	  ub_month:{required:" select month "},	
  	  ub_day:{required:" select day "},
	  }
	  
  });
<!-- success: function(element) {var $element =  element.parent().prev();f($.inArray(element.parent().attr("id"),arr)!=-1){	element.parent().html("");
<!--}else{$element.append('<label class="sign-up-field-succ-icon icon-ok-sign" for="login-name" id="succ"></label>');}}-->
</script>
