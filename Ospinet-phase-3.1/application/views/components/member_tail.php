<script
	src="<?php echo base_url().'assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/plugins/breakpoints/breakpoints.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/core/js/sidebar.main.init.js?v=v1.9.5';?>"></script>
<!--<script src="<?php echo base_url().'assets/components/core/js/sidebar.discover.init.js?v=v1.9.5';?>"></script>-->
<script
	src="<?php echo base_url().'assets/components/core/js/sidebar.kis.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php //echo base_url().'assets/components/core/js/core.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php //echo base_url().'assets/components/core/js/animations.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/js/lightbox.min.js';?>"
	type="text/javascript" charset="utf-8"></script>

<script
	src="<?php echo base_url().'assets/components/modules/admin/modals/assets/js/bootbox.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/modals/assets/js/modals.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/file_manager/dropzone/assets/lib/js/dropzone.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/file_manager/dropzone/assets/custom/dropzone.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/elements/select2/assets/lib/js/select2.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/elements/select2/assets/custom/js/select2.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/forms/elements/jasny-fileupload/assets/js/bootstrap-fileupload.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/notifications/notyfy/assets/lib/js/jquery.notyfy.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/notifications/notyfy/assets/custom/js/notyfy.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/notifications/gritter/assets/lib/js/jquery.gritter.min.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/components/modules/admin/notifications/gritter/assets/custom/js/gritter.init.js?v=v1.9.5';?>"></script>
<script
	src="<?php echo base_url().'assets/js/jquery.nicescroll.plus.js';?>"></script>
<script
	src="<?php echo base_url().'assets/js/fronend.js';?>"></script>
<script
	src="<?php echo base_url().'test2/underscore-min.js';?>"></script>
<script
	src="<?php echo base_url().'test2/backbone-min.js';?>"></script>
<script
	src="<?php echo base_url().'part3/js/member.js';?>"></script>
<script>var fname='<?php echo $this->session->userdata("fname");?>'</script>
<script>var lname='<?php echo $this->session->userdata("lname");?>'</script>
<script>var id='<?php echo $this->session->userdata("id");?>'</script>
<script
	src="<?php echo base_url().'part3/js/main.js';?>"></script>
<!--<script src="<?php echo base_url().'part3/js/contacts.js';?>"></script>-->
</body>
</html>
<script>
$(document).ready(function(e) {

	$("#list_of_members").hover(function(e) {
       $(".nicescroll-rails").show();
    });
    $("#list_of_contacts").hover(function(e) {
        $(".nicescroll-rails").show();
     });
    $("#file_contacts_list").hover(function(e) {
        $(".nicescroll-rails").show();
     });
    $("#records_list").hover(function(e) {
        $(".nicescroll-rails").show();
     });
	$("#formdetails").hover(function(e) {
       $(".nicescroll-rails").show();
    });
	$("#addcontacts").hover(function(e) {
        $(".nicescroll-rails").show();
     });
	$("#contactdetails").hover(function(e) {
        $(".nicescroll-rails").show();
     });
    
});


</script>
