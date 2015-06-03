<div class="container-fluid">
	<div class="row-fluid" align="center">
		<div class="span6" style="float: none;">
			<div class="sign-up-form" align="center">
			<?php $mname='<span style="color:#1ABC9C">'.ucwords(strtolower($rc_list_m->fname))." ".ucwords(strtolower($rc_list_m->lname)).'</span>';?>
				<legend>
				<?php echo  empty($rc_list->id)? 'Add New record For '.$mname :'Edit member For'.$mname; ?>
				</legend>
				<?php if(! empty($rc_list->id)) {?>
				<div style="width: 80%; height: 30px; text-align: left">Previous
					Records Files</div>
				<div style="width: 80%; height: 100%; text-align: left">
					<table class="table table-striped">
					<?php if(count($mfiles)):?>
					<?php foreach ($mfiles as $list):?>
						<tr>
							<td><?php echo "<a href='".base_url()."member_record_file/".$list->filename."' target='_blank'>".$list->filename."</a>";?>
							</td>
							<td><?php echo btn_delete('member_record/delete_files/fileid/'.$list->id.'/id/'.$rc_list->id.'/m_id/'.$rc_list_m->id)?>
							</td>
						</tr>
						<?php endforeach;?>
						<?php else:?>
						<tr>
							<td colspan="2">We could not find any members record</td>
						</tr>
						<?php endif;?>
					</table>
				</div>
				<?php }?>
				<form id="addedit_member_record" method="post" action="">
					<input type="hidden" id="submit_form" name="submit_form" value="1">
					<input type="hidden" id="member_id" name="member_id"
						value="<?php echo $rc_list_m->id?>">


					<div class="control-group">
						<input type="text" class="sign-up-field" id="title" name="title"
							placeholder="Title" value="<?php echo $rc_list->title;?>">
					</div>
					<div class="errormsg"></div>
					<div class="control-group">
						<textarea style="height: 100px;" class="sign-up-field"
							id="description" name="description" placeholder="Description"
							value="<?php echo $rc_list->description;?>"></textarea>
					</div>
					<div class="errormsg"></div>
					<div style="width: 100%; height: 100px; margin-bottom: 18px;"></div>
					<div class="control-group" style="margin-top: 18px;" id="files"></div>
					<div class="control-group">

						<div class="controls">

							<button type="submit" id="Save"
								class="btn btn-primary btn-large btn-block">Save</button>
						</div>
					</div>
				</form>
				<div class="control-group" id="fileupload_c"
					style="position: relative; top: -181px;">

					<form id="fileuploadfrm" method="post"
						action="<?php echo base_url()?>index.php/member_record/upload"
						enctype="multipart/form-data">
						<input name="userfile[]" id="userfile" type="file" multiple="true" />
						<div id="progressbox">
							<div id="progressbar"></div>
							<div id="statustxt"></div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
/*File Uploading Code*/
$(document).ready(function(e) {
var progressbox 	= $('#progressbox');
var progressbar 	= $('#progressbar');
var statustxt 		= $('#statustxt');
var output 			= $("#output");
var completed 		= '0%';	
$('#userfile').change(function () { makeFileList();});
function makeFileList() {
				var options ={
					beforeSend: function() {
						statustxt.empty();
						progressbox.show(); //show progressbar
						progressbar.width(completed); //initial value 0% of progressbar
						statustxt.html(completed); //set status text
						statustxt.css('color','#000'); //initial color of status text
					},
					uploadProgress: function(event, position, total, percentComplete) { //on progress
						progressbar.width(percentComplete + '%') //update progressbar percent complete
						statustxt.html(percentComplete + '%'); //update status text
						if(percentComplete>50)
							{
								statustxt.css('color','#ccc'); //change status text to white after 50%
							}
						},
					success: function(data)
					{
						$("#fileupload_c").css("top","-234px");
						$("#files").html(data);
							return false;
					}
				};
			  $("#fileuploadfrm").ajaxForm(options).submit();
			 return false;
		}
});

//form validation rules
vali("#addedit_member_record").validate({
	  debug:true,
	  validClass:'success',
	  errorPlacement: function(error, element) {
	    error.appendTo( element.parent(".control-group").next(".errormsg"));
	  },
	  rules: {
	  title: {required:true},
	  },
	  messages: {
	  title: {required:"Please enter title"},
	  },
	   success: function(element) {
		  var $element =  element.parent().prev();
				 $element.append('<label class="sign-up-field-succ-icon icon-ok-sign" for="login-name" id="succ"></label>');
	   },
	  submitHandler: function(form) {
		  form.submit();
  }
  });
 
</script>
