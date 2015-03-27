define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var OrganizationChannelMigrationModel = Backbone.Model.extend({
 	
 	initialize: function(options) {
    	this.orgId = options.orgId;
    	this.channel = options.channel;
  	},
 	
 	url : function() {
 		return window.BASE_URL+'/organizations/' + this.orgId + '/channels/' + this.channel + '/migrate/start';
      } 
    
    });

  return OrganizationChannelMigrationModel;

});
