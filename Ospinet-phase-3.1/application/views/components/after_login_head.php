<?php ?>
<div
	class="container-fluid menu-hidden">
	<!-- Main Sidebar Menu -->
	<?php $this->load->view('components/side_menu'); ?>
	<!-- // Main Sidebar Menu END -->
	<!-- Content -->
	<div class="black_overlay_load" id="loading_effect">
		<ul class="loading_effect">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<div id="fade" class="black_overlay"
		onclick="javascript:close_lightbox();"></div>
	<div id="content">
		<div class="navbar hidden-print navbar-inverse box main"
			role="navigation">
			<div
				class="user-action user-action-btn-navbar pull-left border-right">
				<button class="btn btn-sm btn-navbar btn-primary btn-stroke">
					<i class="fa fa-bars fa-2x"></i>
				</button>
			</div>


			<div
				class="user-action user-action-btn-navbar pull-left border-right"
				style="width: 50px;">
				<li class="dropdown notif"><a href=""
					class="dropdown-toggle dropdown-hover" data-toggle="dropdown"><i
						class="notif-block fa fa-user"></i><span
						class="badge badge-primary"
						<?php echo($requestcount == '0') ? "style=background-color:black" : "style=background-color:red";?>><?php echo $requestcount;?>
					</span> </a>
					<ul class="dropdown-menu alerts">
						<li class="heading"><i class="fa fa-user"></i><span>Contact
								Requests</span></li>
								<?php foreach($requestpopup as $val):?>
						<li class="media" style="height: 75px;"><a class="pull-left"
							href="#"><img class="media-object thumb"
							<?php if($val->profile_pic!= NULL) {?>
								src="<?php echo base_url().'profile_pic/member_pic_250/';?>
							<?php echo $val->profile_pic. "_250"."." .$val->type;?>"
							<?php } else { ?>
								src="<?php echo base_url().'assets/images/people/80/default_avatar_80x80.png';?>"
								<?php } ?> alt="50x50" width="64"> </a>
							<div class="media-body" style="height: 64px;">
								<h5 class="media-heading" style="height: 24px;">
								<?php echo $val->fname. " " .$val->lname; ?>
								</h5>
								<div>
									<button type="button" id="confirm"
										onclick="confirm(<?php echo $val->userid;?>);"
										class="savereports btn btn-primary"
										style="float: left; margin-left: 0px;">
										<i id="Search_member"></i> Confirm
									</button>
								</div>
								<div>

									<button type="button" value="ignore" id="ignore"
										onclick="ignore(<?php echo $val->userid;?>);"
										class="savereports btn btn-primary"
										style="float: right; background: grey; border-color: gray; margin-right: 6px;">
										Ignore</button>
								</div>

							</div>
						</li>
						<?php endforeach;?>
			
			</div>


			<div
				class="user-action user-action-btn-navbar pull-left border-right"
				style="width: 50px;">
				<li class="dropdown notif"><a href=""
					class="dropdown-toggle dropdown-hover" data-toggle="dropdown"><i
						class="notif-block fa fa-bell-o"></i><span
						class="badge badge-primary"
						<?php echo($alertscount == '0') ? "style=background-color:black" : "style=background-color:red";?>><?php echo $alertscount;?>
					</span> </a>
					<ul class="dropdown-menu alerts">
						<li class="heading"><i class="fa fa-bell-o"></i><span>Alerts</span>
						</li>
						<?php if(isset($alertpopup)) {?>
						<?php  foreach($alertpopup as $value): ?>
						<li><a
							href="<?php echo base_url().'contacts#contactid/'.$value['id'];?>">
								<h5 style="color: #1ba0a2;">
								<?php echo $value['fname']. " " .$value['lname'];?>
								</h5>
								<h5>
								<?php echo($value['type_id'] == 'friend_request') ? " Accepted your friend request " : " Shared document with you ";?>
								</h5> </a>
							<div class="action pull-right">
								<a class="delete" id="ok"
									data-type="<?php echo($value['type_id']);?>"
									onclick="javascript:ok(<?php echo $value['id'];?>,this);"><i
									class="fa fa-times"></i> </a>
							</div>
						</li>
						<?php endforeach;?>
						<?php }?>
					</ul>
				</li>
			</div>
			<div
				class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
				<div class="dropdown username hidden-xs pull-left">
				<?php foreach($get_frst_mmbr as $fmbr) ?>
					<a class="dropdown-toggle " data-toggle="dropdown" href="#"> <span
						class="media margin-none"> <span class="pull-left"> <img
						<?php if(($fmbr['profile_pic'] != NULL)) {?>
								src="<?php echo base_url().'profile_pic/member_pic_35/';?><?php echo $fmbr['profile_pic']."_35.".$fmbr['type'];?>"
								<?php } else { ?>
								src="<?php echo base_url().'assets/images/people/35/default_avatar_35x35.png';?>"
								<?php } ?> alt="user" class="img-circle"> </span> <span
							class="media-body"> <?php echo $this->session->userdata("fname"); ?>&nbsp;&nbsp;<?php echo $this->session->userdata("lname"); ?><span
								class="caret"></span> </span> </span> </a>
					<ul class="dropdown-menu pull-right">

						<li><a
							href="<?php echo base_url().'member#memberid/'.$fmbr['first_member_id'];?>"
							onclick="javascript:edit_profile('<%= id %>')" class="glyphicons
								user"><i></i>Profile</a></li>
						<!-- <li><a class="glyphicons cogwheels"><i></i>Settings</a></li>
												<li><a class="glyphicons buoy"><i></i>Help & Support</a></li>  -->
						<li><a href="<?php echo base_url().'register/logout';?>"
							class="glyphicons power"><i></i>Logout</a></li>
						<!--<li><a href="social_account.html?lang=en">Settings</a></li>-->
						<!--<li><a href="login.html?lang=en">Help & Support</a></li>-->
					</ul>
				</div>
				<!--<div class="dropdown dropdown-icons padding-none">
										<a data-toggle="dropdown" href="#" class="btn btn-primary btn-circle dropdown-toggle"><i class="fa fa-user"></i> </a>
										<ul class="dropdown-menu">
											<li data-toggle="tooltip" data-title="Photo Gallery" data-placement="left" data-container="body"><a href="gallery_photo.html?lang=en"><i class="fa fa-camera"></i></a></li>
											<li data-toggle="tooltip" data-title="Tasks" data-placement="left" data-container="body"><a href="tasks.html?lang=en"><i class="fa fa-code-fork"></i></a></li>
											<li data-toggle="tooltip" data-title="Employees" data-placement="left" data-container="body"><a href="employees.html?lang=en"><i class="fa fa-group"></i></a></li>
											<li data-toggle="tooltip" data-title="Contacts" data-placement="left" data-container="body"><a href="contacts.html?lang=en"><i class="fa fa-phone-square"></i></a></li>
										</ul>
									</div>-->
			</div>