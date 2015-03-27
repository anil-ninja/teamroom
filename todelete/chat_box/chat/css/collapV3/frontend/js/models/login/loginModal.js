define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var LoginModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
        return "http://auth.loc.dpower4.com/v0/auth";
      } 
    });

  return LoginModel;

});