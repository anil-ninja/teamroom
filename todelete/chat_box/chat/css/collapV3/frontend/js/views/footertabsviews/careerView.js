define([
  'jquery',
  'underscore',
  'backbone',
  'text!templates/footertabstemplates/careerTemplate.html',
  'text!templates/navbar/navbarlogin.html'
  ], function($, _, Backbone, careerTemplate, navbarTemplate){
    
    var CareerView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);
      },
      render: function () {
        var that = this;
        var template = _.template(careerTemplate);
        var navtemplate = _.template(navbarTemplate);
        that.$el.html(template);
        this.navel.html(navtemplate);
        //$("#registerNav").addClass('active');
        document.getElementById("body").style.backgroundImage = "none";
        return that;
      }
    });    
  return CareerView;
});
