<?php
if (!isset($_SESSION['user_id'])){
?>
<script>
	$(document).ready(function(){
		$(window).scroll(function(event) {
			if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
				test() ;
			}
		});	
	});
</script>
<?php
}
?>
