<div id="menu"
	class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
	<div id="sidebar-discover-wrapper">
		<!-- add id to give record sub option "sidebar-discover-wrapper" -->
		<div id="logoWrapper">
			<a id="logo" class="animated fadeInDown"><img
				src="<?php echo base_url().'assets/images/logo/app-logo-style-default.png';?>"
				alt=""> </a>
		</div>
		<ul class="list-unstyled">
		<?php foreach($get_frst_mmbr as $fmbr) ?>
			<li <?php echo ($linkname=="member")?'class=" active"':"";?>><a
				href="<?php echo base_url().'member#memberid/'.$fmbr['first_member_id'];?>">
					<!--<span class="badge pull-right badge-primary">8</span> --> <i
					id="records_" class="fa fa-file"></i><span>Records</span> </a></li>

			<li <?php echo ($linkname=="contact")?'class=" active"':"";?>><a
				href="<?php echo base_url().'contacts#contactid/new';?>"
				data-toggle="sidebar-discover"> <span
					class="badge pull-right badge-primary"><?php echo $contactcount;?>
				</span> <i id="contacts_" class="fa fa-user-md"></i><span>Contacts</span>
			</a></li>

			<li><a id="ctScheduleMeetingButton" href="javascript:void(0)"> <i
					class="fa fa-video-camera"></i><span>Video Call</span> </a></li>

			<li <?php echo ($linkname=="files")?'class=" active"':"";?>><a
				href="<?php echo base_url().'files#fileid/new';?>"> <i id="files_"
					class="fa fa-folder"></i><span>Files</span> </a></li>

			<div id="sidebar-discover-example" class="sidebar-discover-menu">
				<div
					class="innerAll text-center border-bottom text-white animated pulse">
					<strong>Manage Records</strong>
				</div>
				<ul class="animated fadeIn">
					<li class="active"><a href=""><i class="fa fa-users"></i> All
							Members</a></li>
					<li><a href=""><span class="badge pull-right badge-primary">21</span><i
							class="fa fa-files-o"></i> All Records</a></li>
					<li><a href=""><span class="badge pull-right badge-primary">6</span><i
							class="fa fa-tags"></i> All Labels</a></li>
					<li class="hasSubmenu"><a href="#submenu" data-toggle="collapse"><i
							class="fa fa-plus-square-o"></i> Add New</a>
						<ul class="collapse" id="submenu">
							<li><a href="">Add Member</a></li>
							<li><a href="">Add Record</a></li>
							<li><a href="">Add Label</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</ul>
	</div>
</div>

<!-- Video Call Code -->
<script type="text/javascript" src="https://www.thecoffeetable.in/_common/javascripts/jquery.tipsy.js"></script>
<script type="text/javascript" src="https://www.thecoffeetable.in/_common/javascripts/third-party/ct-jquery-ui-datepicker/ct-jquery-ui.min.js"></script>                             
<script type="text/javascript" src="https://www.thecoffeetable.in/_common/javascripts/coffee-table/min-coffee-table.js"></script>   

<link rel="stylesheet" type="text/css" href="https://www.thecoffeetable.in/public/css/coffee-table-v2.css" />
<link rel="stylesheet"
	href="<?php echo base_url().'assets/coffeetable/coffeetable_css/coffee-table-custom.css';?>" />
<link rel="stylesheet" type="text/css" href="https://www.thecoffeetable.in/_common/javascripts/third-party/ct-jquery-ui-datepicker/ct-jquery-ui.min.css" />

<script type="text/javascript">
			//when document is ready
			$(document).ready(function()
			{
				//Please note you will have to get ospinet's logged in user_id, user_name and user_email_id and store it in following variables.
				var id = "<?php echo $this->session->userdata('email');?>"
				callerId = id;
				var email = "<?php echo $this->session->userdata('email');?>"		
				callerEmailId = email;
				var name = "<?php echo $this->session->userdata('fname')." ".$this->session->userdata('lname'); ?>"
				callerName = name; 
			
				//bind click event on contacts
				$('#ctScheduleMeetingButton').click(function () 
				{ 
					$('#fade').css("display", "block");
					$('.coffee-table').css("display", "block");
					$('.black_overlay').css({
				        'opacity': '0.6',
				       	'background-color': 'black',
				    });
					initScheduleMeeting('CMR00000010','APP00000018','instantCall',false, true);					
					$('.message-box-button-2').click(function () 
					{ 
						$('#fade').css("display", "none");
					});
					$('.message-box-close-button').click(function () 
					{ 
						$('.black_overlay').css("display", "none");
					});
			
				});
																
				//When the window is closing then before unload event disconnect
				//from the coffeetable server.
				$(window).on('beforeunload', function() { disconnectCoffeeTable();});                
			});
		</script>

<div id="video_call" class="coffee-table">
	<div id="ctNotification" class="hide"></div>

	<div id="ctMessageBox" class="message-box coffee-table-hide">

		<div class="message-box-title-container" style="background: #1BA0A2;";>
			<div id="ctMessageBoxTitle" class="message-box-title"
				style="display: none;"></div>
			<div id="ctMessageBoxTitle" class="message-box-title"
				style="color: white; font-size: 20px;">Ospinet Call</div>
			<div id="ctMessageBoxClose"
				class="message-box-close-button coffee-table-hide"></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>

		<div class="message-box-content-container">

			<div id="ctMessageBoxInfo" class="message-box-info coffee-table-hide"></div>

			<div class="clear"></div>

			<div id="ctMessageBoxMainTextContainer"
				class="message-box-text-container">
				<table class="message-box-text-table">
					<tr>
						<td id="ctMessageBoxImageContainer"
							class="message-box-image-container coffee-table-hide"><img
							id="ctMessageBoxSuccessImage"
							src="http://www.thecoffeetable.in/public/images/message-box-check.png"
							class="coffee-table-hide" /> <img id="ctMessageBoxLoaderImage"
							src="http://www.thecoffeetable.in/public/images/loader.gif"
							class="coffee-table-hide" /> <img id="ctMessageBoxUserImage"
							src="http://www.thecoffeetable.in/public/images/user-image.png"
							class="coffee-table-hide" />
						</td>
						<td id="ctMessageBoxMainText" class="message-box-text"></td>
					</tr>
				</table>
			</div>

			<div class="clear"></div>
			<div id="ctMessageBoxDetails"
				class="message-details coffee-table-hide">
				<ul id="ctMessageBoxDetailsPoints" class="detail-points"></ul>
				<ul id="ctMessageBoxSolutionPoints" class="solution-points"></ul>
			</div>

			<div class="clear"></div>
			<div id="ctAunthentication"
				class="message-box-authentication coffee-table-hide">
				<select tabindex="1" class="drop-down-user-type"
					id="ctAddParticipantsSelectBox">
					<option value="" selected="selected">Select participant type</option>
					<option value="Guest">Guest</option>
					<option value="Initiator">Meeting Initiator</option>
				</select> <input id="ctTextBox" name="txtParticiapantBox"
					class="add-participant-text-box" type="text" size="40"
					maxlength="40" tabindex="1" placeholder="Enter your email address" />

				<input id="ctVerificationCodeTextBox"
					class="participant-verification-text-box"
					name="txtParticiapantVerificationCodeBox" type="text"
					placeholder="Verification code" tabindex="2" size="8" maxlength="8" />

			</div>
			<div class="clear"></div>

			<div id="ctAddParticpants"
				class="message-box-add-participants coffee-table-hide">
				<input type="text"
					class="add-participant-text-box coffee-table-hide" id="ctTopic"
					size="20" placeholder="Topic of the meeting (optional)" /> <input
					type="text" class="add-participant-text-box coffee-table-hide"
					id="ctUsername" size="20" placeholder="Username" /> <input
					type="password" class="add-participant-text-box coffee-table-hide"
					id="ctPassword" size="20" placeholder="Password" /> <input
					type="text" class="add-participant-text-box" id="ctParticipant1"
					size="20" placeholder="Participant 1" tabindex="1" /> <input
					type="text" class="add-participant-text-box" id="ctParticipant2"
					size="20" placeholder="Participant 2" tabindex="2" /> <input
					type="text" class="add-participant-text-box" id="ctParticipant3"
					size="20" placeholder="Participant 3" tabindex="3" /> <input
					type="text" class="add-participant-text-box" id="ctParticipant4"
					size="20" placeholder="Participant 4" tabindex="4" />
			</div>
			<div class="clear"></div>
			<div id="ctMessageBoxCreateMeetingOptions"
				class="message-box-meeting-options coffee-table-hide">
				<a id="ctMessageBoxAddMessage" class="message-box-add-message"
					href="#">+ Add a Message</a>
				<textarea id="ctMessageBoxMeetingMessage"
					class="message-box-meeting-message coffee-table-hide"
					placeholder="Start typing your message here" rows="3" cols="5"></textarea>
			</div>
			<div class="clear"></div>
			<div id="ctMessageBoxButtons"
				class="message-box-button-container coffee-table-hide">
				<div tabindex="0" id="ctMessageBoxButton1"
					class="message-box-button-1 coffee-table-hide"
					style="display: block; background-color: #1BA0A2;">Accept</div>
				<div tabindex="0" id="ctMessageBoxButton2"
					class="message-box-button-2 coffee-table-hide">Reject</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
