define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var OrganizationChannelDatafieldModel = Backbone.Model.extend({
 	
 	initialize: function(options) {
    	this.orgId = options.orgId;
    	this.channel = options.name;
    	this.id = options.fieldId;
  	},
 	
 	url : function() {
 		if(this.id == null)
 			return window.BASE_URL+'/organizations/'  + this.orgId + '/channels/' + this.channel + '/fields';
        return window.BASE_URL+'/organizations/' + this.orgId + '/channels/' + this.channel + '/fields/' + this.id ;
      } 
    
    });

  return OrganizationChannelDatafieldModel;

});
