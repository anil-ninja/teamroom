define([
  'underscore',
  'backbone',
  'models/organizationChannel/OrganizationChannelModel'
], function(_, Backbone, OrganizationChannelModel){

  var OrganizationChannelsCollection = Backbone.Collection.extend({
      
      model: OrganizationChannelModel,

      initialize : function(options) {
        
        this.org_id = options.id;
        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/organizations/'+ this.org_id +'/channels';
      }        
     
  });

  return OrganizationChannelsCollection;

});
