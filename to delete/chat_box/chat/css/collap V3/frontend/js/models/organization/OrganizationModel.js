define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var OrganizationModel = Backbone.Model.extend({
 	
 	initialize: function(options) {
    	this.id = options.id;
  	},
 	
 	url : function() {
 		if(this.id == null)
 			return window.BASE_URL+'/organizations';
        return window.BASE_URL+'/organizations/'+ this.id;
      } 
    
    });

  return OrganizationModel;

});
