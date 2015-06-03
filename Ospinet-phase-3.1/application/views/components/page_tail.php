</div>
<div id="footer" class="hidden-print">
	<div class="container">

		<ul class="list-unstyled center">
			<li class="home"><a href="<?php echo base_url('member');?>">Home</a>
			</li>
			<li class="blog"><a href="http://ospinet.com/blog/">Blog</a></li>
			<!--  <li><a href="http://ospinet.com/reviews/">Reviews</a></li>-->
			<li class="faqs"><a href="<?php echo base_url('faqs');?>">FAQs</a></li>
			<li class="contact"><a href="<?php echo base_url('contactus');?>">Contact</a>
			</li>
		</ul>
		<div class="copy">
			© 2012 -
			<?php echo date("Y")?>
			- Ospinet - All Rights Reserved. <a id="privacy"> Privacy Policy</a>
		</div>
		<!--  Copyright Line -->
		<!--<div class="copy margin-none"><a href="http://themeforest.net/?ref=mosaicpro" target="_blank">Purchase CORAL on ThemeForest</a> - Current version: v1.9.5 / <a target="_blank" href="../assets/../../CHANGELOG.txt">changelog</a></div>-->
		<!--  End Copyright Line -->

	</div>
</div>
<!-- // Footer END -->

<!-- Themer -->

<!-- // Themer END -->

<script
	src="<?php echo base_url().'assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.9.5';?>"></script>
<!-- Global -->
<script>
	var basePath = '',
		commonPath = '../assets/',
		rootPath = '../',
		DEV = false,
		componentsPath = '../assets/components/';
	
	var primaryColor = '#eb6a5a',
		dangerColor = '#b55151',
		successColor = '#609450',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';
	
	var themerPrimaryColor = primaryColor;
	</script>
<script type="text/javascript">
	$('#privacy').click(function()
	{
		bootbox.alert("<h2>Privacy Policy</h2><br>We know you care about your life, and that of your near and dear ones.We do too. At Ospinet we understand the importance of quality healthcare, and realize healthcare record management needs to be a tool not a hurdle for a better healthier life.We comply with HIPPA and ensure maximum privacy of your records.All your records are encrypted with 256 AES encryption making it as secure as, well, the US government records.We guarantee we will never share your personal contact information with any third party without your consent.");
	});
	if($("#url_seg").val()=="faqs")
{
	$(".faqs").addClass("active");
}
if($("#url_seg").val()=="contactus")
{
	$(".contact").addClass("active");
}
if($("#url_seg").val()=="" || $("#url_seg").val()=="home")
{
	$(".home").addClass("active");
}
	</script>


</body>
</html>
