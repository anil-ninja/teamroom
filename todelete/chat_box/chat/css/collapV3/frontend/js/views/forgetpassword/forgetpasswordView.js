define([
  'jquery',
  'underscore',
  'backbone',
  'text!templates/forgetpassword/forgetpasswordTemplate.html',
  'text!templates/navbar/navbarlogin.html'
  ], function($, _, Backbone, forgetpasswordTemplate, navbarTemplate){
    
    var ForgetpasswordView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);
      },
      render: function () {
        var that = this;
        var template = _.template(forgetpasswordTemplate);
        var navtemplate = _.template(navbarTemplate);
        that.$el.html(template);
        this.navel.html(navtemplate);
        //$("#registerNav").addClass('active');
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return ForgetpasswordView;
});
