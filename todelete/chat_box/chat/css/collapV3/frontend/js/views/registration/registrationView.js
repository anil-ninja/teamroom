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
      /*events: {
        'submit .edit-login-form': 'login'
      },*/

      initialize : function() {
        $("#right-panel").html("");
        var that = this;
        that.bind("reset", that.clearView);
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
