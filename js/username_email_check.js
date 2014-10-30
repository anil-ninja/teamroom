document.getElementById("usernameR").onblur = function() {

                var xmlhttp;

                var username=document.getElementById("usernameR");
                if (username.value != ""){
                    if (window.XMLHttpRequest){
                        xmlhttp=new XMLHttpRequest();

                    } else {
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function(){
                        if (xmlhttp.readyState==4 && xmlhttp.status==200){
                            document.getElementById("status").innerHTML=xmlhttp.responseText;
                        }
                    };
                    xmlhttp.open("GET","ajax/uname_availability.php?username="+encodeURIComponent(username.value),true);
                    xmlhttp.send();
                }
            };
            document.getElementById("email").onblur = function() {

                var xmlhttp;

                var email=document.getElementById("email");
                if (email.value != ""){
                    if (window.XMLHttpRequest){
                        xmlhttp=new XMLHttpRequest();

                    } else {
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function(){
                        if (xmlhttp.readyState==4 && xmlhttp.status==200){
                            document.getElementById("status_email").innerHTML=xmlhttp.responseText;
                        }
                    };
                    xmlhttp.open("GET","ajax/email_availability.php?email="+encodeURIComponent(email.value),true);
                    xmlhttp.send();
                }
            };