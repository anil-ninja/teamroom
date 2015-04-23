define([
  'jquery',
  'underscore',
  'backbone',
  'logReg',
  'text!templates/registration/registrationTemplate.html',
  'models/registration/registrationModal'
  ], function($, _, Backbone, logReg, registrationTemplate, RegistrationModel){
    
    var RegistrationView = Backbone.View.extend({

      el : $("#page"),
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
      render: function () {
        var that = this;
        var template = _.template(registrationTemplate);
        that.$el.html(template);
        $("#nav-tabs").html("<li id='loginNav'><a href='#/login' style='color: #000;'> Login </a></li><li id='registerNav'><a href='#/register' style='color: #000;'> Register </a></li>");
        $("#registerNav").addClass('active');
        $(".totalcapital").hide();
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return RegistrationView;
});
