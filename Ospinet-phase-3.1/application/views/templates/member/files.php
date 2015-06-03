<!-- Add mousewheel plugin (this is optional) -->
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/lib/jquery.mousewheel-3.0.6.pack.js';?>"></script>

<!-- Add fancyBox main JS and CSS files -->
<script
	type="text/javascript"
	src="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/jquery.fancybox.js?v=2.1.5';?>"></script>
<link rel="stylesheet"
	href="<?php echo base_url().'fancyapps-fancyBox-18d1712/source/jquery.fancybox.css?v=2.1.5';?>"
	type="text/css" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet"
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
<?php $this->load->view('components/after_login_head'); ?>
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
					<div class="col-lg-5">
						<!-- col-separator.box -->

						<div class="col-separator col-separator-first box"
							id="list_of_files">
							<div class="heading-buttons border-bottom innerLR"
								id="add_new_file"></div>

							<div id="filelist"></div>
						</div>
						<!-- // END col-separator.box -->
					</div>
					<!-- // END col -->
					<!-- col -->
					<!--main column		-->
					<div class="col-lg-7 showdetails">
						<!-- col-separator.box -->

						<div class="col-separator box" id="filesdetails"></div>
						<div class="col-separator box" style='display: none;' id="file">
							<div class="innerAll">
								<div class="media">
									<div class="media-body innerAll half">
										<h4 class="media-heading text-large"></h4>

									</div>
								</div>
							</div>
							<div class="col-separator-h box"></div>
						</div>
						<div class="col-separator box" id="addfile"></div>
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
<input type="hidden" id="test_input" />
<script type="text/template" id="tpl-file">
	
	<h4 class="margin-none innerTB pull-left">Files</h4>
							<button class="new_files btn btn-xs btn-default pull-right" style="margin-top:10px;"><i class="fa fa-plus"></i> Create File <i class="fa fa-folder"></i></button>
							<div class="clearfix"></div>
							
</script>

<!-- FILES LIST START-->
<script type="text/template" id="tpl-files-list-item">

<div class="active" id="filelist" onclick="javascript:files('<%= id %>',this)" id="file_<%= id %>style="width: 90px;"height: 90px;">

<div class="innerAll" style="width: 90px; float: left;padding-left: 8px;height: 110px;" >
<button  class="btn-primary btn-stroke btn-xs">
<input type="hidden" value="<%= id %>" id="file_id" />
<img src="<?php echo base_url() .'assets/images/file_image/file.png'; ?>"id="file_<%= id %>" class="pull-left thumb" width="70">
<%= file_name %>					
</button>
			</div>
		</div>                                              
</script>

<!--FILE LIST END-->
<!--FILE DETAILS START-->
<script type="text/template" id="tpl-files-details">

     <!-- Default Values -->
<input type="hidden" value="<%= id %>" id="cont_id" />
                            <div id="details" class="innerAll">
							<div class="media">
						        						
<img src='<?php echo base_url() . 'assets/images/file_image/file.png'; ?>'class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
 							
							<a class="remove_file" fileid="<%= id %>" memid="<%= member_id %>">
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="<%= id %>" class="btn btn-default" style="color: brown;"><i class="fa fa-trash-o"></i> Delete File</button>
								</div>
							</a>

							<a class="share_file" id="<%= id%>" >
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
									<button id="<%= id%>" class="btn btn-default"><i class="fa fa-share-square-o"></i> Share</button>
								</div>
							</a>
            
                             <div class="media-body innerAll half">
                             <h4 class="media-heading text-large"><%= file_name %></a></a></h4>
 							</div>
							</div>			
                               </div> 
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>

<h4 class="innerAll margin-none bg-white">File Records</h4>

<% if(records != "") {%>
<% _.each(records, function(record) { %>
<% _.each(record, function(rec) { %>
<div class="box-generic padding-none" id="record_<%= rec.id%>" style="border:1px solid #CECECE">

							<a class="remove_record" id="<%= rec.id%>" file_id="<%=id%>" mem_id="<%=member_id%>">
								<div class="btn-sm pull-right" style="height: 30px; margin-top: 5px;">
								<button id="<%= rec.id%>" class="btn btn-default" style="color: brown;"><i class="fa fa-trash-o"></i></button>
								</div>
							</a>

<a id="<%= rec.id%>" class="report_edit_btn"><h5 class="record_title strong margin-none innerAll border-bottom" style="line-height:2.1; width: 570px;"><%= rec.title %>
								</h5>
								</a>
			
								<div class="innerAll half border-bottom" style="background-color:#EFEFEF;">
									<i class="fa fa-calendar fa-fw text-primary"></i> <%= record.date %> &nbsp;
									<i class="fa fa-tag fa-fw text-primary"></i>
 									<% if(rec.tags !="") {%>
									<% _.each(rec.tags, function(tag) { %>
									<a id="<%= tag.tagid %>" span class="label label-primary"><%= tag.tagname %></span></a>
									<% }); %>
									<% } %>
								</div>
								<div class="innerAll">
									<p class="margin-none innerAll"><i class="fa fa-quote-left fa-2x pull-left"></i> 
									<%= rec.description %>
									</p>
								</div>
								<div class="innerLR innerT half bg-primary-light border-top">
									<!--<button class="btn btn-primary pull-right"><i class="fa fa-sign-in"></i></button>-->
									<div class="media inline-block margin-none">
										<div class="innerLR"  style="position:static;">
											<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
											<div class="media-body">
										<div>

										<% if(rec.files =="") {%>
										<a  class="strong text-regular">
										No Files Found </a>
										<% } else { %>

											<% _.each(rec.files, function(files) { %>
												<% var file = files.filename.split('.') %> 
										
												<% if(file[1]=='pdf'){%>
												<a data-url='<?php echo base_url().'media_files/';?><%= files.filename %>' id='name_<%= files.filename %>' class="pdf_file strong text-regular" rel="media-gallery"> <%= files.filename %></a>,&nbsp;
												<% } %>
										
												<% if(file[1]=='jpg' || file[1]=='png' || file[1]=='bmp' || file[1]=='jpeg'|| file[1]=='gif'){%>
													<a id='<%= files.filename %>' class="fancybox-buttons strong text-regular" data-fancybox-group="buttons" href='<?php echo base_url().'media_files/';?><%= files.filename %>' rel="media-gallery" > <%= files.filename %></a>,&nbsp;
												<% } %>

											<% }); %>
										<% } %>
												</div>
												
												<div id='attachments_<%= rec.id %>' style="display:none;">
												
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
<% }); %>
<% } %>

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

<!-- <script type="text/template" id="tpl-shared-record-view">
<div class="innerAll">

</div>
</div>
</script> -->
<script type="text/template" id="tpl-record-list-item">	

<div id="records_list" class="media innerAll" style="width: 280px; float: left;" >
	<div class="box-generic" style="width: 260px; border-color: #B4B4B4;">			
       <div id="<%=record_id%>" class="media">
          <input type="checkbox" value="<%= member_id %>" />
              <div id="records" class="media-body" style="height: 55px; width: 235px; font-size: 20px;">
				
			  </div>
	   </div>
	</div>
</div>


</script>
<script type="text/template" id="tpl-addfile-view"> 
     <input type="hidden" value="<%= id %>" id="cont_id" />
                            <div id="addfile" class="innerAll">
							<div class="media">
<button id="save_button" type="submit" class="save_add pull-right btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
						        						
<img src='<?php echo base_url() . 'assets/images/file_image/file.png'; ?>'class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
             
                             <div class="media-body innerAll half">
                             <h1 class="media-heading text-large">Add File</a></a></h1>
 							</div>
							</div>			
                               </div> 
								<!-- /* values for date of birth*/-->
                                <div class="col-separator-h box"></div>

<form class="form-horizontal margin-none" enctype="multipart/form-data" id="validateSubmitForm_add" method="post">

                                              <div class="bg-gray border-bottom innerAll inner-2x">
                                                <!-- Row -->
                                                <div class="row innerLR"> 
<button id="rec_to_file" class="pull-right btn btn-primary" style="margin-top: 2px;"><i class="fa fa-plus-circle"></i> Add Records</button>
                                                  <!-- Column -->
                                                  <div class="col-md-8">
                                                    <div class="form-group">
                                                      <label id="fn" class="col-md-4 control-label" for="filename">File name</label>
                                                    <div class="col-md-8">
                             <input class="form-control"  id="filename" placeholder="Enter your File name" name="fname"  type="text" />
                                                  </div>
                                                 </div>
												</div>
											   </div>						
                                                    <!-- // Group END -->

</form>
<div id="records_list" class="media innerAll" style="width: 280px; float: left;" >
</div>					 
</script>

