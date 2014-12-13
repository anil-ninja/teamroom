<?php
if (!isset($_SESSION['user_id'])){
	//echo "hi" ;
?>
<script>
	$(document).ready(function(){
		$(window).scroll(function(event) {
			if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
			//alert("fdsf") ;
				test() ;
				}
		});	
	});
</script>
<?php
}
?>
