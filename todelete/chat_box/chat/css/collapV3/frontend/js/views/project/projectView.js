define([
  'jquery',
  'underscore',
  'backbone',
  'collections/project/ProjectCollection',
  'collections/project/ProjeclWLCollection',
  'text!templates/project/projectWithoutLoginTemplate.html',
  'text!templates/project/projectTemplate.html',
  'text!templates/project/projectRPWLTemplate.html',
  'text!templates/navbar/navbarprojectWLTemplate.html',
  'text!templates/navbar/navbarprojectTemplate.html'
  ], function($, _, Backbone, ProjectCollection, ProjeclWLCollection, ProjectWithoutLoginTemplate, ProjectTemplate, ProjectRPWLTemplate, NavbarprojectWLTemplate, NavbarprojectTemplate){
    
    var ForgetpasswordView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      rightpanel : $("#right-panel"),
      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);
      },
      render: function () {
        var that = this;
        $("#divider").removeClass('divider');
        $("#divider2").removeClass('divider');
        var template = _.template(ProjectWithoutLoginTemplate);
        var navtemplate = _.template(NavbarprojectWLTemplate);
        var RPtemplate = _.template(ProjectRPWLTemplate);
        that.$el.html(template);
        this.navel.html(navtemplate);
        this.rightpanel.html(RPtemplate);
        //$("#registerNav").addClass('active');
        document.getElementById("body").style.backgroundColor = "#FCFCFC";
        return that;
      }
    });    
  return ForgetpasswordView;
});
