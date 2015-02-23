<?php
    include_once 'html_comp/modal_all.php';
?>
 <br/><br/><br/><br/><br/><br/>
<gcse:searchresults></gcse:searchresults>
<script type="text/javascript">
	$(function (){
		$("a[href^='#demo']").click(function (evt){
			evt.preventDefault();
			var scroll_to = $($(this).attr("href")).offset().top;
			$("html,body").animate({ scrollTop: scroll_to - 80 }, 600);
		});
		$("a[href^='#bg']").click(function (evt) {
			evt.preventDefault();
			$("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-image", "url('bgs/" + $(this).data("file") + "')");
			console.log($(this).data("file"));
		});
		$("a[href^='#color']").click(function (evt) {
			evt.preventDefault();
			var elm = $(".tabbable");
			elm.removeClass("grey").removeClass("dark").removeClass("dark-input").addClass($(this).data("class"));
			if (elm.hasClass("dark dark-input")) {
				$(".btn", elm).addClass("btn-inverse");
			}
			else {
				$(".btn", elm).removeClass("btn-inverse");
			}
		});
		$(".color-swatch div").each(function ()	{
			$(this).css("background-color", $(this).data("color"));
		});
		$(".color-swatch div").click(function (evt)	{
			evt.stopPropagation();
			$("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-color", $(this).data("color"));
		});
		$("#texture-check").mouseup(function (evt) {
			evt.preventDefault();
			if (!$(this).hasClass("active")) {
				$("body").css("background-image", "url(bgs/n1.png)");
			}
			else {
				$("body").css("background-image", "none");
			}
		});
		$("a[href='#']").click(function (evt) {
			evt.preventDefault();
		});
	});

//textarea autogrow script starts here
	$(document).one('focus.textarea', '.autoExpand', function(){
		var savedValue = this.value;
		this.value = '';
		this.baseScrollHeight = this.scrollHeight;
		this.value = savedValue;
	}).on('input.textarea', '.autoExpand', function(){
		var minRows = this.getAttribute('data-min-rows')|0,
		rows;
		this.rows = minRows;
		console.log(this.scrollHeight , this.baseScrollHeight);
		rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
		this.rows = minRows + rows;
	}); 
//textarea autogrow script ends here
</script>
<script src="js/delete_comment_challenge.js" type="text/javascript"></script>
<script type="text/javascript" src="js/username_email_check.js"></script>
<script type="text/javascript" src="js/signupValidation.js"></script>
<script type="text/javascript" src="js/loginValidation.js"></script>
<script src="js/functions.js"></script>
<script src="js/ninjas.js" type="text/javascript"></script>
<script src="js/project_page.js"></script>
<script src="js/content_edit.js"></script>
<script type="text/javascript" src="js/introduction.js"></script>
<!--<script src="js/bootstrap.js"></script>--->
<script src="scripts/bootstrap.min.js"></script>
<script src="js/bootbox.js"></script>
<script src="js/search.js" type="text/javascript"></script>
<script src="jquery.simple-dtpicker.js"></script>
<script src="js/chat.js"></script>
<script src="js/add_remove_skill.js" type="text/javascript"></script>
<script type="text/javascript" src="js/chat_box.js"></script>
<script type="text/javascript" src="js/getMeta.js"></script> 
<script src="scripts/tabs-addon.js"></script>
<script type="text/javascript" src="js/intro.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="js/rrssb.min.js"></script>
<script>
	$('.bs-component').jScrollPane();
	updatelastlogin();
</script>
<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(100809927); }catch(e){}</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100809927ns.gif" /></p></noscript>
