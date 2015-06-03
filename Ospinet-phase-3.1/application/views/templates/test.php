<!DOCTYPE HTML>
<html>
<head>
<title>Backbone Cellar</title>
<link rel="stylesheet"
	href="j<?php echo base_url().'js/test2/styles.css';?>" />
</head>

<body>

	<div id="header">
		<span class="title">Backbone Cellar</span>
	</div>

	<div id="sidebar"></div>

	<div id="content">
		<h2>Welcome to Backbone Cellar</h2>
		<p>This is a sample application part of of three-part tutorial showing
			how to build a CRUD application with Backbone.js.</p>
	</div>

	<!-- Templates -->
	<script type="text/template" id="tpl-header">
	<button class="new">New Wine</button>
</script>

	<script type="text/template" id="tpl-wine-list-item">
	<a href='#wines/<%= id %>'><%= fname %></a>
</script>

	<script type="text/template" id="tpl-wine-details">
    <div class="form-left-col">
        <label>Id:</label>
        <input type="text" id="wineId" name="id" value="<%= id %>" disabled />
        <label>First Name:</label>
        <input type="text" id="name" name="name" value="<%= fname %>" required/>
        <label>Last Name:</label>
        <input type="text" id="grapes" name="grapes" value="<%= lname %>"/>
        <label>Gender:</label>
        <input type="text" id="country" name="country" value="<%= gender %>"/>
        <label>Age:</label>
        <input type="text" id="region" name="region"  value="<%= age %>"/>
        <label>Birth Day:</label>
        <input type="text" id="year" name="year"  value="<%= birth_day %>"/>
		 <label>User ID:</label>
        <input type="text" id="year" name="year"  value="<%= userid %>"/>
        <button class="save">Save</button>
        <button class="delete">Delete</button>
    </div>
    <div class="form-right-col">
    </div>

</script>

	<!-- JavaScript -->
	<script src="<?php echo base_url().'js/test2/jquery-1.7.1.min.js';?>"></script>
	<script src="<?php echo base_url().'js/test2/underscore-min.js';?>"></script>
	<script src="<?php echo base_url().'js/test2/backbone-min.js';?>"></script>
	<script src="<?php echo base_url().'part3/js/main.js';?>"></script>
</body>
</html>

