<?php
    include_once 'html_comp/modal_all.php';
?>
 <br/><br/><br/><br/><br/><br/>
<gcse:searchresults></gcse:searchresults>
<script src="js/delete_comment_challenge.js" type="text/javascript"></script>
<script type="text/javascript" src="js/username_email_check.js"></script>
<script type="text/javascript" src="js/signupValidation.js"></script>
<script type="text/javascript" src="js/loginValidation.js"></script>
<script src="js/functions.js"></script>
<script src="js/ninjas.js" type="text/javascript"></script>
<script src="js/project_page.js"></script>
<script src="js/content_edit.js"></script>
<script type="text/javascript" src="js/introduction.js"></script>
<!--<script src="js/bootstrap.js"></script>-->
<script src="scripts/bootstrap.min.js"></script>
<script src="js/bootbox.js"></script>
<script src="js/bootswatch.js"></script>
<script src="js/search.js" type="text/javascript"></script>
<script src="jquery.simple-dtpicker.js"></script>
<script src="js/chat.js"></script>
<script src="js/add_remove_skill.js" type="text/javascript"></script>
<script type="text/javascript" src="js/chat_box.js"></script>
<script type="text/javascript" src="js/getMeta.js"></script>
<script src="js/date_time.js"></script>    
<script src="scripts/tabs-addon.js"></script>
<script type="text/javascript" src="js/intro.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="js/rrssb.min.js"></script>
<script>
	$('.bs-component').jScrollPane();
	updatelastlogin();
	//$('.emotion').emotions();
</script>
<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(100809927); }catch(e){}</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100809927ns.gif" /></p></noscript>
<script type="text/javascript">
        $(function ()
        {
            $("a[href^='#demo']").click(function (evt)
            {
                evt.preventDefault();
                var scroll_to = $($(this).attr("href")).offset().top;
                $("html,body").animate({ scrollTop: scroll_to - 80 }, 600);
            });
            $("a[href^='#bg']").click(function (evt)
            {
                evt.preventDefault();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-image", "url('bgs/" + $(this).data("file") + "')");
                console.log($(this).data("file"));


            });
            $("a[href^='#color']").click(function (evt)
            {
                evt.preventDefault();
                var elm = $(".tabbable");
                elm.removeClass("grey").removeClass("dark").removeClass("dark-input").addClass($(this).data("class"));
                if (elm.hasClass("dark dark-input"))
                {
                    $(".btn", elm).addClass("btn-inverse");
                }
                else
                {
                    $(".btn", elm).removeClass("btn-inverse");

                }

            });
            $(".color-swatch div").each(function ()
            {
                $(this).css("background-color", $(this).data("color"));
            });
            $(".color-swatch div").click(function (evt)
            {
                evt.stopPropagation();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-color", $(this).data("color"));
            });
            $("#texture-check").mouseup(function (evt)
            {
                evt.preventDefault();

                if (!$(this).hasClass("active"))
                {
                    $("body").css("background-image", "url(bgs/n1.png)");
                }
                else
                {
                    $("body").css("background-image", "none");
                }
            });

            $("a[href='#']").click(function (evt)
            {
                evt.preventDefault();

            });

            $("a[data-toggle='popover']").popover({
                trigger:"hover",html:true,placement:"top"
            });
        });
        
//textarea autogrow script starts here
        $(document)
            .one('focus.textarea', '.autoExpand', function(){
                var savedValue = this.value;
                this.value = '';
                this.baseScrollHeight = this.scrollHeight;
                this.value = savedValue;
            })
            .on('input.textarea', '.autoExpand', function(){
                var minRows = this.getAttribute('data-min-rows')|0,
                     rows;
                this.rows = minRows;
            console.log(this.scrollHeight , this.baseScrollHeight);
                rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
                this.rows = minRows + rows;
            }); 
//textarea autogrow script ends here


function validateSignupFormOnSubmit() {
	var reason = "";
	var firstname = $("#firstname").val() ;
	var lastname = $("#lastname").val() ;
	var email = $("#email").val() ;
	//var phone = $("#phone").val() ;
	var username = $("#usernameR").val() ;
	var password = $("#passwordR").val() ;
	var password2 = $("#password2R").val() ;
    var term_n_cond = document.getElementById("agree_tc").checked;
    var typeA = document.getElementById("typeCol").checked;
    var typeB = document.getElementById("typeInv").checked;
    var typeC = document.getElementById("typeFun").checked;
    var amount = $("#investment").val() ;
	if(password==password2){
		if(replaceAll('\\s', '',firstname)==''){
			bootstrap_alert(".alert-placeholder", "firstname can not be empty", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',email)==''){
			bootstrap_alert(".alert-placeholder", "email can not be empty", 5000,"alert-warning");
		}
        else if (validateEmail(email)==false) {
            
                bootstrap_alert(".alert-placeholder", "Enter a valid email id", 5000,"alert-warning");       
            
            //email_availability_check();
        } 
		/*else if(replaceAll('\\s', '',phone)==''){
			bootstrap_alert(".alert-placeholder", "phone can not be empty", 5000,"alert-warning");
		} */
		else if(replaceAll('\\s', '',username)==''){
			bootstrap_alert(".alert-placeholder", "username can not be empty", 5000,"alert-warning");
		}
        else if(username.length <'6'){
            bootstrap_alert(".alert-placeholder", "username length be atleast 6", 5000,"alert-warning");
        } 
		else if(replaceAll('\\s', '',password)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		} 
		else if(password.length <'6'){
			bootstrap_alert(".alert-placeholder", "password length should be atleast 6", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',password2)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		}
		else if(validatePath(firstname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		}
		else if(validatePath(username) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		}
		else if(validatePath(lastname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		} 
        else if(term_n_cond==false){
            bootstrap_alert(".alert-placeholder", "You have not accepted term and conditions", 5000,"alert-warning");
        }
        else if((typeA==false) && (typeB==false) && (typeC==false)){
            bootstrap_alert(".alert-placeholder", "You have not told why you are here", 5000,"alert-warning");
        }
        else if((typeB==true)&& (replaceAll('\\s', '',amount)=='')) {
			bootstrap_alert(".alert_placeholder", "Amount can not be empty", 5000,"alert-warning");
			return false;
		} 
		else {
			if((typeA==false) && (typeB==false)){
				var type = "fundsearcher";
			}
			else if((typeA==false) && (typeC==false)){
				var type = "invester";
			}
			else if((typeB==false) && (typeC==false)){
				var type = "collaborater";
			}
			else if(typeB==false){
				var type = "collaboraterFundsearcher";
			}
			else if(typeA==false){
				var type = "fundsearcherInvester";
			}
			else if(typeC==false){
				var type = "collaboraterInvester";
			}
			else {
				var type = "collaboraterinvesterfundsearcher";
			}
			var dataString = 'firstname='+ firstname + '&lastname='+ lastname + '&email='+ email  + '&username='+ username + '&password='+ password + 
							'&password2='+ password2 + '&type=' + type + '&term_n_cond=' + term_n_cond + '&amount=' + amount + '&request=Signup' ;
			$.ajax({
				type: "POST",
				url: "controllers/login_controller.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result){
						bootstrap_alert(".alert-placeholder", result, 5000,"alert-warning");
					} 
					else {
						location.reload();
					}		
				} 
			});
		}
	}		
	else bootstrap_alert(".alert-placeholder", "Password Not Match! Try Again", 5000,"alert-warning");
}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(find, 'g'), replace);
}

    </script>
