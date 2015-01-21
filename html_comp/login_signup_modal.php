        <script>
            $('#SignUp').on('show', function() {
                $('#SignIn').css('opacity', .5);
                $('#SignIn').unbind();
            });
            $('#SignUp').on('hidden', function() {
                $('#SignIn').css('opacity', 1);
                $('#SignIn').removeData("SignIn").modal({});
            });
        </script>
                    
  <!--Signin Modal -->
    <div class="alert_placeholder"></div>  <!-- alert for login -->
    <div class="alert-placeholder"></div>  <!-- alert for signup -->
        <div id="SignIn" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="row-fluid" id="demo-1">
                <div class="span10 offset1">
                    <h4>Collaborate Grow and help Society</h4>
                    <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                        <ul class="nav nav-tabs">
                            <li><a href="index.php#panel1" data-toggle="tab"><i class="icon-lock"></i>&nbsp;<span>Login</span></a></li>
                            <li class="active"><a href="index.php#panel2" data-toggle="tab" class="active "><i class="icon-user"></i>&nbsp;<span>Register</span></a></li>
                            <li><a href="index.php#panel3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                            <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                        </ul>
                        <div class="tab-content ">
                            <div class="tab-pane" id="panel1">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>
                                    
                                        <label>Username</label>
                                        <input type="text" class="input-block-level" id="username" placeholder="Email or Username"/>
                                        <label>Password </label>
                                        <input type="password" class="input-block-level" id="passwordlogin" placeholder="Password"/>
                                        <label>
                                        <!----
                                            <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                            &nbsp;&nbsp;&nbsp;Remember Me
                                        -->
                                            <a href="index.php#panel3" data-toggle="tab" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a>
                                        </label>
                                        <br />
                                        <a class=" btn " id="request" value='login' onclick="validateLoginFormOnSubmit()">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                    </div>
                                    <div class="span3">
                                        <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                        <div class="socials clearfix">
											<a href='https://www.facebook.com/pages/collapcom/739310236156746' class="icon-facebook facebook" target='_blank'></a>
											<a href='https://twitter.com/CollapCom' class="icon-twitter twitter" target='_blank'></a>
											<a href='https://plus.google.com/u/0/103215845490732646217/about' class="icon-google-plus google-plus" target='_blank'></a>
											<a href='https://www.pinterest.com/collapcom/' class="icon-pinterest pinterest" target='_blank'></a>
											<a class="icon-linkedin linked-in"></a>
											<a href='https://github.com/collapcom' class="icon-github github" target='_blank'></a>
										</div>
                                    </div>
                                    <div class="span4">
                                        <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                        <div class="box">
                                            <p>
											   Introducing a powerful online platform to collaborate with like minded people and change the world, 
											   solving one problem at a time. 
											 </p>
											 <p>
											   Collap offers a wide range of tools to identify a challenge and assemble your own team to collaborate and crack it.
												Here’s to the the joy of collaborative problem solving! 
											</p>
                                        </div>
                                        <div class="box">
                                            Don't Have An Account.<br />
                                            Click Here For <a href="index.php#panel2" data-toggle="tab">Free Register</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="panel2">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>

                                        <div>
                                            <div class='span6'>
                                                <label>First Name</label>
                                                <input type="text" class="input-block-level" id="firstname" onkeyup="nospaces(this)"/>
                                            </div>
                                            <div class='span6'>
                                                <label>Last Name</label>
                                                <input type="text" class="input-block-level" id="lastname" onkeyup="nospaces(this)"/>                    
                                            </div>
                                        </div>

                                        <label>Email</label>
                                        <input type="email" class="input-block-level" id="email" onkeyup="nospaces(this)"/>
                                        <span id="status_email"></span>

                                        <label>Username</label>
                                        <input type="text" class="input-block-level" id="usernameR" onkeyup="nospaces(this)"/>
                                        
                                        <div>
                                            <div class='span6'>
                                                <label>Password </label>
                                                <input type="password" class="input-block-level" id="passwordR"/>
                                            </div>
                                            <div class='span6'>
                                                <label>Repeat Password</label>
                                                <input type="password" class="input-block-level" id="password2R"/>
                                            </div>
                                        </div>
                                        <label>
                                            <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='agree_tc' />

                                            &nbsp;&nbsp;&nbsp;I Aggree With 
                                            <a href="index.php#TabsModalTnC" data-toggle="modal">Terms &amp; Conditions</a>
                                        </label>
                                        <br />

                                        <a class=" btn " id = "request" onclick="validateSignupFormOnSubmit()">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                    </div>
                                    <div class="span3">
                                        <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social Profiles </h4>
                                        <div class="socials clearfix">
											<a href='https://www.facebook.com/pages/collapcom/739310236156746' class="icon-facebook facebook" target='_blank'></a>
											<a href='https://twitter.com/CollapCom' class="icon-twitter twitter" target='_blank'></a>
											<a href='https://plus.google.com/u/0/103215845490732646217/about' class="icon-google-plus google-plus" target='_blank'></a>
											<a href='https://www.pinterest.com/collapcom/' class="icon-pinterest pinterest" target='_blank'></a>
											<a class="icon-linkedin linked-in"></a>
											<a href='https://github.com/collapcom' class="icon-github github" target='_blank'></a>
										</div>
                                    </div>
                                    <div class="span4">
                                        <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                        <div class="box">
                                            <p>
											   Introducing a powerful online platform to collaborate with like minded people and change the world, 
											   solving one problem at a time. 
											 </p>
											 <p>
											   Collap offers a wide range of tools to identify a challenge and assemble your own team to collaborate and crack it.
												Here’s to the the joy of collaborative problem solving! 
											</p>
                                        </div>
                                        <div class="box">
                                            Already Have An Account.<br />
                                            Click Here For <a href="index.php#panel1" data-toggle="tab">Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="panel3">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>
                                        <form method="POST">
                                        <label>Email</label>
                                        <input type="text" class="input-block-level" name="email_forget_password" id="email_forget" onkeyup="nospaces(this)"
                                        required data-bv-emailaddress-message="The input is not a valid email address" />
                                        <span id="status_email_forget_password"></span>

                                        <?php 
                                        /*
                                        <label>Security Question</label>
                                        <select class="input-block-level">
                                            <option disabled="disabled" selected="selected">---Select---</option>
                                            <option>Which Is Your First Mobile</option>
                                            <option>What Is Your Pet Name</option>
                                            <option>What Is Your Mother Name</option>
                                            <option>Which Is Your First Game</option>
                                        </select>
                                        <label>Answer</label>
                                        <input type="text" class="input-block-level" />
                                        
                                        
                                        */
                                        ?>
                                        <br />
                                        <br />
                                        <input type="submit" class=" btn" name="request_password" value = "Recover Password" />&nbsp;&nbsp;&nbsp;
                                    </form>
                                    </div>
                                    <div class="span7">
                                        <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                        <div class="box">
                                            <p>Getting Error With Password Recovery Click Here For <a href="index.php#">Support</a></p>
                                            <ul>
                                            
                                            </ul>
                                        </div>
                                        <div class="box">
                                            <ul>
                                                <li>Having repeated difficulty signing in?</li>
                                                <li>Clearing your browser's cache and cookies may help.</li>    
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <!--end modle-->
 
<!---- Projecct content order modal -->
        <div id="project_order" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="row-fluid" id="demo-1">
                <div class="span4 offset3">
                    <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-wrench"></i>&nbsp;<span>Manage Content</span></a></li>
                            <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                        </ul>
                        <div class="tab-content ">
                            <div class="tab-pane active" id="panel1">
                                <div class="row-fluid">
                                    <div class='alert_placeholder'></div>
                                    <h4><i class="icon-random"></i>&nbsp;&nbsp; Choose how to display.</h4>

                                    <form method="POST" action="">
                                        <select class="btn btn-default" name="select_order" >    
                                            <option value='ASC'>Ascending</option>
                                            <option value='DESC'>Default</option>
                                        </select>
                                        <button type="submit" class="btn btn-success" name="request_order">Sort</button>                     
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!---- modal ends here -->
        <script type="text/javascript">
            function checkForm() {
                if (document.getElementById('password_1').value == document.getElementById('password_2').value) {
                    return true;
                }
                else {
                    alert("Passwords don't match");
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            function nospaces(t){
                if(t.value.match(/\s/g)){
                    alert('Sorry, you are not allowed to enter any spaces');
                    t.value=t.value.replace(/\s/g,'');
                }
            }
        </script>
