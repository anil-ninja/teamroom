define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var OrganizationChannelModel = Backbone.Model.extend({
 	
 	initialize: function(options) {
    	this.orgId = options.orgId;
    	this.channel = options.channel;
  	},
 	
 	url : function() {
 		if(this.channel == null)
 			return window.BASE_URL+'/organizations'  + this.orgId + '/channels' ;
        return window.BASE_URL+'/organizations/' + this.orgId + '/channels/' + this.channel + '/fields';
      } 
    
    });

  return OrganizationChannelModel;

});
