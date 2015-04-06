define([
  'jquery',
  'underscore',
  'backbone',
  'collections/ninja/ninjaCollection',
  'text!templates/ninja/ninjaTemplate.html',
  'text!templates/ninja/ninjaRPTemplate.html',
  'text!templates/ninja/ninjaLPTemplate.html',
  'text!templates/navbar/navbarTemplate.html'
  ], function($, _, Backbone, NinjalCollection, NinjaTemplate, NinjaRPTemplate, NinjaLPTemplate, NavbarTemplate){
    
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
            newfetch();
          }
        });
      },
      newfetch : function(){
        alert("hi");
      },
      render: function () {
        var that = this;
        /*$("#divider").removeClass('divider');
        $("#divider2").removeClass('divider');*/
         $("#column2").removeClass('col-md-9');
        $("#column3").removeClass('col-md-1');
        $("#column1").removeClass('col-md-1');
        $("#column2").addClass('col-md-7');
        $("#column3").addClass('col-md-2');
        $("#column1").addClass('col-md-2');
        var template = _.template(NinjaTemplate);
        var navtemplate = _.template(NavbarTemplate);
        var RPtemplate = _.template(NinjaRPTemplate);
        var LPtemplate = _.template(NinjaLPTemplate);
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
