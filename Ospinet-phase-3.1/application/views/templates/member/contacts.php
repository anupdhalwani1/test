<?php
$this->load->view('components/after_login_head'); ?>
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

	</ul>
	<ul class="main pull-right visible-lg">
		<!--<li><a href="">Close <i class="fa fa-fw fa-times"></i></a></li>-->
	</ul>
	<ul class="colors pull-right hidden-xs">

		<!--<li class="active"><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=style-default" style="background-color: #eb6a5a"><span class="hide">style-default</span></a></li>
				<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=green" style="background-color: #87c844"><span class="hide">green</span></a></li>
				<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=coral" style="background-color: #7eccc2"><span class="hide">coral</span></a></li>
		
		<li class="dropdown">
			<a href="" data-toggle="dropdown" class="dropdown-toggle">
				<span class="color inverse"></span>
				<span class="color danger"></span>
				<span class="color success"></span>
				<span class="color info"></span>
			</a>
			<ul class="dropdown-menu pull-right">
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=alizarin-crimson"><span class="color" style="background-color: #F06F6F"></span> alizarin-crimson</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=blue-gray"><span class="color" style="background-color: #7293CF"></span> blue-gray</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=brown"><span class="color" style="background-color: #d39174"></span> brown</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=purple-gray"><span class="color" style="background-color: #AF86B9"></span> purple-gray</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=purple-wine"><span class="color" style="background-color: #CC6788"></span> purple-wine</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=green-army"><span class="color" style="background-color: #9FB478"></span> green-army</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=black-and-white"><span class="color" style="background-color: #979797"></span> black-and-white</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=amazon"><span class="color" style="background-color: #8BC4B9"></span> amazon</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=amber"><span class="color" style="background-color: #CACA8A"></span> amber</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=android-green"><span class="color" style="background-color: #A9C784"></span> android-green</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=antique-brass"><span class="color" style="background-color: #B3998A"></span> antique-brass</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=antique-bronze"><span class="color" style="background-color: #8D8D6E"></span> antique-bronze</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=artichoke"><span class="color" style="background-color: #B0B69D"></span> artichoke</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=atomic-tangerine"><span class="color" style="background-color: #F19B69"></span> atomic-tangerine</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=bazaar"><span class="color" style="background-color: #98777B"></span> bazaar</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=bistre-brown"><span class="color" style="background-color: #C3A961"></span> bistre-brown</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=bittersweet"><span class="color" style="background-color: #d6725e"></span> bittersweet</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=blueberry"><span class="color" style="background-color: #7789D1"></span> blueberry</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=bud-green"><span class="color" style="background-color: #6fa362"></span> bud-green</a></li>
								<li><a href="?module=admin&page=medical_patients&url_rewrite=&build=&v=v1.9.5&sidebar_type=discover&skin=burnt-sienna"><span class="color" style="background-color: #E4968A"></span> burnt-sienna</a></li>
							</ul>
		</li>-->
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
							id="list_of_contacts">
							<div class="heading-buttons border-bottom innerLR"
								id="add_new_contacts"></div>
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
							<div id="contactslist"></div>
						</div>
						<!-- // END col-separator.box -->
					</div>
					<!-- // END col -->
					<!-- col -->
					<!--main column		-->
					<div class="col-lg-9 showdetails">
						<!-- col-separator.box -->

						<div class="col-separator box" id="contactdetails"></div>
						<div class="col-separator box" style='display: none;' id="contact">
							<div class="innerAll">
								<div class="media">
									<div class="media-body innerAll half">
										<h4 class="media-heading text-large"></h4>

									</div>
								</div>
							</div>
							<div class="col-separator-h box"></div>
						</div>

						<div class="col-separator box" id="memberedit"></div>
						<div class="col-separator box" id="addcontacts"></div>
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

<?php $this->load->view('components/after_login_tail'); ?>

<!-- Global -->
<input type="hidden"
	id="test_input" />
<script type="text/template" id="tpl-contact-header">
	
	<h4 class="margin-none innerTB pull-left">Contacts</h4>
							<button class="new_contacts btn btn-xs btn-default pull-right" style="margin-top:10px;"><i class="fa fa-plus"></i> Add contacts <i class="fa fa-user fa-fw"></i></button>
							<div class="clearfix"></div>
							
</script>

<!-- CONTACTS LIST START-->
<script type="text/template" id="tpl-contacts-list-item">

                        <div class="media innerAll active " onclick="javascript:contacts('<%= id %>',this)" id="list_<%= id %>">
														 <button  class="pull-right btn btn-primary btn-stroke btn-xs">
														 <input type="hidden" value="<%= id %>" id="contact_id" />
                                                            <i class="fa fa-arrow-right"></i></button>
                                                            
  <% if(profile_pic) { %>
<img src='<?php
echo base_url() . 'profile_pic/member_pic_80/'; ?><%= profile_pic %>_80.<%= type %>' alt="" class="pull-left thumb" width="35">
  <% } else { %>  
<img src="<?php
echo base_url() . 'assets/images/people/80/default_avatar_80x80.png'; ?>" alt="" class="pull-left thumb" width="35">
  <% } %>                                                
								  	<div class="media-body">
								  		<h5 class="media-heading strong"><%=fname %> <%= lname %></h5>
								   		<ul class="list-unstyled">
									    	</ul>
								  	</div>
								</div>
</script>

<!--WINE LIST END-->
<!--WINE DETAILS START-->
<script type="text/template" id="tpl-contacts-details">

     <!-- Default Values -->
<input type="hidden" value="<%= id %>" id="cont_id" />
                            <div id="details" class="innerAll">
							<div class="media">
						        						
  <% if(profile_pic) { %>
  <img src='<?php
echo base_url() . 'profile_pic/member_pic_250/'; ?><%= profile_pic %>_250.<%= type %>' class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
  <% } else { %>  
  <img src="<?php
echo base_url() . 'assets/images/people/250/default_avatar_250x250.png'; ?>" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
  <% } %>          
                             <div class="media-body innerAll half">
                                            <h4 class="media-heading text-large"><%= fname %></a> 
                                                    <%= lname %></a></h4>
                                                <p><a id="contcts_gender"><%= gender %><a id ='comma'> , <id="contacts_age"> <%= age %></a> years old</a>
												<p><a id ='contacts_email'><%= email %></a> 
                                               												
                                        </div>
							</div>			
                               </div>  
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>


			
			<div form class="shared records" id="shared_records" >
<% if(records != "") {%>
			<h4 class="innerAll margin-none bg-white">Shared Records</h4>
			<div class="col-separator-h box" style="height: 1px;"></div>
			</div>

<div class="innerAll">
<% _.each(records, function(record) { %>
<div class="box-generic padding-none" style="border:1px solid #CECECE">
<a id="<%= record.member_record_id%>" class="report_edit_btn"><h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1;"><%= record.title %>
								</h5>
								</a>
			
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i> <%= record.date %> &nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>
									<% _.each(record.tags, function(tag) { %>  
									 <a id="<%= tag.tagid %>" span class="label label-primary"><%= tag.tagname %></span></a>
									<% }); %>
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
										<% if(record.files.length == 0) {%>
										<a  class="strong text-regular">
										No Files Found </a>
										<% } %>
										<% _.each(record.files, function(Image) { %>
										  <% var file = Image.filename.split('.') %> 

										<% if(record.files.length != 0 && file[1]=='jpg' || file[1]=='png' || file[1]=='bmp' || file[1]=='jpeg'|| file[1]=='gif'){%>
										<a id="<%= record.member_record_id %>" class="strong text-regular dwnlds">
										<%= Image.filename %>, </a>
										<% } %>
										  
										  <% if(file[1]=='pdf'){%>
										  <a data-url='http://docs.google.com/gview?url=<?php echo base_url().'media_files/';?><%= Image.filename %>&embedded=true' id='<%= Image.filename %>' class="pdf_share strong text-regular"> <%= Image.filename %></a>,&nbsp;										  
										  <% } %>
										<% if(file[1]=='jpg' || file[1]=='png' || file[1]=='bmp' || file[1]=='jpeg'|| file[1]=='gif'){ %>
										  <a data-title="<%= Image.filename %>" href='<?php echo base_url() . 'media_files/'; ?><%= Image.filename %>' data-lightbox="roadtrip_<%= Image.member_record_id%>"  class='mytest strong text-regular'>
										 </a>
										 <% } %>
										<% }); %>
										
												</div>
												
												<div id='attachments_<%= record.id %>' style="display:none;">
												
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
<% } %>
</script>
<input type="hidden"
	id="save_button_val" name="save_button" class="save_button" />
<input
	type="hidden" id="recordid" name="recordid" class="recordid" />
<input type="hidden"
	id="member_id_list_colour" name="member_id_color"
	class="member_id_color" />

<!--WINE DETALS END-->
<!--WINE EDIT START-->

<!-- <script type="text/template" id="tpl-shared-record-view">
<div class="innerAll">

</div>
</div>
</script> -->

<script type="text/template" id="tpl-search-list-item">
         <div class="media innerAll" style="width: 392px; float: left;" >
			<div class="box-generic" style="width: 373px; border-color: #B4B4B4;">			
               	<div class="media">
					<% if(profile_pic){%>
					<a class="pull-left" href="#"><img src='<?php
echo base_url() . 'profile_pic/member_pic_80/'; ?><%= profile_pic %>_80.<%= type %>' class="media-object thumb" alt="50x50" width="61"></a>
					<%} else {%>
		          	<a class="pull-left" href="#"><img src="<?php
echo base_url() . 'assets/images/people/80/default_avatar_80x80.png'; ?>" class="media-object thumb" alt="50x50" width="61"></a>
			      	<%	}%>
					<div class="media-body" style="height: 55px; width: 280px;">	
					<% if(ns=="pending"){%>
								<button type="button" id="request_sent"  class="send_request savereports btn btn-primary" style="float: right; background-color: white;color: gray;">
							Request Pending</button>
					<%} else {%>
								<button type="button" onclick="javascript:send_request('<%= id %>',this)" id="send_request_clicked" class="send_request savereports btn btn-primary" style="float: right;">
							Send Request</button>
					<%	}%>
			            	<h5 class="media-heading" style="height: 30px;"><%= fname %> <%= lname %></h5>
						<p><%= email %></p>
			        </div>
		        </div>
			</div>
		</div>
</script>

<script type="text/template" id="tpl-add-contact-view">
<div id="add"> 
     <div class="innerAll">
							<div class="media">
 <img src="<?php
echo base_url() . 'assets/images/people/250/default_avatar_250x250.png'; ?>" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;"> 

  <!--                            	<div>
         	                  		<button id="cancel_btn" type="button" class="cancel btn btn-primary btn-stroke pull-right" style="margin-right: 10px; margin-top: 10px;">Cancel</button>
								</div>         --> 
							</div>			
     </div>  
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>


		<div form class="Search box" id="search_box" >
		
 			<h4 class="innerAll margin-none bg-white">Search Contacts to Add</h4>
	
				<div class="bg-gray border-bottom innerAll">
							<div class="input-group innerL">
						      	<div class="input-group-btn">
									<input class="form-control input-sm" id="sbox" type="text" name="name" autofocus placeholder="Type a email you looking for?" style="height: 35px; width: 680px; font-size: 18px;"></input>
						      	</div>
								<button type="submit" id="find" class="savereports btn btn-primary" style="float: left; margin-left: 15px;">
								<i id="Search_member" class="fa fa-search"></i>
								Search</button>
						    </div>
				</div>
		
		</div>

	<div form class="Search result" id="search_result" >

	</div>
	
	<div form class="No result" id="result_not_found" style="text-align: center;" >
	&nbsp;&nbsp;&nbsp;<h1>Sorry... no result found.</h1>
	</div>
</div>
</script>
