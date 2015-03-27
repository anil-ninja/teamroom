define([
  'underscore',
  'backbone',
  'models/organizationChannelDatafield/OrganizationChannelDatafieldModel'
], function(_, Backbone, OrganizationChannelDatafieldModel){

  var OrganizationFacebookChannelFieldsCollection = Backbone.Collection.extend({
      
      model: OrganizationChannelDatafieldModel,

      initialize : function(options) {
        
        //this.org_id = options.id;
        //this.channel_name = options.name;
        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/facebook-fields/' ;
      }        
     
  });

  return OrganizationFacebookChannelFieldsCollection;

});
