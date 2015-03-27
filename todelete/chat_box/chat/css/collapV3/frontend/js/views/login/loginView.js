define([
  'jquery',
  'underscore',
  'backbone',
  'text!templates/login/loginTemplate.html',
  'models/login/loginModal'
  ], function($, _, Backbone, loginTemplate, LoginModel){
    
    var LoginView = Backbone.View.extend({

      el : $("#page"),
      events: {
        'submit .edit-login-form': 'login'
      },

      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);


      },
      login: function (ev) {
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
      },
      render: function () {
        var that = this;
        var template = _.template(loginTemplate);
        //$('#login-template').html(template); 
        that.$el.html(template);
        return that;
      }
    });    
  return LoginView;
});
