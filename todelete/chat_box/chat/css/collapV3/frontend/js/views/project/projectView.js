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
  'text!templates/navbar/navbarTemplate.html',
  'text!templates/ninja/ninjaLPTemplate.html'
  ], function($, _, Backbone, ProjectCollection, ProjeclWLCollection, ProjectWithoutLoginTemplate, ProjectTemplate, ProjectRPWLTemplate, NavbarprojectWLTemplate, NavbarTemplate, LeftTemplate){
    
    var ForgetpasswordView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      rightpanel : $("#right-panel"),
      leftpanel : $("#left-panel"),
      events: {
        'click li': 'switchTab'
      },
      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);
      },
      switchTab: function(ev) { 
        var selectedTab = ev.currentTarget;
        this.$('li.active').removeClass('active');
        this.$(selectedTab).addClass('active');
      },
      render: function () {
        var that = this;
        $("#divider").removeClass('divider');
        $("#divider2").removeClass('divider');
        $("#column2").removeClass('col-md-9');
        $("#column3").removeClass('col-md-1');
        $("#column1").removeClass('col-md-1');
        $("#column2").addClass('col-md-6');
        $("#column3").addClass('col-md-2');
        $("#column1").addClass('col-md-2');
        document.getElementById("column1").style.width = "220px";
        var template = _.template(ProjectWithoutLoginTemplate);
        var navtemplate = _.template(NavbarprojectWLTemplate);
        var RPtemplate = _.template(ProjectRPWLTemplate);
        var LPtemplate = _.template(LeftTemplate);
        that.$el.html(template);
        this.navel.html(navtemplate);
        this.rightpanel.html(RPtemplate);
        this.leftpanel.html(LPtemplate);
        //$("#registerNav").addClass('active');
        document.getElementById("body").style.backgroundColor = "#FCFCFC";
        return that;
      }
    });    
  return ForgetpasswordView;
});
