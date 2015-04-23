define([
  'jquery',
  'underscore',
  'backbone',
  'collections/userprojects/userprojectsCollection',
  'text!templates/notification/notificationTemplate.html',
  'text!templates/ninja/ninjaRPTemplate.html',
  'text!templates/ninja/ninjaLPTemplate.html',
  'text!templates/userlinks/friendlist.html',
  'text!templates/navbar/navbarTemplate.html'
  ], function($, _, Backbone, UserprojectsCollection, NotificationTemplate, NinjaRPTemplate, NinjaLPTemplate, Friendlist, NavbarTemplate){
    
    var ForgetpasswordView = Backbone.View.extend({

      el : $("#page"),
      navel : $("#navbar"),
      rightpanel : $("#right-panel"),
      leftpanel : $("#left-panel"),
      events: {
        
      },
      initialize : function() {
        var that = this;
        that.bind("reset", that.clearView);
        $(window).scroll(function(event) {
          if ($(window).scrollTop() == ($(document).height() - window.innerHeight)) {
            //newfetch();
          }
        });
      },
      /*newfetch : function(){
        alert("hi");
      },*/
      render: function () {
        var that = this;
        var userprojects = new UserprojectsCollection();
        userprojects.fetch({
        
          /*beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          } ,*/
          success: function (userprojects) {  
            console.log(userprojects);
            projectsData = userprojects.models[0].attributes.data.projects;
            var LPtemplate = _.template(NinjaLPTemplate, {projects : projectsData});
            that.leftpanel.html(LPtemplate);
            return that;
          },
          error: function (userprojects, response) {
            var status = response.status;
            
            if(status == "401"){
              alert("Please login first");
              window.app_router.navigate('default', {trigger:true});
            }
            else {
              alert("No data available");
            }
          }
        });
        /*$("#divider").removeClass('divider');
        $("#divider2").removeClass('divider');*/
        $("#column2").removeClass('col-md-9');
        $("#column3").removeClass('col-md-1');
        $("#column1").removeClass('col-md-1');
        $("#column2").addClass('col-md-6');
        $("#column3").addClass('col-md-2');
        $("#column1").addClass('col-md-2');
        document.getElementById("column1").style.width = "220px";
        var template = _.template(NotificationTemplate);
        var navtemplate = _.template(NavbarTemplate);
        var RPtemplate = _.template(NinjaRPTemplate);
        that.$el.html(template);
        this.navel.html(navtemplate);
        this.rightpanel.html(RPtemplate);
        //$("#registerNav").addClass('active');
        document.getElementById("body").style.backgroundColor = "#FCFCFC";
        $(".row").append(Friendlist);
        return that;
      }
    });    
  return ForgetpasswordView;
});
