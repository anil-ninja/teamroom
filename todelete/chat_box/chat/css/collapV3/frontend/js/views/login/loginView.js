define([
  'jquery',
  'underscore',
  'backbone',
  'bootstrap',
  'bootbox',
  'text!templates/login/loginTemplate.html',
  'text!templates/navbar/navbarlogin.html',
  'models/login/loginModal'
  ], function($, _, Backbone, bootstrap, Bootbox, loginTemplate, navbarTemplate, LoginModel){
    
    var LoginView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
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
        var password = ev.currentTarget.password.value;
        if(username=="" || username==undefined || username==null){
          Bootbox.alert("Please enter username");
        }
        else if(password=="" || password==undefined || password==null){
          Bootbox.alert("Please enter password");
        }
        else {
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
              document.getElementById("logout").innerHTML = '<a href="#/logout">Log Out </a>';
              var key = login.attributes.data["auth-key"];
              $.createCookie("auth-key", key, 2);
              window.app_router.navigate('#/messages', {trigger:true});
            },
            error: function (loginDetails,response) {
              Bootbox.alert("Please try again");
            }
          });
        }
        /*that.bind("reset", that.clearView);
        return false;*/
      },
      /*switchTab: function(ev) {
        var data = this.$(ev.target).context.activeElement.attributes.href.value; 
        var selectedTab = ev.currentTarget;
        this.$('li.active').removeClass('active');
        this.$('tab-pane.active').removeClass('active');
        this.$(selectedTab).addClass('active');
        var id = data.split(/#/)[1];
        $("#panel1").removeClass('active');
        $("#panel2").removeClass('active');
        $("#panel3").removeClass('active');
        $("#"+id+"").addClass('active');
      },*/

      render: function () {
        var that = this;
        var template = _.template(loginTemplate);
        var navtemplate = _.template(navbarTemplate);
        //$('#login-template').html(template); 
        that.$el.html(template);
        this.navel.html(navtemplate);
        $("#loginNav").addClass('active');
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return LoginView;
});
