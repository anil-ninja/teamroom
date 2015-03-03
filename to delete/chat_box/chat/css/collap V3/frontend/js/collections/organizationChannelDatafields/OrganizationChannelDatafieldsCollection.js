define([
  'underscore',
  'backbone',
  'models/organizationChannelDatafield/OrganizationChannelDatafieldModel'
], function(_, Backbone, OrganizationChannelDatafieldModel){

  var OrganizationChannelDatafieldsCollection = Backbone.Collection.extend({
      
      model: OrganizationChannelDatafieldModel,

      initialize : function(options) {
        
        this.org_id = options.id;
        this.channel_name = options.name;
        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/organizations/'+ this.org_id +'/channels/' + this.channel_name + '/fields';
      }        
     
  });

  return OrganizationChannelDatafieldsCollection;

});
