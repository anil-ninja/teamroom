define([
  'jquery',
  'underscore',
  'backbone',
  'search',
  'collections/project/ProjectCollection',
  'collections/project/ProjeclWLCollection',
  'text!templates/project/projectWithoutLoginTemplate.html',
  'text!templates/project/projectTemplate.html',
  'text!templates/project/projectRPWLTemplate.html',
  'text!templates/ninja/ninjaLPTemplate.html'
  ], function($, _, Backbone, search, ProjectCollection, ProjeclWLCollection, ProjectWithoutLoginTemplate, ProjectTemplate, ProjectRPWLTemplate, LeftTemplate){
    
    var ForgetpasswordView = Backbone.View.extend({

      el : $("#page"),
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
        $("#column2").addClass('col-md-7');
        $("#column3").addClass('col-md-2');
        $("#column1").addClass('col-md-2');
        var template = _.template(ProjectWithoutLoginTemplate);
        var RPtemplate = _.template(ProjectRPWLTemplate);
        var LPtemplate = _.template(LeftTemplate);
        that.$el.html(template);
        $("#nav-tabs").html("<li id='loginNav'><a href='#/login' class='btn btn-white' style='color: #0CD85E;'> Create Project </a></li><li id='loginNav'><a href='#/login' style='color: #000;'> Login </a></li><li id='registerNav'><a href='#/register' style='color: #000;'> Register </a></li>");
        this.rightpanel.html(RPtemplate);
        this.leftpanel.html(LPtemplate);
        document.getElementById("body").style.backgroundColor = "#FCFCFC";
        return that;
      }
    });    
  return ForgetpasswordView;
});
