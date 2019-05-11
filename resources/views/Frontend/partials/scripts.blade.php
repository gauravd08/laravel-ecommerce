<!--====== Javascripts & Jquery ======-->
<script src="/assets/frontend/js/jquery-3.2.1.min.js"></script>
<script src="/assets/frontend/js/bootstrap.min.js"></script>
<script src="/assets/frontend/js/jquery.slicknav.min.js"></script>
<script src="/assets/frontend/js/owl.carousel.min.js"></script>
<script src="/assets/frontend/js/jquery.nicescroll.min.js"></script>
<script src="/assets/frontend/js/jquery.zoom.min.js"></script>
<script src="/assets/frontend/js/jquery-ui.min.js"></script>
<script src="/assets/frontend/js/main.js"></script>

<!-- fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.js"></script>


<script type="text/javascript">
	$('#memberpopup').fancybox({
		//selector        : '[data-fancybox="images"]',
		type: 				"ajax",
		thumbs          : false,
		loop            : true,
		toolbar         : "auto",
		arrows          : false,
		infobar         : false,
	});
</script>

<!--common X-XSRF-TOKEN -->
<script type="text/javascript">
$.ajaxSetup
({
	headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
</script>

@stack('view-scripts')