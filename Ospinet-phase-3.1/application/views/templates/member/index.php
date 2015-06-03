<!-- Add mousewheel plugin (this is optional) -->
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/lib/jquery.mousewheel-3.0.6.pack.js';?>"></script>

<!-- Add fancyBox main JS and CSS files -->
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/jquery.fancybox.js?v=2.1.5';?>"></script>
<link
	rel="stylesheet"
	href="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/jquery.fancybox.css?v=2.1.5';?>"
	type="text/css" media="screen" />

<!-- Add Button helper (this is optional) -->
<link
	rel="stylesheet"
	href="<?php echo base_url().'fancyapps-fancyBox-18d1712//source/helpers/jquery.fancybox-buttons.css?v=1.0.5';?>"
	type="text/css" media="screen" />
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-buttons.js?v=1.0.5';?>"></script>

<!-- Add Media helper (this is optional) -->
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-media.js?v=1.0.6';?>"></script>

<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */
			 

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},
				afterLoad : function() {
                    var img_name =$(this.element).html();
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '')+'<a class="fa fa-cloud-download" href="<?php echo base_url(); ?>member/media_files/'+$.trim(img_name)+'" id="'+this.element.context.attributes.id.value+'" style="float: right; font-size: 20px; color: black;">Download</a>';									

				}
			});

			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});			
		});
	</script>

<?php $this->load->view('components/after_login_head');?>
<div
	class="col-md-3 padding-none visible-md visible-lg">
	<!--<div class="input-group innerLR">
							      		<input type="text" class="form-control input-sm" placeholder="Search stories ...">
							      		<span class="input-group-btn">
							        		<button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
							      		</span>
							    	</div>-->
	<!-- /input-group -->
</div>
<div class="user-action visible-xs user-action-btn-navbar pull-right">
	<button class="btn btn-sm btn-navbar-right btn-primary">
		<i class="fa fa-fw fa-power-off"></i><span class="menu-left-hidden-xs">
			Logout</span>
	</button>
</div>

<div class="clearfix"></div>
</div>
<!-- // END navbar -->

<div id="menu-top">
	<ul class="main pull-left">

		<!--<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-cog"></i> Layout <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&layout_fixed=true">Fixed Layout with Top menu</a></li>
				<li class="active"><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&layout_fixed=false">Fluid Layout with Sidebars</a></li>
				<li><a href="layout/layout-fixed-menu-top.html?lang=en">Layout examples</a></li>
		    </ul>
		</li>-->
		<!--<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-suitcase"></i> UI KIT <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="ui.html?lang=en">UI Elements</a></li>
				<li><a href="icons.html?lang=en">Icons</a></li>
				<li><a href="typography.html?lang=en">Typography</a></li>
				<li><a href="widgets.html?lang=en">Widgets</a></li>
				<li><a href="calendar.html?lang=en">Calendar</a></li>
				<li><a href="tabs.html?lang=en">Tabs</a></li>
				<li><a href="sliders.html?lang=en">Sliders</a></li>
				<li><a href="charts.html?lang=en">Charts</a></li>
				<li><a href="grid.html?lang=en">Grid</a></li>
				<li><a href="notifications.html?lang=en">Notifications</a></li>
				<li><a href="modals.html?lang=en">Modals</a></li>
				<li><a href="thumbnails.html?lang=en">Thumbnails</a></li>
				<li><a href="carousels.html?lang=en">Carousels</a></li>
				<li><a href="image_crop.html?lang=en">Image Cropping</a></li>
				<li><a href="twitter.html?lang=en">Twitter API</a></li>
				<li><a href="infinite_scroll.html?lang=en">Infinite Scroll</a></li>
		    </ul>
		</li>-->
		<!-- <li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-camera"></i> Media <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="gallery_video.html?lang=en">Video Gallery</a></li>
				<li><a href="gallery_photo.html?lang=en">Photo Gallery</a></li>
		    </ul>
		</li> -->
		<!--<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-check-square-o"></i> Forms <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="form_wizards.html?lang=en">Form Wizards</a></li>
				<li><a href="form_elements.html?lang=en">Form Elements</a></li>
				<li><a href="form_validator.html?lang=en">Form Validator</a></li>
				<li><a href="file_managers.html?lang=en">File Managers</a></li>
		    </ul>
		</li>-->
		<!--<li class="dropdown hidden-xs">
			<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-table"></i> Tables <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="tables.html?lang=en">Tables</a></li>
				<li><a href="tables_responsive.html?lang=en">Responsive Tables</a></li>
				<li><a href="pricing_tables.html?lang=en">Pricing Tables</a></li>
		    </ul>
		</li>-->
	</ul>
	<ul class="main pull-right visible-lg">
		<!--<li><a href="">Close <i class="fa fa-fw fa-times"></i></a></li>-->
	</ul>
	<ul class="colors pull-right hidden-xs">
	</ul>
</div>
<div class="layout-app">
	<!-- row-app -->
	<div class="row row-app">
		<!-- col -->
		<div class="col-sm-12">
			<!-- col-separator -->
			<div class="col-separator">
				<!-- row-app -->
				<div class="row row-app">
					<!-- col -->
					<div class="col-lg-3">
						<!-- col-separator.box -->

						<div class="col-separator col-separator-first box"
							id="list_of_members">
							<div class="heading-buttons border-bottom innerLR"
								id="add_new_member"></div>
							<!-- 						<div class="bg-white border-bottom innerAll">
																											<div class="input-group input-group-sm">
																												<div class="input-group-btn">
																													<button type="button" class="btn btn-default dropdown-toggle"
																														data-toggle="dropdown">Name <span class="caret"></span></button>
																													<ul class="dropdown-menu">
																														<li><a href="#">Name</a></li>
																														<li><a href="#">Phone Number</a></li>
																														<li><a href="#">Group</a></li>
																													</ul>
																												</div>
																											<input type="text" class="form-control" placeholder="Find a member ...">
																											</div>
																									</div>	 -->
							<div id="memberlist"></div>
						</div>
						<!-- // END col-separator.box -->
					</div>
					<!-- // END col -->
					<!-- col -->
					<!--main column		-->
					<div class="col-lg-9 showdetails">
						<!-- col-separator.box -->
						<div class="col-separator box" id="formdetails"></div>
						<div class="col-separator box" style='display: none;'
							id="no_member">
							<div class="innerAll">
								<div class="media">
									<div class="media-body innerAll half">
										<h4 class="media-heading text-large"></h4>
										<input type="hidden" id="user_log_count"
											value=" <?php echo count($user_first_login); ?>" />
											<?php $fmembr=''; foreach ($get_frst_mmbr as $fst_mmbr): ?>
											<?php $fmembr= $fst_mmbr['first_member_id'];?>
											<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="col-separator-h box"></div>
						</div>

						<div class="col-separator box" id="memberedit"></div>
						<!-- // END col-separator.box -->
						<!-- // END col-table-row -->
					</div>

					<!-- col-table -->
					<!-- // END col-table -->
				</div>
				<!-- // END main col -->
				<!--form column		-->
				<!-- // END row-app -->
			</div>
			<!-- // END col-separator -->
		</div>
		<!-- // END col -->
	</div>
	<!-- // END row-app -->
</div>
</div>
<!-- // Content END -->

											<?php $this->load->view('components/after_login_tail');?>

<!-- Global -->
<input type="hidden"
	id="test_value" />
<script type="text/template" id="tpl-header">
	
	<h4 class="margin-none innerTB pull-left">Members</h4>
							<button onclick="javascript:memberedit('',this)" class="new btn btn-xs btn-default pull-right" style="margin-top:10px;"><i class="fa fa-plus"></i> Add member <i class="fa fa-user fa-fw"></i></button>
							<div class="clearfix"></div>
</script>

<!--WINE LIST START-->
<script type="text/template" id="tpl-wine-list-item">
                        <div class="media innerAll" onclick="javascript:test('<%= id %>',this)" id="list_<%= id %>">
                                                        <button  class="pull-right btn btn-primary btn-stroke btn-xs">
														 <input type="hidden" value="<%= id %>" id="first_member_id" />
                                                            <i class="fa fa-arrow-right"></i></button>
                                                            
<% if(profile_pic) { %>
  <img src='<?php echo base_url().'profile_pic/member_pic_80/';?><%= profile_pic %>_80.<%= type %>' alt="" class="pull-left thumb" width="35">
  <% } else { %>  
<img src="<?php echo base_url().'assets/images/people/80/default_avatar_80x80.png';?>" alt="" class="pull-left thumb" width="35">
  <% } %>
								  	<div class="media-body">
								  		<h5 class="media-heading strong"><%=fname %> <%= lname %></h5>
								   		<ul class="list-unstyled">
								   	 		<!--<li><i class="fa fa-phone"></i> 0353 8473102009</li>
								    		<li><i class="fa fa-map-marker"></i> 129 Longford Terrace, Co. Dublin</li>-->
								    	</ul>
								  	</div>
								</div>
</script>
<!--WINE LIST END-->
<!--WINE DETAILS START-->
<input
	type="hidden" id="fst_mmbr" value="<?php echo $fmembr; ?>" />
<input
	type="hidden" id="fst_mmbr1"
	value="<?php echo count($user_first_login); ?>" />
<script type="text/template" id="tpl-wine-details">
    
     <!-- Default Values -->

  <div class='cancel_button_default'>
   
<input type='hidden' id='mmbr_age' value='<%= age %>' />
<input type='hidden' id='mmbr_bday'value='<%= birth_day %>' />
<input type='hidden' id='mmbr_binfo'value='<%= birth_info %>' />
<input type='hidden' id='mmbr_bmnth'value='<%= birth_month %>' />
<input type='hidden' id='mmbr_byear'value='<%= birth_year %>' />
<input type='hidden' id='mmbr_email'value='<%= email %>' />
<input type='hidden' id='mmbr_fname'value='<%= fname %>' />
<input type='hidden' id='mmbr_gndr' value='<%= gender %>' />
<input type='hidden' id='mmbr_lname' value='<%= lname %>' />
<input type='hidden' id='mmbr_months' value='<%= months %>' />
<input type='hidden' id='mmbr_profile_pic' value='<%= age %>' />
   </div>
                            <div id ="details" class="innerAll">
							<div class="media">
						
							        <button id="edit_member_details" class="pull-right btn btn-default btn-sm"><i class="fa fa-fw fa-edit"></i> Edit</button>
									<button style="display:none;" id="save_button" type="submit" class="save pull-right btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
                                    <button id="cancel_button" style="display:none;" class="cancel btn btn-primary btn-stroke pull-right">Cancel</button>  

  <% if(profile_pic) { %>
  <img src='<?php echo base_url().'profile_pic/member_pic_250/';?><%= profile_pic %>_250.<%= type %>' class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
  <% } else { %>  
  <img src="<?php echo base_url().'assets/images/people/250/default_avatar_250x250.png';?>" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
  <% } %>
                                      <div class="media-body innerAll half">
                                            <h4 class="media-heading text-large"><a id="firstname"><%= fname %></a> 
                                                    <a id="lastname"><%= lname %></a></h4>
                                                <p><a id="newgender"><%= gender %></a>
												<a id ='comma'> , </a> 
                                                <% if(age > 0 ){%>
												 <a id="newage"><%= age %> </a>
												  years old<br>
												  <!--Living in Dublin, Ireland<br>Patient 1234567890</p>-->
                                                <% }else{ %>
                                                      <%if( birth_info =='Unborn') { %>
													      <% if(months == "0 month") {%>
														   expected in less than a month 
														   <% } else {%>
													  expected in <%= months %>
													  <% } } else {%>
													           <%if(months == "0 months old"){ %>
															   <a id="newage">less than a month </a>
															    <% } else {%>
                                                  <a id="newage"><%= months %> </a>
												   <%  }  %>
												 <br><!--Living in Dublin, Ireland<br>Patient 1234567890</p>-->
                                                <%  } } %>
												
                                        </div>
							</div>			
                               </div>  
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>
								
				  <div class="details" id="for_save" style="height:100px;">
				 
								<div class="heading-buttons border-bottom innerLR">
							<h4 class="margin-none innerTB pull-left">Records</h4>
							<button onclick="javascript:report_edit('',this)" class="btn btn-xs btn-inverse pull-right">
							<i class="fa fa-plus"></i> Add records 
							<i class="fa fa-file-text-o fa-fw"></i></button>
							<div class="clearfix"></div>
						</div> 
						
						<div class="bg-gray border-bottom innerAll">
							<div class="input-group input-group-sm">
						      	<div class="input-group-btn">				        	
						          		<select id="type" style="height: 30px;font-size: 14px;">
  										<option value="title">Title</option>
  										<option value="tag">Tag's</option>
  										<option value="description">Description</option>
										</select>
						      	</div>
						      	<input type="text" id="s_box"class="form-control" placeholder="What are you searching for?" style="width: 350px; font-size: 16px;">
 								<button id="search" value="<%= id %>" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
						    </div>
						</div> 
						
					<div id="records" class="innerAll">
					
					<% _.each(rec, function(record) { %> 
					
							<div class="box-generic padding-none" id="record_delete_<%= record.id %>" style="border:1px solid #CECECE">
							
							<a class="share_demo" id="<%= record.id%>" >
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="<%= record.id%>" class="btn btn-default"><i class="fa fa-share-square-o"></i> Share</button>
								</div>
							</a>
								
								<a id="<%= record.id%>" class="report_edit_btn">
								<button id="<%= record.id%>" class="report_edit_btn btn btn-default btn-sm" style="height: 30px; margin-top: 10px; float: right;"><i class="fa fa-fw fa-edit"></i> Edit</button>
								<h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width:450px;"><%= record.title %></h5>
								</a>
			
								<div  class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i> <%= record.date %> &nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>
									<% _.each(record.recTags, function(tags) { %>  
									 <span class="label label-primary"><%= tags.tagname %></span>
									<% }); %>
								</div>
								<div id ="shared_with_<%= record.id%>">
								<% if(record.name != " ") {%>
								<div id ="shared_names" class="innerAll half border-bottom" style="background-color:#1ba0a2;">
								<i class="fa fa-share-square-o" style="padding-left: 10px; color: white;"> Shared with &nbsp;<%= record.name %></i>
								</div>
								<% } %> 
								</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									<%= record.description %>
									</p>
								</div>
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR"  style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>
										<% if(record.recImage.length == 0) {%>
										<a  class="strong text-regular">
										No Files Found </a>
										<% } else { %>

											<% _.each(record.recImage, function(recImage) { %>
												<% var file = recImage.filename.split('.') %> 
										
												<% if(file[1]=='pdf'){%>
												<a data-url='<?php echo base_url().'media_files/';?><%= recImage.filename %>' id='<%= recImage.filename %>' class="pdf_file strong text-regular" rel="media-gallery"> <%= recImage.filename %></a>,&nbsp;
												<% } %>
										
												<% if(file[1]=='jpg' || file[1]=='png' || file[1]=='bmp' || file[1]=='jpeg'|| file[1]=='gif'){%>
													<a id='<%= recImage.filename %>' class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href='<?php echo base_url().'media_files/';?><%= recImage.filename %>' rel="media-gallery" > <%= recImage.filename %></a>,&nbsp;
												<% } %>

											<% }); %>
										<% } %>
										
												</div>
												
												<div id='attachments_<%= record.id%>' style="display:none;">
												
												</div>
												
													
											</div>
											<div class="clearfix"></div>
										</div> 
									</div>
									<div class="media inline-block margin-none">
										<!--<div class="innerLR border-left">
											<i class="fa fa-bar-chart-o pull-left text-primary fa-2x"></i>
											<div class="media-body">
												<div><a href="" class="strong text-regular">Report</a></div>
												<span>244 KB</span>
											</div> 
											<div class="clearfix"></div>
										</div>-->
									</div>
								</div>
							</div>
							
				<% }); %>
						</div>	
						</div>
					
						<div class="editdetails" id="editdetails" style="display:none; height:200px" >
					
						<% if(fname == ""){%>
                                    <h4 class="innerAll margin-none bg-white">Add New Member</h4>
									 <% } else{ %>
                                    <h4 class="innerAll margin-none bg-white"> Edit Profile</h4>
                                  
						 			<% } %>					   <!-- Form -->
    <form class="form-horizontal margin-none" enctype="multipart/form-data" id="validateSubmitForm" method="post" autocomplete="off">
                                            
                                            <!-- Widget -->
                                            <div class="widget"> 
                                              <!-- Widget heading -->
                                              <div class="widget-head">
                                                <h4 class="heading"><%= fname %> <%= lname %></h4>
												<% if(fname != ""){%>
												<a href="" id='modals-bootbox-confirm'  class="">
												<h4 class="delete_link" >Delete</h4></a>
												 <% } %>
                                              </div>
                                              <!-- // Widget heading END -->
                                              <div class="widget-body innerAll inner-2x">
                                                <!-- Row -->
                                                <div class="row innerLR"> 
                                                  <!-- Column --> 
                                                  
                                                  <!-- Column -->
                                                  <div class="col-md-8">
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="firstname">First name</label>
                                                      <div class="col-md-8">
                             <input class="form-control" value="<%= fname %>" id="fname" name="fname"  type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 
                                                    
                                                    <!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="lastname">Last name</label>
                                                      <div class="col-md-8">
                                                    <input class="form-control" value="<%= lname %>" id="lname" name="lname" type="text" />
                                                      </div>
                                                    </div>
                                                    
                                                    <!-- Group -->
													<div class="form-group">
                                                      <label class="col-md-4 control-label" for="email">E-mail</label>
                                                      <div class="col-md-8">
														<% if (email !="") { %>
                                                        <input class="form-control" id="email" readonly name="email" type="text" value="<%= email %>" />
														<% } else { %>
														<input class="form-control" id="email"  name="email" type="text" value="<%= email %>" />
														<% } %>
														</div>
                                                    </div>
                                                    <!-- // Group END --> 
                                                    <?php if($this->session->userdata("usertype") == "Doctor")  { ?>
													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="education">Education</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="education" name="education" type="text" placeholder="Enter your education" value="<%= education %>" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END -->
													
													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="university_name">University name</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="university_name" name="university_name" type="text" placeholder="Enter your university name" value="<%= university_name %>" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 

													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="graduation_year">Graduation Year</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="graduation_year" name="graduation_year" type="text" placeholder="Enter your graduation year" value="<%= graduation_year %>" maxlength="4" />
													</div>
                                                    </div>
                                                    <!-- // Group END -->

													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="specialization">Specialization</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="specialization" name="specialization" type="text" placeholder="Enter your specialization" value="<%= specialization %>" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END -->
													<?php } ?>
							<div class="form-group" style="display:block"><label class="col-md-4 control-label"
								for="email">Members Photo</label>
								<div class="col-md-8">
									<div class="fileupload fileupload-new margin-none" data-provides="fileupload" id="iframe_append">
										<div class="input-group">
											<div class="form-control col-md-3"  style="border-color: #B4B4B4;><i
												class="fa fa-file fileupload-exists"></i> <span
												class="fileupload-preview"> </span></div>
											<span class="input-group-btn"> <span class="btn btn-default btn-file" style="background-color:#1BA0A2" ><span
												class="fileupload-new" style="color:#FFF"> Browse file</span> <span
												class="fileupload-exists">Change</span> 
									 <input type="file" id="file" name="userfile" onChange="fileUpload(this.form,'upload/do_upload','upload');"  class="margin-none" /></span> <a href="#"
												class="btn fileupload-exists" data-dismiss="fileupload">Remove</a> </span>
										</div>
									</div>
								</div>
							</div>
<!--upload form -->


 <!-- // Group END --> 
                                                  </div>
                                                  <!-- // Column END --> 
                                                  
                                                </div>
                                                <!-- // Row END --> 
                                                <div id="messageBox1"></div>
                                                <!-- Row -->
                                                <div class="bg-gray innerAll inner-2x">
                                                  <div class="row"> 
                                                    
                                                    <!-- Column -->
                                                    <div class="col-lg-8" >
                                                      <div class="form-group" id="genders_radio" >
                                                        <label class="col-md-4 control-label" for="gender">Gender</label>
														
                                                        <div class="col-md-8">
			                 <input value="Male" id="Male1" name="gender" class="birth_info_radio" type="radio" <%if(gender=="Male"){%> checked="checked" <%}%>>
							 <input value="Female" class="birth_info_radio" name="gender" type="radio" <%if(gender=="Female"){%> checked="checked" <%}%>>
                                                          <div class="btn-group" data-toggle="buttons" align="center" style="left:25px;">
                                                     <label <%if(gender=="Male"){%>class="btn btn-primary active"<% }else {%>class="btn btn-primary"<%}%> id="Male"><i class="fa fa-male"></i> Male <input type="radio" name="options2"> </label>
                                                            <label id="Female" <%if(gender=="Female"){%>class="btn btn-primary active"<% }else {%>class="btn btn-primary"<%}%>><i class="fa fa-female"></i> Female <input type="radio" name="options2"> </label>
                                                          </div>
														  <input class="form-control" value="<%= gender %>" id="gender12" name="gender12" type="hidden"  />
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <label class="col-md-4 control-label" for="email">Birth Detail</label>
                                                        <div class="col-md-8">
<input name="birth_info" id="Dob123" class="birth_info_radio" type="radio" value="Dob" <% if(birth_info=="Dob"){%>checked="checked" <%}%>>
<input name="birth_info"  id="Age123" class="birth_info_radio" value="Age" type="radio" <% if(birth_info=="Age"){%>checked="checked" <%}%>>
<input name="birth_info"  id="Unborn123" class="birth_info_radio" value="Unborn" type="radio" <% if(birth_info=="Unborn"){%>checked="checked" <%}%>>
                                                          <div class="btn-group births_type" data-toggle="buttons" align="center">
                                                            <label id="Dob" <%if(birth_info=="Dob"){%>class="btn btn-primary active births_detail"<% }else {%>class="btn btn-primary births_detail"<%}%>> DOB<input type="radio" name="options1"> </label>
                                                            <label id="Age" <%if(birth_info=="Age"){%>class="btn btn-primary active births_detail"<% }else {%>class="btn btn-primary births_detail"<%}%>>
                                                              
                                                              Age<input type="radio" name="options1">  </label>
                                                            <label id="Unborn" <%if(birth_info=="Unborn"){%>class="btn btn-primary active births_detail"<% }else {%>class="btn btn-primary births_detail"<%}%>>
                                                             
                                                              Unborn <input type="radio" name="options1"> </label>
                                                          </div>
                                                        </div>
                                                      </div>
													  <input name="amol" id="birth_info" value="<%= birth_info %>" type="hidden">
													  <div class="form-group" id="ub_group" <%if(birth_info=="Unborn"){%>style="display:block"<%}else{ %>style="display:none"<% } %>> 
													     <label class="col-md-4 control-label" for="dob">Unborn</label>
														  <div class="col-md-8">
                                                      <div class="col-md-4" style="width:100px;">
														 <select class="form-control" name="ub_year" id="ub_year" >
																	<option value="">Year</option>
															</select>
															<input type="hidden" value="<%= birth_year %>" id="birth_year_hid1" />
															</div>
															 <div class="col-md-4" style="width:115px;">
															 <select class="form-control" name="ub_month" id="ub_month">
																    <option value="">Month</option>
															</select>
															<input type="hidden" value="<%= birth_month %>" id="birth_month_hid1" />
															</div>
															 <div class="col-md-4" style="width:100px;">
															 <select class="form-control" name="ub_day" id="ub_day">
																    <option value="">Day</option>
															</select>
															<input type="hidden" value="<%= birth_day %>" id="birth_day_hid1" />
															</div>
                                                      </div>
													  </div>
													  
													    <div class="form-group" id="dob_group" <%if(birth_info=="Dob"){%>style="display:block"<%}else{ %>style="display:none"<% } %>> 
													     <label class="col-md-4 control-label" for="dob">DOB</label>
														  <div class="col-md-8">
                                                      <div class="col-md-4" style="width:100px;">
                                                        <input type="hidden" value="<%= birth_year %>" id="birth_year_hid" />
														 <select class="form-control" name="bd_year" id="bd_year" >
																<option value="">Year</option>
																
															</select>
															</div>
															 <div class="col-md-4" style="width:115px;">
															 <input type="hidden" value="<%= birth_month %>" id="birth_month_hid" />
															 <select class="form-control" name="bd_month" id="bd_month">
																	<option value="">Month</option>
															</select>
															
															</div>
															 <div class="col-md-4" style="width:100px;">
															 <input type="hidden" value="<%= birth_day %>" id="birth_day_hid" />
															 <select class="form-control" name="bd_day" id="bd_day">
																   <option value="">Day</option>
															</select>
															</div>
															
                                                      </div>
													  </div>
													  
													  <div class="form-group" id="age_group" <%if(birth_info=="Age"){%>style="display:block"<%}else{ %>style="display:none"<% } %>> 
													     <label class="col-md-4 control-label" for="age">Age</label>
                                                      <div class="col-md-8">
                                                       <input class="form-control" value="<%= age %>" id="ages" name="age" type="text" />
                                                      </div>
													  </div>
                                                    </div>
                                                    <!-- // Column END --> 
                                                    
                                                  </div>
                                                  <!-- // Row END --> 
                                                </div>
                                                <div class="separator"></div>  
                                              </div>
                                            </div>
                                            <!-- // Widget END -->                                            
                                          </form>
                                          <!-- // Form END --> 
                              </div>
				
							<% _.each(rec, function(record) { %>  
							     <div class = 'record_data'>
                                  <input type='hidden' id='rcdid_<%= record.id %>' value='<%= record.id %>' /> 
                                  <input type='hidden' id='rcdttl_<%= record.id %>' value='<%= record.title %>' /> 
                                  <input type='hidden' id='rcddscrptn_<%= record.id %>' value='<%= record.description %>' /> 
                                 </div>
								<div class="innerAll repoert_edit" id="repoert_edit<%=record.id%>" style="display:none">
								<div class="heading-buttons border-bottom innerLR">
							     <h4 class="margin-none innerTB pull-left">Edit Record</h4>
								  <div class="form-actions" align="right">
                                                  <a href="" id="deleterep" class="reportdelete"><h4 class="delete_link" style='float:none;'>Delete</h4></a>
                                                  <button class="cancel btn btn-primary btn-stroke">Cancel</button>	
                                                  <button type="button" id="me" class="savereports btn btn-primary">
												  <i id="rportedit" class="fa fa-check-circle"></i>
												   Save</button>
						          </div>  
								<div class="clearfix"></div>
						</div> 					 
				 <div class="widget-body innerAll inner-2x"> 
                                                
                                                <!-- Row -->
                                                <div class="row innerLR"> 
                                                  
                                                  <!-- Column --> 
                                                  <form id="reportForm" class="reportForm">
                                                  <!-- Column -->
                                                  <div class="col-md-8">
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="title">Title</label>
                                                      <div class="col-md-8">
      <% var i=0; var tagname=''; _.each(record.recTags, function(tags) {  %>  
									 <% i++; tagname+=(i==record.recTags.length)?tags.tagname:tags.tagname+',' %>
									<%  });%>   
<input type='hidden' id='rcdtgs_<%= record.id  %>' value='<%= tagname %>' />
<input class="title form-control"  maxlength="50" value="<%= record.title %>" tabindex=1 id="title<%= record.id %>" name="title" type="text" style="margin-bottom:10px;"/>

                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 
<% if(tagname!=""){ %>
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="tags">Tags</label>
                                                      <div class="col-md-8" style="margin-bottom:10px;">

     <input type="hidden" id="select2_5_<%= record.id %>"  class="tags" tabindex=2 style="width: 100%;" value="<%= tagname %>" />
                                                      </div>
                                                    </div>
													<% } else { %>
 <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="tags">Tags</label>
                                                      <div class="col-md-8" style="margin-bottom:10px;">
     <input type="hidden" id="select2_5_<%= record.id %>" tabindex = 2 class="tags" style="width: 100%;"/>
  </div>
                                                    </div>
    <% } %>

												<div class="separator bottom"></div>
                                                    <!-- Group -->
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="description">Description</label>
                                                      <div class="col-md-8">
                                             <textarea type="text" class="form-control" tabindex=4 maxlength="500" id="description<%= record.id %>" name="description" style="margin-bottom:10px; color: #A7A7A7; max-height:150px; max-width:100%;"><%= record.description %></textarea>
                                                      </div>
                                                    </div>
                                                  <input type="hidden" value="<%= id %>" name="memberid" id="memberid" />
												     <!-- Group -->
												   <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="description">Previous Files</label>
                                                      <div class="col-md-8" style="margin-bottom:10px;" id="prev_files_<%= record.id %>">
													   <% _.each(record.recImage, function(recImage) { %>
													   <% var file = recImage.filename.split('.') %> 
													 
													 <% if( file[1] == 'pdf'){ %>
													<div class="show-image" id="file_<%= recImage.id %>" value="<%= recImage.filename %>" style="float: left; width:100px;">
													
					<a class="gallery-images" href='<?php echo base_url().'member/media_files/';?><%= recImage.filename %>' target='_blank'>
                    <img src="<?php echo base_url().'assets/images/screenshots/pdf_icon.png';?>" style="height:100px; width:100%" width="100" height="100" alt=""> 					
					<span class="bg-images" id="<%= recImage.filename %>">
					<button data-rec_id=<%= record.id %> data-mem_id=<%= id %> class="remove_file" id="filename" value="<%= recImage.filename %>" style="float: right; border: none; background-color: transparent;">
					<i id="<%= recImage.filename %>" class="fa fa-times-circle" style="float:right"></i></button></span>
                    </a>							</div>
													<% } %> 
													  <% if( file[1] == 'png' || file[1] == 'gif' || file[1] == 'jpg' || file[1] == 'jpeg' || file[1] == 'bmp'){ %>
												   
												  	<div class="show-image-one" id="file_<%= recImage.id %>" value="<%= recImage.filename %>" style="float: left; width:100px;">
					<a class="gallery-images" href='<?php echo base_url().'member/media_files/';?><%= recImage.filename %>' target='_blank'>
                    <img src="<?php echo base_url().'media_files/';?><%= recImage.filename %>" style="height:100px; width:100%" width="100" height="100" alt=""> 
                    <span class="bg-images" id="<%= recImage.filename %>">
					<button data-rec_id=<%= record.id %> data-mem_id=<%= id %> class="remove_file" id="filename" value="<%= recImage.filename %>" style="float: right; border: none; background-color: transparent;">
					<i id="<%= recImage.filename %>" class="fa fa-times-circle" style="float:right"></i></button></span> 
                    </a>
                                              
													</div>
												  <% } %>  
												   <!-- <% if( file[1] == 'xlsx' || file[1] == 'xls'){ %>
												   <a href='<?php echo base_url().'member/media_files/';?><%= recImage.filename %>' target='_blank'> 
												  <img id='<%= file[1] %>' src="<?php echo base_url().'media_files/default.png';?>" style="width:100px; height:100px;">			  
                                                   </a>  
												  <% } %>
												   <% if( file[1] == 'doc' || file[1] == 'docx' || file[1] == 'rtf' || file[1] == 'txt'){ %>
												   <a href='<?php echo base_url().'member/media_files/';?><%= recImage.filename %>' target='_blank'> 
												  <img id='<%= file[1] %>' src="<?php echo base_url().'media_files/default.png';?>" style="width:100px; height:100px;">			  
                                                   </a>  
												  <% } %> 
												    
												   <% if( file[1] == 'ppt' || file[1] == 'pptx'){ %>
												   <a href='<?php echo base_url().'member/media_files/';?><%= recImage.filename %>' target='_blank'> 
												  <img id='<%= file[1] %>' src="<?php echo base_url().'media_files/default.png';?>" style="width:100px; height:100px;">			  
                                                   </a>  
												  <% } %>  --> 
												    <% }); %>
												   </div>
                                                    </div>
												
		                                     <!-- // Group END --> 
                                                   <div class="separator"></div>
                                                
                                                <!-- Form actions -->
                                               
                                                  </div>
												  </form>
												  <div class="col-md-8">
										
										 <div class="form-group" style="margin-bottom:10px;">
										
                                                      <label class="col-md-4 control-label" for="File">Upload Files</label>
													 <label class="col-md-4 control-label" for="File"></label>
								                    <div class="col-md-8">
 													<div id="upload_err_msg" class="upload_err_msg" class="col-md-8"></div>

												  <div id="dropzone">
												<!-- The global file processing state -->
        											<span class="fileupload-process">
          												<div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="display: none; border-radius: 10px;">
            												<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          												</div>
        											</span>
      											</div>
												<!-- Scroll bar present but disabled on dropzone -->
													<div style="height: 200px; overflow-y: auto; overflow-x: hidden;">
                                           <form action="<?php echo base_url().'member/upload_records';?>" class="dropzone" id="demo-upload" >
                                                
												<div class="fallback">
                                                    <input name="file" type="file" multiple />
                                                </div>
												</div> 
                                            </form>
											 </div>
								<!--			 <div id="upload_err_msg" class="upload_err_msg"></div> -->
                                        </div>	
										 </div>
                                     </div>
			                               
                                                </div>
                                              </div>
						             </div>
						    <% }); %>
							    <!-- New record  -->
									 
									 <div class="innerAll repoert_edit" id="repoert_edit" style="display:none;">
								<div class="heading-buttons border-bottom innerLR">
							<h4 class="margin-none innerTB pull-left">Add New Record</h4>
							 <div class="form-actions" align="right">
                                                  <button class="cancel btn btn-primary btn-stroke">Cancel</button>	
                                                  <button type="button" id ="new_report" class="savereportsnew btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> 
												</div>  
							<div class="clearfix"></div>
						</div> 					 
				 <div class="widget-body innerAll inner-2x"> 
                                                
                                                <!-- Row -->
                                                <div class="row innerLR"> 
                                                  <!-- Column --> 
                                                  <form id="reportForm_new" class="reportForm_new">
                                                  <!-- Column -->
                                                  <div class="col-md-8">
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="firstname">Title</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" maxlength="50" value="" id="title" tabindex=1 name="title" type="text" style="margin-bottom:10px;"/>
														
                                                      </div>
													<label class="col-md-4 control-label" for="firstname"></label>
 													<div class="col-md-8" style="margin-bottom:10px;font-size: 13px;color: #777777;">
                                                            Add a title to your record
														
                                                      </div>
																									
                                                    </div>
																										
                                                    <!-- // Group END --> 
                                                       <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="tags">Tags</label>
                                                      <div class="col-md-8" style="margin-bottom:10px;">
                                 <input type="hidden" tabindex=2 id="select2_5" class="tags" style="width: 100%;" value="" />
                                                      </div>
                                                    </div>
													<label class="col-md-4 control-label" for="tags"></label>
													<div class="form-group" style="margin-bottom:10px;font-size: 13px;color: #777777; left: 5px;">
																	Add tags E.g Dental, Vision, Annual checkup
													</div>
												<div class="separator bottom"></div>
                                                    <!-- Group -->
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4  control-label" for="description">Description</label>
                                                      <div class="col-md-8">
                                                        <textarea type="text" tabindex=3 maxlength="500" class="form-control" value="" id="description" name="description" style="margin-bottom:10px;color: #A7A7A7; max-height:150px; max-width:100%; border-color: #b4b4b4;" /></textarea>
                                                      </div>
                                                    </div>
													<label class="col-md-4  control-label" for="description"></label>
                                                      <div class="col-md-8" style="margin-bottom:10px;font-size: 13px;color: #777777;">
														Add a description to your record
													</div>
                                                  <input type="hidden" value="<%= id %>" name="memberid" id="memberid" />
                                                    <!-- Group -->
					 </div>                                       
		 <!-- // Group END --> 
                                                   <div class="separator"></div>
                                                
                                                <!-- Form actions -->
                                               
                                                  </div>
												  </form>
												  
												   <div class="col-md-8">
										 <div class="form-group" style="margin-bottom:10px;">
                                                      <label class="col-md-4 control-label" for="File">Upload File</label>
                                                      <div class="col-md-8">	
													<div id="upload_err_msg" class="upload_err_msg" class="col-md-8" ></div>  
												  <div id="dropzone">
												<!-- The global file processing state -->
        											<span class="fileupload-process">
          												<div id="total-progress-add" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="display: none; border-radius: 10px;">
            												<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          												</div>
        											</span>
      											</div>
													<!-- Scroll bar present but disabled on dropzone -->
													<div style="width: 337px; height: 200px; overflow-y: auto; overflow-x: hidden;">
                                            <form action="<?php echo base_url().'member/upload_records';?>" class="dropzone" id="demo-upload">
                                                <div class="fallback">
                                                    <input name="file" id="file_upload" type="file" multiple />
                                                </div>
												</div>
                                            </form>
											 </div>
											
											<label class="col-md-4 control-label" for="File"></label>
											<div class="col-md-8" style="right: 0px;font-size: 13px;color: #777777;">
											JPEG, JPG, PNG, GIF, BMP, PDF
											</div>

								<!--			  <div class="upload_err_msg" id="upload_err_msg"></div> -->
                                        </div>	
										 </div>
                                                    </div>
			                               
												  
                                                </div>
                                              </div>
						             </div>
						</div>	
							   <input type="hidden" value="" id="delete_report" />
							   <input type="hidden" id="selected_tag" name="selected_tag"/>
                                <input type="hidden" id="tagname_delete" name="tagname_delete"/>
                  </script>
<input
	type="hidden" id="save_button_val" name="save_button"
	class="save_button" />
<input
	type="hidden" id="recordid" name="recordid" class="recordid" />
<input type="hidden"
	id="member_id_list_colour" name="member_id_color"
	class="member_id_color" />

<!--WINE DETALS END-->
<!--WINE EDIT START-->


<script type="text/template" id="tpl-add-view"> 
     <div class="innerAll">
							<div class="media">
                                  <button id="save_button" type="submit" class="save_add pull-right btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
                                  <button id="cancel_btn" class="cancel btn btn-primary btn-stroke pull-right">Cancel</button>	
  <img src="<?php echo base_url().'assets/images/people/250/default_avatar_250x250.png';?>" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">

                                        <div class="media-body innerAll half">
                                            <h4 class="media-heading text-large"><a id="firstname1"></a>  <a id="lastname1"></a></h4>
                                                <p><a id="newgender"></a>
                                        </div>
							</div>			
                               </div>  
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>
                                    <h4 class="innerAll margin-none bg-white">Add New Member</h4>
											   <!-- Form -->
    <form class="form-horizontal margin-none" enctype="multipart/form-data" id="validateSubmitForm_add" method="post">
                                            <!-- Widget -->
                                            <div class="widget"> 
                                              <!-- Widget heading -->
                                              <div class="widget-head">
                                                <h4 class="heading"></h4>
												
                                              </div>
                                              <!-- // Widget heading END -->
                                              <div class="widget-body innerAll inner-2x">
                                                <!-- Row -->
                                                <div class="row innerLR"> 
                                               
                                                  <!-- Column -->
                                                  <div class="col-md-8">
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="firstname">First name</label>
                                                      <div class="col-md-8">
                             <input class="form-control"  id="fname1" placeholder="Enter your first name" name="fname"  type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 
                                                    
                                                    <!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="lastname">Last name</label>
                                                      <div class="col-md-8">
                                                    <input class="form-control" id="lname1" placeholder="Enter your last name" name="lname" type="text" />
                                                      </div>
                                                    </div>
                                                    
                                                    <!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="email">E-mail</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="email1" placeholder="Enter your email" name="email" type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 
                                                     <?php if($this->session->userdata("usertype") == "Doctor")  { ?>
													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="education">Education</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="education1" placeholder="Enter your education" name="education" type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END -->
													
													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="university_name">University name</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="university_name1" placeholder="Enter your university name" name="university_name" type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END --> 

													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="graduation_year">Graduation Year</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="graduation_year1" placeholder="Enter your graduation year" name="graduation_year" type="text" maxlength="4" />
													</div>
                                                    </div>
                                                    <!-- // Group END -->

													<!-- Group -->
                                                    <div class="form-group">
                                                      <label class="col-md-4 control-label" for="specialization">Specialization</label>
                                                      <div class="col-md-8">
                                                        <input class="form-control" id="specialization1" placeholder="Enter your specialization" name="specialization" type="text" />
                                                      </div>
                                                    </div>
                                                    <!-- // Group END -->
													<?php } ?>
<div class="form-group" style="display:block"><label class="col-md-4 control-label"
								for="email">Members Photo</label>
								<div class="col-md-8">
									<div class="fileupload fileupload-new margin-none" data-provides="fileupload" id="iframe_append">
										<div class="input-group">
											<div class="form-control col-md-3"  style="border-color: #B4B4B4;><i
												class="fa fa-file fileupload-exists"></i> <span
												class="fileupload-preview"> </span></div>
											<span class="input-group-btn"> <span class="btn btn-default btn-file" style="background-color:#1BA0A2" ><span
												class="fileupload-new" style="color:#FFF"> Browse file</span> <span
												class="fileupload-exists">Change</span> 
									 <input type="file" id="file1" name="userfile" onChange="fileUpload(this.form,'upload/do_upload','upload');"  class="margin-none" /></span> <a href="#"
												class="btn fileupload-exists" data-dismiss="fileupload">Remove</a> </span>
										</div>
									</div>
								</div>
							</div>

 <!-- // Group END --> 
                                                  </div>
                                                  <!-- // Column END --> 
                                                  
                                                </div>
                                                <!-- // Row END --> 
                                                <div id="messageBox1"></div>
                                                <!-- Row -->
                                                <div class="bg-gray innerAll inner-2x">
                                                  <div class="row"> 
                                                    
                                                    <!-- Column -->
                                                    <div class="col-lg-8" >
                                                      <div class="form-group" id="genders_radio" >
                                                        <label class="col-md-4 control-label" for="gender">Gender</label>
														
                                                        <div class="col-md-8">
			                 <input value="Male" id="Male1" name="gender" class="birth_info_radio" type="radio" >
							 <input value="Female" class="birth_info_radio" name="gender" type="radio" >
                                                          <div class="btn-group" data-toggle="buttons" align="center" style="left:25px;">
                                                     <label class="btn btn-primary"id="Male"><i class="fa fa-male"></i> Male <input type="radio" name="options2"> </label>
                                                            <label id="Female" class="btn btn-primary"><i class="fa fa-female"></i> Female <input type="radio" name="options2"> </label>
                                                          </div>
														  <input class="form-control"  id="gender12" name="gender12" type="hidden"  />
                                                        </div>
                                                      </div>
                                                      <div class="form-group" >
                                                        <label class="col-md-4 control-label" for="">Birth Detail</label>
                                                        <div class="col-md-8">
<input name="birth_info" id="Dob1231" class="birth_info_radio" type="radio" value="Dob" >
<input name="birth_info"  id="Age1231" class="birth_info_radio" value="Age" type="radio" >
<input name="birth_info"  id="Unborn1231" class="birth_info_radio" value="Unborn" type="radio">
                                                          <div class="btn-group births_type" data-toggle="buttons" align="center">
                                                            <label id="Dob" class="btn btn-primary births_detail"> DOB<input type="radio" name="options1"> </label>
                                                            <label id="Age" class="btn btn-primary births_detail">
                                                              
                                                              Age<input type="radio" name="options1">  </label>
                                                            <label id="Unborn" class="btn btn-primary births_detail">
                                                             
                                                              Unborn <input type="radio" name="options1"> </label>
                                                          </div>
                                                        </div>
                                                      </div>
													  <input name="" id="birth_info1" type="hidden">
													  <div class="form-group" id="ub_group1" style="display:none"> 
													     <label class="col-md-4 control-label" for="dob">Unborn</label>
														  <div class="col-md-8">
                                                      <div class="col-md-4" style="width:100px;">
                                                        
														 <select class="form-control" name="ubn_year" id="ubn_year" >
																
																	<option value="">Year</option>
															</select>
															<input type="hidden" id="birth_year_hid" />
															</div>
															 <div class="col-md-4" style="width:115px;">
															 <select class="form-control" name="ubn_month" id="ubn_month">
																    <option value="">Month</option>
															</select>
															<input type="hidden" id="birth_month_hid" />
															</div>
															 <div class="col-md-4" style="width:100px;">
															 <select class="form-control" name="ubn_day" id="ubn_day">
																    <option value="">Day</option>
															</select>
															<input type="hidden" id="birth_day_hid" />
															</div>
															
                                                      </div>
													  </div>
													  
													    <div class="form-group" id="dob_group1" style="display:none"> 
													     <label class="col-md-4 control-label" for="dob">DOB</label>
														  <div class="col-md-8">
                                                      <div class="col-md-4" style="width:100px;">
                                                        
														 <select class="form-control" name="bdn_year" id="bdn_year" >
																<option value="">Year</option>
																
															</select>
															</div>
															 <div class="col-md-4" style="width:115px;">
															 <select class="form-control" name="bdn_month" id="bdn_month">
																	<option value="">Month</option>
															</select>
															
															</div>
															 <div class="col-md-4" style="width:100px;">
															 <select class="form-control" name="bdn_day" id="bdn_day">
																   <option value="">Day</option>
															</select>
															</div>
															
                                                      </div>
													  </div>
													  
													  <div class="form-group" id="age_group1" style="display:none"> 
													     <label class="col-md-4 control-label" for="age">Age</label>
                                                      <div class="col-md-8">
                                                       <input class="form-control" id="ages1" name="age" type="text" />
                                                      </div>
													  </div>
                                                    </div>
                                                    <!-- // Column END --> 
                                                    
                                                  </div>
                                                  <!-- // Row END --> 
                                                </div>
                                                <div class="separator"></div>  
                                              </div>
										
												<div style="padding-right: 11px;">
											 		<button id="save_button" class="save pull-right btn btn-primary" style="margin-top: 10px;"><i class="fa fa-check-circle"></i> Save</button>
         	                  					   <button id="cancel_btn" type="button" class="cancel btn btn-primary btn-stroke pull-right" style="margin-right: 10px; margin-top: 10px;">Cancel</button>
												</div>
									
                                            </div>
                                            <!-- // Widget END -->                                            
                                          </form>
                                          <!-- // Form END --> 
</script>

<!-- JavaScript -->
<form id="fileuploadfrm">
	<input type="file" name="datafile"
		onChange="fileUpload(this.form,'upload.php','upload'); return false;"
		id="datafile" /></br> <input type="button" value="uploadImage"
		onClick="fileUpload(this.form,'upload.php','upload'); return false;">
	<div id="upload"></div>
</form>
<input type="hidden" value=''
	id="users_tag1" />

<div style="margin: 0px auto; width: 1012px">
	<div id="light" class="white_content">
		<div id="page_content"></div>
		<a href="javascript:void(0)" onclick="javascript:close_lightbox();"
			class="close"></a>
	</div>
</div>
<div
	id="fade" class="black_overlay" onclick="javascript:close_lightbox();"></div>

