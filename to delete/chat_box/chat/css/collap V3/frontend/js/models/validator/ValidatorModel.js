define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ValidatorModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/validators';
        return window.BASE_URL+'/validators/'+ this.id;
     } 
     
    });

  return ValidatorModel;

});
