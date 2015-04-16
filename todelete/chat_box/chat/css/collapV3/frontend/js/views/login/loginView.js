define([
  'jquery',
  'underscore',
  'backbone',
  'bootstrap',
  'bootbox',
  'text!templates/login/loginTemplate.html',
  'models/login/loginModal'
  ], function($, _, Backbone, bootstrap, Bootbox, loginTemplate, LoginModel){
    
    var LoginView = Backbone.View.extend({

      el : $("#page"),
      events: {
        'submit .login-form': 'login'
      },
      initialize : function() {
        $("#right-panel").html("");
        var that = this;
        that.bind("reset", that.clearView);
      },
      login: function (ev) {
        var that = this;
        var username = ev.currentTarget.username.value;
        var password = ev.currentTarget.passwordlogin.value;
        if(username=="" || username==undefined || username==null){
          Bootbox.alert("Please enter username");
        }
        else if(password=="" || password==undefined || password==null){
          Bootbox.alert("Please enter password");
        }
        else {
          var loginDetails = {};
          /*//console.log(ev.currentTarget);
          loginDetails.root = $(ev.currentTarget).serializeObject1();
          var login = new LoginModel({id: null});
          login.save(loginDetails,{
            success: function (login) {
              that.bind("reset", that.clearView);
              //that.render({id: null});
              delete login;
              delete this.login;
              //document.getElementById("logout").innerHTML = '<a href="#/logout">Log Out </a>';
              var key = login.attributes.data["auth-key"];
              $.createCookie("auth-key", key, 2);
              window.app_router.navigate('#/messages', {trigger:true});
            },
            error: function (loginDetails,response) {
              Bootbox.alert("Please try again");
            }
          });*/
        }
        /*that.bind("reset", that.clearView);
        return false;*/
      },
      render: function () {
        var that = this;
        var template = _.template(loginTemplate); 
        that.$el.html(template);
        $("#nav-tabs").html("<li id='loginNav'><a href='#/login' style='color: #000;'> Login </a></li><li id='registerNav'><a href='#/register' style='color: #000;'> Register </a></li>");
        $("#loginNav").addClass('active');
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return LoginView;
});
