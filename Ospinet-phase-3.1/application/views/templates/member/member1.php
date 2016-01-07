<div class="container-fluid menu-hidden">
	<!-- Main Sidebar Menu -->
	<div id="menu"
		class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">

		<div id="sidebar-discover-wrapper">
			<div id="logoWrapper">
				<a href="index.html?lang=en" id="logo" class="animated fadeInDown"><img
					src="<?php echo base_url().'assets/images/logo/app-logo-style-default.png';?>"
					alt="">
				</a>
				<!--		<div id="toggleNavbarColor" data-toggle="navbar-color">
			<a href="" class="not-animated color color-blue active"></a>
			<a href="" class="not-animated color color-white"></a>
			<a href="" class="not-animated color bg-primary"></a>
			<a href="" class="not-animated color color-inverse"></a>
		</div>-->
			</div>
			<ul class="list-unstyled">

				<li class=" active"><a href="medical_patients.html?lang=en"><span
						class="badge pull-right badge-primary">8</span><i
						class="fa fa-user-md"></i><span>Records</span>
				</a></li>
				<li><a href="#sidebar-discover-example"
					data-toggle="sidebar-discover"><span
						class="badge pull-right badge-primary">21</span><i
						class="fa fa-user-md"></i><span>Records B</span>
				</a>
					<div id="sidebar-discover-example" class="sidebar-discover-menu">
						<div
							class="innerAll text-center border-bottom text-white animated pulse">
							<strong>Manage Records</strong>
						</div>
						<ul class="animated fadeIn">
							<li class="active"><a href=""><i class="fa fa-users"></i> All
									Members</a>
							</li>
							<li><a href=""><span class="badge pull-right badge-primary">21</span><i
									class="fa fa-files-o"></i> All Records</a>
							</li>
							<li><a href=""><span class="badge pull-right badge-primary">6</span><i
									class="fa fa-tags"></i> All Labels</a>
							</li>
							<li class="hasSubmenu"><a href="#submenu" data-toggle="collapse"><i
									class="fa fa-plus-square-o"></i> Add New</a>
								<ul class="collapse" id="submenu">
									<li><a href="">Add Member</a>
									</li>
									<li><a href="">Add Record</a>
									</li>
									<li><a href="">Add Label</a>
									</li>
								</ul></li>
						</ul>
					</div></li>


			</ul>
		</div>





	</div>
	<!-- // Main Sidebar Menu END -->

	<!-- Main Sidebar Menu -->
	<!--<div id="menu_kis" class="hidden-print sidebar-light">

			<div>
	<ul class="list-unstyled">

		<li><a href="index.html?lang=en" class="glyphicons globe"><i></i><span>Social</span></a></li>

<li><a href="realestate_listing_map.html?lang=en" class="glyphicons home"><i></i> Estate</a></li>

<li><a href="events.html?lang=en" class="glyphicons google_maps"><i></i> Events</a></li>

<li><a href="news.html?lang=en" class="glyphicons notes"><i></i> Content</a></li>

<li><a href="gallery_video.html?lang=en" class="glyphicons picture"><i></i><span>Media</span></a></li>

<li><a href="tasks.html?lang=en" class="glyphicons share_alt"><i></i><span>Tasks</span></a></li>

<li><a href="support_tickets.html?lang=en" class="glyphicons life_preserver"><i></i><span>Support</span></a></li>

<li class="active"><a href="medical_overview.html?lang=en" class="glyphicons circle_plus"><i></i><span>Medical</span></a></li>

<li><a href="courses_2.html?lang=en" class="glyphicons crown"><i></i> Learning</a></li>

<li><a href="finances.html?lang=en" class="glyphicons calculator"><i></i> Finance</a></li>

<li><a href="shop_products.html?lang=en" class="glyphicons shopping_cart"><i></i><span>Shop</span></a></li>

<li><a href="survey.html?lang=en" class="glyphicons turtle"><i></i><span>Surveys</span></a></li>

<li><a href="dashboard_analytics.html?lang=en" class="glyphicons plus"><i></i><span>Other</span></a></li>

<li><a href="../front/index.html?lang=en" class="glyphicons leather" target="_blank"><i></i><span>Website</span></a></li>		
	</ul>
</div>


			
		</div>-->
	<!-- // Main Sidebar Menu END -->

	<!-- Content -->
	<div id="content">


		<div class="navbar hidden-print navbar-inverse box main"
			role="navigation">
			<div
				class="user-action user-action-btn-navbar pull-left border-right">
				<button class="btn btn-sm btn-navbar btn-primary btn-stroke">
					<i class="fa fa-bars fa-2x"></i>
				</button>
			</div>
			<div class="col-md-3 padding-none visible-md visible-lg">
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
					<i class="fa fa-fw fa-power-off"></i><span
						class="menu-left-hidden-xs"> Logout</span>
				</button>
			</div>
			<div
				class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
				<div class="dropdown username hidden-xs pull-left">
					<a class="dropdown-toggle " data-toggle="dropdown" href="#"> <span
						class="media margin-none"> <span class="pull-left"><img
								src="<?php echo base_url().'assets/images/people/35/16.jpg';?>"
								alt="user" class="img-circle">
						</span> <span class="media-body"> <?php echo $this->session->userdata("fname"); ?>&nbsp;&nbsp;<?php echo $this->session->userdata("lname"); ?><span
								class="caret"></span> </span> </span> </a>
					<ul class="dropdown-menu pull-right">
						<li><a href="#" class="glyphicons user"><i></i>Profile</a>
						</li>
						<li><a href="#" class="glyphicons cogwheels"><i></i>Settings</a>
						</li>
						<li><a href="#" class="glyphicons buoy"><i></i>Help & Support</a>
						</li>
						<li><a href="<?php echo base_url().'register/logout';?>"
							class="glyphicons power"><i></i>Logout</a>
						</li>
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
			<!--<ul class="notifications pull-right hidden-xs">
		<li class="dropdown notif">
			<a href="" class="dropdown-toggle"  data-toggle="dropdown"><i class="notif-block fa fa-comments-o"></i><span class="badge badge-primary">7</span></a>
			<ul class="dropdown-menu chat media-list">
				<li class="media">
			        <a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/15.jpg" alt="50x50" width="50"/></a>
					<div class="media-body">
			        	<span class="label label-default pull-right">5 min</span>
			            <h5 class="media-heading">Adrian D.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
				</li>
		      	<li class="media">
		          	<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/16.jpg" alt="50x50" width="50"/></a>
					<div class="media-body">
			          	<span class="label label-default pull-right">2 days</span>
			            <h5 class="media-heading">Jane B.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
		        </li>
			    <li class="media">
		          	<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/17.jpg" alt="50x50" width="50"/></a>
			      	<div class="media-body">
						<span class="label label-default pull-right">3 days</span>
			            <h5 class="media-heading">Andrew M.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
		        </li>
		        <li><a href="#" class="btn btn-primary"><i class="fa fa-list"></i> <span>View all messages</span></a></li>
	      </ul>
		</li>
	</ul>-->
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
								<div class="col-separator col-separator-first box">

									<div class="heading-buttons border-bottom innerLR"
										id="add_new_member"></div>

									<div class="bg-white border-bottom innerAll">
										<div class="input-group input-group-sm">
											<div class="input-group-btn">
												<button type="button"
													class="btn btn-default dropdown-toggle"
													data-toggle="dropdown">
													Name <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a href="#">Name</a>
													</li>
													<li><a href="#">Phone Number</a>
													</li>
													<li><a href="#">Group</a>
													</li>
												</ul>
											</div>
											<input type="text" class="form-control"
												placeholder="Find a member ...">
										</div>
									</div>
									<div id="memberlist"></div>
								</div>
								<!-- // END col-separator.box -->

							</div>
							<!-- // END col -->



							<!-- col -->

							<!--main column		-->

							<div class="col-lg-9 showdetails">

								<!-- col-separator.box -->

								<div class="col-separator box"></div>
								<div class="col-separator box">
									<div class="innerAll" id="formdetails"></div>

									<div class="col-separator-h box"></div>

									<div class="heading-buttons border-bottom innerLR">
										<h4 class="margin-none innerTB pull-left">Records</h4>
										<button class="btn btn-xs btn-inverse pull-right">
											<i class="fa fa-plus"></i> Add records <i
												class="fa fa-file-text-o fa-fw"></i>
										</button>
										<div class="clearfix"></div>
									</div>
									<div class="bg-gray border-bottom innerAll">
										<div class="input-group input-group-sm">
											<div class="input-group-btn">
												<button type="button"
													class="btn btn-default dropdown-toggle"
													data-toggle="dropdown">
													Name <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a href="#">Name</a>
													</li>
													<li><a href="#">Phone Number</a>
													</li>
													<li><a href="#">Group</a>
													</li>
												</ul>
											</div>
											<input class="form-control"
												placeholder="What are you searching for?" type="text">
										</div>
									</div>

									<div class="innerAll" id="reportsview">
										<div style="visibility: visible;"
											class="box-generic padding-none animated fadeInUp">
											<a href=""><h5
													class="strong margin-none innerAll border-bottom">Dolor
													voluptates earum dignissimos</h5>
											</a>
											<div class="innerAll half border-bottom">
												<i class="fa fa-calendar fa-fw text-primary"></i> 23 aug
												2013 &nbsp; <i class="fa fa-tag fa-fw text-primary"></i> <span
													class="label label-primary">tagged</span>
											</div>
											<div class="innerAll">
												<p class="margin-none innerAll">
													<i class="fa fa-quote-left fa-2x pull-left"></i> Lorem
													ipsum dolor sit amet, consectetur adipisicing elit.
													Eveniet, aut, blanditiis pariatur ad enim ex dolorem.
													Rerum, fuga, praesentium nulla sed at numquam cupiditate
													dolores quos provident deleniti ab eius.
												</p>
											</div>
											<div class="innerLR innerT half bg-primary-light border-top">
												<button class="btn btn-primary pull-right">
													<i class="fa fa-sign-in"></i>
												</button>
												<div class="media inline-block margin-none">
													<div class="innerLR">
														<i class="fa fa-paperclip pull-left text-primary fa-2x"></i>
														<div class="media-body">
															<div>
																<a href="" class="strong text-regular">Patients</a>
															</div>
															<span>15 MB</span>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
												<div class="media inline-block margin-none">
													<div class="innerLR border-left">
														<i class="fa fa-bar-chart-o pull-left text-primary fa-2x"></i>
														<div class="media-body">
															<div>
																<a href="" class="strong text-regular">Report</a>
															</div>
															<span>244 KB</span>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
										</div>

										<div style="visibility: visible;"
											class="box-generic padding-none animated fadeInUp">
											<a href=""><h5
													class="strong margin-none innerAll border-bottom">Quibusdam
													expedita voluptates tenetur</h5>
											</a>
											<div class="innerAll half border-bottom">
												<i class="fa fa-calendar fa-fw text-primary"></i> 21 aug
												2013 &nbsp; <i class="fa fa-tag fa-fw text-primary"></i> <span
													class="label label-primary">important</span>
											</div>
											<div class="innerAll">
												<p class="margin-none innerAll">
													<i class="fa fa-quote-left fa-2x pull-left"></i> Lorem
													ipsum dolor sit amet, consectetur adipisicing elit. Ipsum,
													voluptates itaque similique excepturi porro suscipit iste
													assumenda fugiat accusantium explicabo incidunt a ad odio
													blanditiis dolores consequatur sequi quisquam mollitia.
												</p>
											</div>
											<div class="innerLR innerT half bg-primary-light border-top">
												<button class="btn btn-primary pull-right">
													<i class="fa fa-sign-in"></i>
												</button>
												<div class="media inline-block margin-none">
													<div class="innerLR">
														<i class="fa fa-stethoscope pull-left text-primary fa-2x"></i>
														<div class="media-body">
															<div>
																<a href="" class="strong text-regular">Lab Results</a>
															</div>
															<span>1 MB</span>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>


								<div class="col-separator box" id="no_member">

									<div class="innerAll">
										<div class="media">


											<div class="media-body innerAll half">
												<h4 class="media-heading text-large"></h4>
												<p>Please Select Member From List</p>
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

	<div class="clearfix"></div>
	<!-- // Sidebar menu & content wrapper END -->

	<!-- Footer -->
	<div id="footer" class="hidden-print">

		<!--  Copyright Line -->
		<div class="copy">
			&copy; 2012 - 2014 - <a style="text-decoration: none;"
				href="http://www.ospinet.com">Ospinet</a> - All Rights Reserved. <a
				style="text-decoration: none;" href="#" target="_blank">Privacy
				Policy</a>
		</div>
		<!--  End Copyright Line -->

	</div>
	<!-- // Footer END -->


</div>
<?php echo $this->uri->segment("2");  ?>
<!-- Global -->



<script type="text/template" id="tpl-header">
                
                <h4 class="margin-none innerTB pull-left">Members</h4>
                                        <button onclick="javascript:newmember(this)" class="new btn btn-xs btn-default pull-right" style="margin-top:10px;"><i class="fa fa-plus"></i> Add member <i class="fa fa-user fa-fw"></i></button>
                                        <div class="clearfix"></div>
            </script>
</script>



<!--WINE LIST START-->
<script type="text/template" id="tpl-report-list-item">
                        
                        <div class="media innerAll">
                                                        <button id="active_button" onclick="javascript:test('<%= id %>',this)"  class="pull-right btn btn-primary btn-stroke btn-xs">
                                                            <i class="fa fa-arrow-right"></i></button>
                                                            
                                                <img src="<?php echo base_url().'assets/images/people/80/2.jpg';?>" alt="" class="pull-left thumb" width="35">
								  	<div class="media-body">
								  		<h5 class="media-heading strong"><%=fname %> <%= lname %></h5>
								   		<ul class="list-unstyled">
								   	 		<li><i class="fa fa-phone"></i> 0353 8473102009</li>
								    		<li><i class="fa fa-map-marker"></i> 129 Longford Terrace, Co. Dublin</li>
								    	</ul>
								  	</div>
								</div>
								
</script>
<!--WINE LIST END-->
<!--WINE DETAILS START-->

<script type="text/template" id="tpl-member-details">
							 
                                    <button onclick="javascript:memberedit('<%= id %>',this)" class="pull-right btn btn-default btn-sm"><i class="fa fa-fw fa-edit"></i> Edit</button>
                                    <img src="<?php echo base_url().'assets/images/people/250/2.jpg';?>" class="thumb pull-left animated fadeInDown" alt="" width="100" style="visibility: visible;">
                                        <div class="media-body innerAll half">
                                            <h4 class="media-heading text-large"><%= fname %> <%= lname %></h4>
                                                <p><%= gender %>, <%= age %> years old<br>Living in Dublin, Ireland<br>Patient 1234567890</p>
                                        </div>
							
                                
                        			   
                            </script>

<!--WINE DETALS END-->
<!--WINE EDIT START-->
<script type="text/template" id="tpl-wine-edit">
                                  
						
	</script>
<script type="text/template" id="tpl-report">
	 Amol
		 
	</script>
<!--WINE LIST END-->
<!-- JavaScript -->




<script type="application/javascript">

$("#reportdetails").hide();
$("#memberedit").hide();
$("#formdetails").hide();


function test(a,$this)
{
	$("#formdetails").show();
	$(".list-group-item").removeClass("active").removeAttr("id");
	window.location.href="#memberid/"+a;
	$($this).parent().parent().addClass("active").attr("id",a);
	$("#memberedit").hide();
	$("#no_member").hide();
	$("#reportdetails").hide();
}	
function newmember($this)
{
	$("#formdetails").hide();
	$("#memberedit").show();
	$("#no_member").hide();
	$("#reportdetails").hide();
}
function memberreport(a,$this)
{
	window.location.href="#memberreport/"+a;
	//$($this).parent().parent().addClass("active").attr("id",a);
	$("#memberedit").hide();
	$("#formdetails").hide();
	$("#no_member").hide();
	$("#reportdetails").show();
}
function memberedit(a,$this)
{
	
	window.location.href="#memberedit/"+a;
	//$($this).parent().parent().addClass("active").attr("id",a);
	$("#memberedit").show();
	$("#formdetails").hide();
	$("#no_member").hide();
	$("#reportdetails").hide();
}
//$("#editform").hide();

function age_type($this)
{
	$("#birth_info").val($($this).attr("id"));
	
	if($($this).attr("id")=="Dob")
	{
	$("#dob_group").css("display","block");
	$("#age_group").css("display","none");
	}
	if($($this).attr("id")=="Age")
	{
	$("#age_group").css("display","block");
	$("#dob_group").css("display","none");
	}
	if($($this).attr("id")=="Unborn")
	{
	$("#age_group").css("display","none");
	$("#dob_group").css("display","none");
	}
}	
function genderselect($this)
{
	
		$("#gender").val($($this).attr("id"));
	
	
	
}					
</script>
<style>
.list-group-item:before {
	background: rgba(239, 239, 239, 0.3);
	position: absolute;
	top: 0;
	bottom: 0;
	right: 100%;
	left: 0;
	content: "";
	-webkit-transition: right 400ms ease;
	-moz-transition: right 400ms ease;
	-o-transition: right 400ms ease;
	-ms-transition: right 400ms ease;
	transition: right 400ms ease;
}

.list-group-item:hover:before {
	right: 0
}

.list-group-item:hover {
	background: #fff
}

.list-group-item:hover:before {
	right: 0
}

.list-group-item.active:before {
	background: #158182
}

.delete_link {
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	font-weight: normal;
	height: 35px;
	line-height: 35px;
	margin: 0;
	padding: 0 10px;
	color: #999999;
	float: right;
}

.delete_link:hover {
	color: #7F0000;
}
</style>
