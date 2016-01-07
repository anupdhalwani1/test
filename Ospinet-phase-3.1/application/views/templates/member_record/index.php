<div class="row" id="reg_msg">
	<div class="container">
		<div class="row-fluid">
			<div class="row">
				<div class="span12" style="padding-left: 60px;">
					<div class="span8">
						<div style="font-size: 24px;">
						<?php echo  '<span style="color:#1ABC9C">'.ucwords(strtolower($rc_list_m->fname)) ." ".ucwords(strtolower($rc_list_m->lname))."(".ucwords(strtolower($rc_list_m->gender)).",".$rc_list_m->age.")</span>" ?>
						</div>
					</div>
					<div style="padding-bottom: 10px; float: right; padding-right: 3%;">
						<a href='<?php echo base_url();?>member/' id="edit"
							class="btn btn-large btn-info"><i class="icon-caret-left"></i>&nbspBack</a>&nbsp;<a
							href='<?php echo base_url();?>member_record/index/m_id/<?php echo $m_id ?>'
							id="edit" class="btn btn-large btn-info"><i
							class="icon-plus-sign-alt"></i>&nbspAdd Record</a>
					</div>
				</div>
			</div>
			<div class="span6">
				<table class="table table-striped">
					<thead>
						<tr>
							<td>Title</td>
							<td>Description</td>
							<td>No.Of.Files</td>
						</tr>
					</thead>
					<tbody>
					<?php if(count($rc_list)):foreach ($rc_list as $list):?>
						<tr>
							<td><?php echo anchor('member_record/index/id/'.$list->id.'/m_id/'.$m_id,$list->title)?>
							</td>
							<td><?php echo $list->description; ?>
							</td>
							<td><?php  echo $list->filecount;?>
							</td>
							<!--              <td><?php echo btn_delete('member_record/delete/id/'.$list->id.'/m_id/'.$m_id)?></td>-->
						</tr>
						<?php endforeach;?>
						<?php else:?>
						<tr>
							<td colspan="5">We could not find any members record</td>
						</tr>
					</tbody>
					<?php endif;?>
				</table>
			</div>
			<div class="span5">
				<div class="inner-form" align="center">
				<?php $mname=ucwords(strtolower($rc_list_m->fname))." ".ucwords(strtolower($rc_list_m->lname));?>
					<legend class="hlegend">
						<div <?php if (!empty($rc_list_one->id)){?>
							style="float: left; padding-left: 5px; padding-right: 45px;"
				<?php }?>>
							<?php echo empty($rc_list_one->id)? 'Add record For :'.$mname :'Edit member For : '.$mname ; ?>
						</div>
						<?php if (!empty($rc_list_one->id)){echo '<div style="floa:right;">'.btn_delete('member_record/delete/id/'.$rc_list_one->id.'/m_id/'.$rc_list_m->id).'</div>';}?>
					</legend>
					<div style="padding: 24px 23px 1px">
					<?php if(! empty($rc_list_one->id)) {?>
						<div style="width: 80%; height: 30px; text-align: left">Previous
							Records Files</div>
						<div style="width: 80%; height: 100%; text-align: left">
							<table class="table table-striped">
							<?php if(count($mfiles)):?>
							<?php foreach ($mfiles as $list):?>
								<tr>
									<td><?php echo "<a href='".base_url()."member_record_file/".$list->filename."' target='_blank'>".$list->filename."</a>";?>
									</td>
									<td><?php echo btn_delete('member_record/delete_files/fileid/'.$list->id.'/id/'.$rc_list_one->id.'/m_id/'.$rc_list_m->id)?>
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

						<?php
						$actionlink=base_url()."index.php/member_record/index/id/".$rc_list_one->id."/m_id/".$rc_list_m->id;
					}
					else
					{
						$actionlink=base_url()."index.php/member_record/index/m_id/".$rc_list_m->id;
					}
					?>

						<form id="addedit_member_record" method="post"
							action="<?php echo $actionlink?>">
							<input type="hidden" id="submit_form" name="submit_form"
								value="1"> <input type="hidden" id="member_id" name="member_id"
								value="<?php echo $rc_list_m->id?>">


							<div class="control-group">
								<input type="text" class="inner-field" id="title" name="title"
									placeholder="Title" value="<?php echo $rc_list_one->title;?>">
							</div>
							<div class="errormsg"></div>
							<div class="control-group">
								<textarea style="height: 100px;" class="inner-field"
									id="description" name="description" placeholder="Description">
									<?php echo $rc_list_one->description;?>
								</textarea>
							</div>
							<div class="errormsg"></div>
							<div style="width: 100%; height: 100px; margin-bottom: 18px;"></div>
							<div class="control-group" style="margin-top: 18px;" id="files">


							</div>
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
								<input name="userfile[]" id="userfile" type="file"
									multiple="true" />
								<div id="progressbox">
									<div id="progressbar"></div>
									<div id="statustxt"></div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
/*File Uploading Code*/
fu(document).ready(function(e) {
var progressbox 	= $('#progressbox');
var submitbutton 	= $("#Save");
var progressbar 	= $('#progressbar');
var statustxt 		= $('#statustxt');
var output 			= $("#output");
var completed 		= '0%';	
fu('#userfile').change(function () { makeFileList();});
function makeFileList() {
				var options ={
					beforeSend: function() {
						submitbutton.attr('disabled', 'disabled');
						statustxt.empty();
						progressbox.show(); //show progressbar
						progressbar.width(completed); //initial value 0% of progressbar
						statustxt.html(completed); //set status text
						statustxt.css('color','#000'); //initial color of status text
					},
					uploadProgress: function(event, position, total, percentComplete) { //on progress
						progressbar.width(percentComplete + '%') //update progressbar percent complete
						statustxt.html(percentComplete + '%'); //update status text
						if($("#files").html()!="")
						{
							if(percentComplete>95)
								{
									statustxt.css('color','#ccc'); //change status text to white after 50%
								}
								return false;
						}
						},
					success: function(data)
					{
						$("#fileupload_c").css("top","-234px");
						$("#files").html(data);
						submitbutton.removeAttr('disabled'); //enable submit button
						progressbox.hide(); // hide progressbar
						
					}
				};
			  fu("#fileuploadfrm").ajaxForm(options).submit();
			 return false;
		}
});

//form validation rules
vali("#addedit_member_record").validate({
	  errorPlacement: function(error, element) {
	    error.appendTo( element.parent(".control-group").next(".errormsg"));
	  },
	  rules: {
	  title: {required:true},
	  },
	  messages: {
	  title: {required:"Please enter title"},
	  }
  });
 
</script>
		</div>
	</div>
</div>
