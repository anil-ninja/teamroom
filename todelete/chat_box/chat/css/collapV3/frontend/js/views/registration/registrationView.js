define([
  'jquery',
  'underscore',
  'backbone',
  'logReg',
  'text!templates/registration/registrationTemplate.html',
  'text!templates/navbar/navbarlogin.html',
  'models/registration/registrationModal'
  ], function($, _, Backbone, logReg, registrationTemplate, navbarTemplate, RegistrationModel){
    
    var RegistrationView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      events: {
        'submit .registration-form': 'register'
      },

      initialize : function() {
        $("#right-panel").html("");
        var that = this;
        that.bind("reset", that.clearView);
      },
      register: function(ev){
        var typeA = document.getElementById("typeCol").checked;
        var typeB = document.getElementById("typeInv").checked;
        var typeC = document.getElementById("typeFun").checked;
        var condition = document.getElementById("agree_tc").checked;
        var firstname = ev.currentTarget.firstname.value ;
        var lastname = ev.currentTarget.lastname.value ;
        var email = ev.currentTarget.email.value ;
        var user = ev.currentTarget.usernameR.value ;
        var username = replaceAll('[.]', '', user);
        var password = ev.currentTarget.passwordR.value ;
        var password2 = ev.currentTarget.password2R.value ;
        var investment = ev.currentTarget.investment.value ;
        var Usernameres = validateUsername(username);
        var firstnameres = validatePath(firstname);
        var lastnameres = validatePath(lastname);
        var emailres = validateEmail(email);
        console.log(firstnameres);
        if(password==password2){
          if(!firstnameres){
            bootstrap_alert(".alert_placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets and Numbers are allowed in First Name", 5000,"alert-warning");
          }
          else if(!lastnameres){
            bootstrap_alert(".alert_placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets and Numbers are allowed in Last Name", 5000,"alert-warning");
          }
          else if(!emailres){
            bootstrap_alert(".alert_placeholder", "Enter valid Email-ID", 5000,"alert-warning");
          }
          else if(!Usernameres){
            bootstrap_alert(".alert_placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets, Numbers, dot, $, #, @, and underscore are allowed in Username", 5000,"alert-warning");
          }
          else if(username.length <'6'){
            bootstrap_alert(".alert_placeholder", "username length be atleast 6", 5000,"alert-warning");
          } 
          else if(password == "" || password == null || password == undefined){
            bootstrap_alert(".alert_placeholder", "password can not be empty", 5000,"alert-warning");
          } 
          else if(password.length <'6'){
            bootstrap_alert(".alert_placeholder", "password length should be atleast 6", 5000,"alert-warning");
          }
          else if(password2 == "" || password2 == null || password2 == undefined){
            bootstrap_alert(".alert_placeholder", "password can not be empty", 5000,"alert-warning");
          }
          else if((typeA==false) && (typeB==false) && (typeC==false)){
            bootstrap_alert(".alert_placeholder", "You have not told why you are here", 5000,"alert-warning");
          }
          else if((typeB==true)&& (investment=='' || investment == 0)) {
            bootstrap_alert(".alert_placeholder", "Amount can not be empty", 5000,"alert-warning");
            return false;
          }
          else if(condition==false){
            bootstrap_alert(".alert_placeholder", "You have not accepted term and conditions", 5000,"alert-warning");
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
          }
        }   
        else { 
          bootstrap_alert(".alert_placeholder", "Password Not Match! Try Again", 5000,"alert-warning");
        }
    
        //console.log(ev); 
      },
     /* login: function (ev) {
        var that = this;                                                      
        console.log("savePost");
        console.log(this);
        var loginDetails = {};
        //console.log(ev.currentTarget);
        loginDetails.root = $(ev.currentTarget).serializeObject1();
        var login = new LoginModel({id: null});
        login.save(loginDetails,{
          success: function (login) {
            that.bind("reset", that.clearView);
            //that.render({id: null});
            delete login;
            delete this.login;
            var key = login.attributes.data["auth-key"];
            $.createCookie("auth-key", key, 2);
            window.app_router.navigate('#/messages', {trigger:true});
          },
          error: function (loginDetails,response) {
            //window.app_router.navigate('messages', {trigger:true});
            //console.log(JSON.parse(response.responseText));
            //alert(JSON.parse(response.responseText).internal_status.message );
          }
        });
        return false;
      },*/
      render: function () {
        var that = this;
        var template = _.template(registrationTemplate);
        var navtemplate = _.template(navbarTemplate);
        //$('#login-template').html(template); 
        that.$el.html(template);
        this.navel.html(navtemplate);
        $("#registerNav").addClass('active');
        $(".totalcapital").hide();
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return RegistrationView;
});
