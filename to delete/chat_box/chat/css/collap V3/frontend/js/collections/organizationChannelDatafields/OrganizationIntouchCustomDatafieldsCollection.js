define([
  'underscore',
  'backbone',
  'models/organizationChannelDatafield/OrganizationChannelDatafieldModel'
], function(_, Backbone, OrganizationChannelDatafieldModel){

  var OrganizationIntouchCustomDatafieldsCollection = Backbone.Collection.extend({
      
      model: OrganizationChannelDatafieldModel,

      initialize : function(options) {
        
        this.org_id = options.id;
        //this.channel_name = options.name;
        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/intouch-customfields/'+ this.org_id ;
      }        
     
  });

  return OrganizationIntouchCustomDatafieldsCollection;

});
